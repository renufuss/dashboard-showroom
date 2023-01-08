<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Layout';
        return view('Layout/index', $data);
    }
}
