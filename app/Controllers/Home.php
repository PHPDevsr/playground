<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper(['recaptcha', 'minifyku']);

        $data = [
            'scriptTag' => getScriptTag(),
            'widgetTag' => getWidget(),
        ];

        $captcha = $this->request->getPost('g-recaptcha-response');
        $response = verifyResponse($captcha);

        if (isset($response['success']) and $response['success'] === true) {
            echo "You got it!";
        }

        return view('welcome_message', $data);
    }
}
