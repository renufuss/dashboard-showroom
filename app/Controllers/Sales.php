<?php

namespace App\Controllers;

class Sales extends BaseController
{
    public function index()
    {
        $data['title'] = 'Penjualan';
        return view('Sales/index', $data);
    }
}
