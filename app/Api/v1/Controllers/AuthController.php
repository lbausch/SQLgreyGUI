<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use GuzzleHttp\Client;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use League\OAuth2\Server\AuthorizationServer;

class AuthController extends Controller
{
    /**
     * Authentication.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Illuminate\Auth\AuthManager $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request, AuthManager $auth, AuthorizationServer $server)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $login = $auth->guard()->attempt([
            'email' => $email,
            'password' => $password,
        ]);

        if (!$login) {
            return;
        }

        $http = new Client();

        // @TODO: use config() and env()
        $response = $http->post(url('/').'/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'WNZpOsPcdFjHWHFViMTGKXLaTFP1x7P0QRDGYxC4',
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);

        $token_data = json_decode($response->getBody()->getContents(), $assoc = true);

        return $this->respond($token_data);
    }
}
