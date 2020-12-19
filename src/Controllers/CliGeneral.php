<?php

namespace Matleyx\CI4P\Controllers;

use App\Controllers\BaseController;

class CliGeneral extends BaseController
    {
    public function test_mail()
        {
        //test
        $email = \Config\Services::email();

        $email->setFrom('z@z.com', 'Your Name');
        $email->setTo('a@a.com');

        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        if ( $email->send() )
            {
            echo 'si';
        }
        else
            {
            echo 'no';
        };
        }

    }
