<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Goutte\Client;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $credentials = $this->Cloudinary_register($data['username'], $data['email'], $data['password']);
        $user = array_merge($data, $credentials);
        return User::create($user);
    }

    function Cloudinary_register($form_user_name, $form_user_email, $form_user_password)
    {
        $plan_id = 'free';
        $billing_cycle = 'monthly';
        $user_name = $form_user_name;
        $user_email = $form_user_email;
        $user_password = $form_user_password;
        $account_country = 'RU';
        $account_phone = '';
        $customer_name = '';

        $client = new Client();

        //Retrieve data
        $crawler = $client->request('GET', 'https://cloudinary.com/users/register/free');
        $csrf = $crawler->filter('meta[name=csrf-token]')->attr('content');
        $data['cloud_name'] = $crawler->filter('.cloud_name_value')->html();

        //Send user data
        $form = $crawler->selectButton('Create Account')->form();
        $crawler = $client->submit($form, array(
            'authenticity_token' => $csrf,
            'plan_id' => $plan_id,
            'billing_cycle' => $billing_cycle,
            'user[name]' => $user_name,
            'user[email]' => $user_email,
            'user[password]' => $user_password,
            'account[country]' => $account_country,
            'account[phone]' => $account_phone,
            'customer[name]' => $customer_name,
            'customer[cloud_name]' => $data['cloud_name'],
        ));

        //Retrieve credentials
        $client = new Client();
        $crawler = $client->request('GET', 'https://cloudinary.com/users/login_update');
        $authenticity_token = $crawler->filter('meta[name=csrf-token]')->attr('content');
        $logInForm = $crawler->selectButton('sign in')->form();
        $crawler = $client->submit($logInForm, array(
            'authenticity_token' => $authenticity_token,
            'user_session[email]' => $user_email,
            'user_session[password]' => $user_password,
        ));
        $crawler = $client->request('GET', 'https://cloudinary.com/console/lui');
        $data['api_key'] = $crawler->filter('div[class=label]:contains("API Key:") + div[class=value] > input')->attr('value');
        $data['api_secret'] = $crawler->filter('div[class=label]:contains("API Secret:") + div[class=value] > input')->attr('data-actual-value');
        return $data;
    }
}
