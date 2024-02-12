<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper('url');
		
		$data = [
            'title' => 'Evoting home page',

            // links
            'register' => 'register',
        ];


		return view('header',$data)
                .view('welcome_message')
                .view('footer');
    }
}
