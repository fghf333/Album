<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Goutte\Client;
use \GuzzleHttp\Client as Guzzle;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Cloudinary;
use Cloudinary\Uploader;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;


/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
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
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(Request $request)
    {

        if ($request->has('apiKey')) {

            $this->validate($request, [
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'apiKey' => 'required|string|min:15',
                'apiSecret' => 'required|string|min:20',
                'cloud' => 'required|string',
            ], [
                'apiKey.required' => 'Поле "API key" обязательно к заполнению.',
                'apiKey.min' => 'Неверное значение в поле "API key".',
                'apiSecret.required' => 'Поле "API secret" обязательно к заполнению.',
                'apiSecret.min' => 'Неверное значение в поле "API secret".',
                'cloud.required' => 'Поле "Cloud" обязательно к заполнению.',

            ]);

        } else {
            $this->validator($request->all())->validate();
        }

        $user = $this->create($request->all());

        if (gettype($user) === 'object') {

            event(new Registered($user));

            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        } else {
            $validator = Validator::make([], []);
            switch ($user) {
                case 'API key':
                    $validator->errors()->add('apiKey', 'Неверное значение в поле "API key".');
                    return back()->withErrors($validator)->withInput();
                    break;
                case 'API Secret':
                    $validator->errors()->add('apiSecret', 'Неверное значение в поле "API Secret".');
                    return back()->withErrors($validator)->withInput();
                    break;
                case 'Cloud name':
                    $validator->errors()->add('cloud', 'Неверное значение в поле "Cloud".');
                    return back()->withErrors($validator)->withInput();
                    break;
                case 'notUniqe':
                    $validator->errors()->add('email.cloudinary',
                        'Вы уже зарегестрированны в Cloudinary. Пожалуйста, заполните поля ниже.');
                    return back()->withErrors($validator)->withInput();
                    break;
                default:
                    return back()->withInput();
                    break;
            }
        }
    }


    /**
     * @param array $data
     * @return $this|bool|\Illuminate\Database\Eloquent\Model|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function create(array $data)
    {

        $data['password'] = Hash::make($data['password']);
        $data['old_password'] = $data['password'];
        $check = $this->spam_check($data['email']);
        if ($check) {
            if (!isset($data['apiKey'])) {
                $credentials = $this->Cloudinary_register($data['username'], $data['email'], $data['password']);
            } else {
                $credentials = [
                    'cloud_name' => $data['cloud'],
                    'api_key' => $data['apiKey'],
                    'api_secret' => $data['apiSecret'],
                ];
                $message = $this->credentials_check($credentials);
                if($message !== 'checked') {
                    return $message;
                }
            }

            if (array_key_exists('api_key', $credentials)) {
                $user = array_merge($data, $credentials);

                return User::create($user);
            } else {
                return 'notUniqe';
            }
        } else {
            return abort(599);
        }

    }

    /**
     * @param $email
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function spam_check($email)
    {
        $client = new Guzzle();

        $url = 'https://cleantalk.org/blacklists/?record=' . $email . '&action=get-api-response';

        $res = json_decode($client->request('GET', $url)->getBody()->getContents(), true);
        if (isset($res['data'][$email]['exists'])) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param $credentials
     * @return string
     */
    function credentials_check($credentials)
    {
        Cloudinary::config([
            'cloud_name' => $credentials['cloud_name'],
            'api_key' => $credentials['api_key'],
            'api_secret' => $credentials['api_secret'],
        ]);
        $error = '';
        $try = '';
        try {
            $try = Uploader::upload('images/logo.png');
        } catch (\Cloudinary\Error $e) {
            $message = $e->getMessage();

            if (stripos($message, 'api_key') || stripos($message, 'API key')) {
                $error = 'API key';
            }
            if (stripos($message, 'Signature')) {
                $error = 'API Secret';
            }
            if (stripos($message, 'cloud_name')) {
                $error = 'Cloud name';
            }

        }

        if (empty($error) && isset($try['public_id'])) {
            Uploader::destroy($try['public_id']);
            Cloudinary::reset_config();
            return 'checked';
        } else {
            Cloudinary::reset_config();
            return $error;
        }
    }

    /**
     * @param $form_user_name
     * @param $form_user_email
     * @param $form_user_password
     * @return array|mixed
     */
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

        $error = $crawler->filter('.error-msg')->each(function (Crawler $node) {
            $arr = false;
            $text = $node->text();
            if (!empty($text)) {
                $field = $node->siblings()->filter('.label-holder')->text();
                $arr[$field] = $text;
            }

            return $arr;
        });

        $error = array_filter($error);
        $error = array_shift($error);

        if (empty($error)) {
            //Retrieve credentials
            $data = $this->Cloudinary_login($user_email, $user_password);
            return $data;
        } else {
            return $error;
        }
    }

    /**
     * @param $form_user_email
     * @param $form_user_password
     * @return array|mixed
     */
    function Cloudinary_login($form_user_email, $form_user_password)
    {

        $user_email = $form_user_email;
        $user_password = $form_user_password;

        $client = new Client();
        $crawler = $client->request('GET', 'https://cloudinary.com/users/login_update');
        $authenticity_token = $crawler->filter('meta[name=csrf-token]')->attr('content');
        $logInForm = $crawler->selectButton('sign in')->form();
        $client->submit($logInForm, array(
            'authenticity_token' => $authenticity_token,
            'user_session[email]' => $user_email,
            'user_session[password]' => $user_password,
        ));

        $error = $crawler->filter('.error-msg')->each(function (Crawler $node) {
            $arr = false;
            $text = trim($node->html());
            if (!empty($text)) {
                $field = $node->siblings()->filter('.label-holder')->text();
                $arr[$field] = $text;
            }

            return $arr;
        });

        $error = array_filter($error);
        $error = array_shift($error);

        if (empty($error)) {

            $crawler = $client->request('GET', 'https://cloudinary.com/console/lui');
            $data['cloud_name'] = $crawler->filter('div[class=label]:contains("Cloud name:") + div[class=value] > input')->attr('value');
            $data['api_key'] = $crawler->filter('div[class=label]:contains("API Key:") + div[class=value] > input')->attr('value');
            $data['api_secret'] = $crawler->filter('div[class=label]:contains("API Secret:") + div[class=value] > input')->attr('data-actual-value');
            return $data;
        }
        return $error;
    }
}
