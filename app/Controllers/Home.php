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
        $transaksiModel = new \App\Models\TransaksiModel();
        $db = \Config\Database::connect();
        $waktu = waktu(null, MYSQL_DATE_FORMAT);
        $tgl1 = substr($waktu, 0, 7) . '01';
        $tglHariIni = intval( substr($waktu, 8, 9));
        $tmp = $transaksiModel->select('jumlah, transaksi.diupdate, status')
            ->join('barang', 'barang.id = transaksi.barang')
            ->where("transaksi.diupdate BETWEEN '$tgl1' AND '$waktu'", null, false)
            ->where('barang.pemilik', sessiondata('login', 'username'))
            ->findAll();
        $dataPenjualan = [];
        $tBarang = $db->table('barang')->where('pemilik', sessiondata('login', 'username'))->get()->getNumRows();
        $tSelesai = $db->table('transaksi')->join('barang', 'barang.id = transaksi.barang')->where('status', 'selesai')->where('barang.pemilik', sessiondata('login', 'username'))->get()->getNumRows();
        $tBatal = $db->table('transaksi')->join('barang', 'barang.id = transaksi.barang')->where('status', 'batal')->where('barang.pemilik', sessiondata('login', 'username'))->get()->getNumRows();
        
        for ($i=1; $i <= $tglHariIni ; $i++) { 
           $dataPenjualan[$i] = [
                'selesai' => 0,
                'batal' => 0
           ];
        }

        foreach ($tmp as $key => $value) {
            $tanggal = intval(substr($value['diupdate'], 8, 9));
            $status = $value['status'];
            $jumlah = $value['jumlah'];
            if(isset($dataPenjualan[$tanggal])){
                $dataPenjualan[$tanggal][$status] += $jumlah;
            }else{
                $dataPenjualan[$tanggal][$status] =  [
                    'selesai' => 0,
                    'batal' => 0
               ];
               $dataPenjualan[$tanggal][$status] += $jumlah;
            }
        }

        $data = [
            'activeMenu' => 'dashboard',
            'dataHeader' => [
                'extra_js' => [
                    'vendor/chart.js/Chart.min.js'
                ],
                'extra_css' => [
                    'vendor/chart.js/Chart.css'
                ]
            ],
            'contents' => [
                'dashboard' => [
                    'view' => 'pages/dashboard',
                    'data' => ['data' => $dataPenjualan, 'tBarang' => $tBarang, 'tSelesai' => $tSelesai, 'tBatal' => $tBatal]
                ]
            ]
        ];
        return view('templates/sbadmin', $data);
    }
    
}
