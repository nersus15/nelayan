<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Home extends BaseController
{
    public function index()
    {
        $data = [];
        $model = new BarangModel();
        $data['barang'] = $model->getWithTerjual();
        return view('templates/front', $data);
    }
    function dashboard(){
        $data = [
            'activeMenu' => 'dashboard'
        ];
        return view('templates/sbadmin', $data);
    }
}
