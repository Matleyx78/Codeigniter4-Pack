<?php

namespace App\Controllers\Test;

class Test extends BaseController
{
    // available to GET requests only
    public function index()
    {
        return view('test_2');
    }

    // available to POST requests only
    public function send()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'lastname' => $this->request->getPost('lastname'),
        ];

        return view('test_1', $data);
    }
} 