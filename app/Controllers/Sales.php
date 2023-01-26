<?php

namespace App\Controllers;

class Sales extends BaseController
{
    public function index()
    {
        $data['title'] = 'Layout';
        return view('Sales/index', $data);
    }
}
