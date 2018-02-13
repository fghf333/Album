<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 12.02.2018
 * Time: 22:49
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Goutte\Client;

class RegisterController extends Controller
{
    function getForm()
    {
        return view('register');
    }

    function register(Request $request)
    {
        $data = array_merge($request->all(),
            $this->test($request->get('username'), $request->get('email'), $request->get('password')));
        unset($data['_token']);

        return redirect('register');
    }

    function test($form_user_name, $form_user_email, $form_user_password)
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