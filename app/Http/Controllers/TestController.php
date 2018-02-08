<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 30.01.2018
 * Time: 22:53
 */

namespace App\Http\Controllers;

use Goutte\Client;

class TestController
{
    public function test()
    {
        $plan_id = 'free';
        $billing_cycle = 'monthly';
        $user_name = 'Yaroslav';
        $user_email = 'fghf99950@gmail.com';
        $user_password = 'Zxasqw123';
        $account_country = 'RU';
        $account_phone = '';
        $customer_name = '';

                $client = new Client();

                //Retrieve data
                $crawler = $client->request('GET', 'https://cloudinary.com/users/register/free');
                $csrf = $crawler->filter('meta[name=csrf-token]')->attr('content');
                $cloud_name = $crawler->filter('.cloud_name_value')->html();

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
                    'customer[cloud_name]' => $cloud_name,
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
        $API_KEY = $crawler->filter('div[class=label]:contains("API Key:") + div[class=value] > input')->attr('value');
        $API_SECRET = $crawler->filter('div[class=label]:contains("API Secret:") + div[class=value] > input')->attr('data-actual-value');
        dd($API_SECRET, $API_KEY);
    }

}