<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use Exception;

use function PHPUnit\Framework\throwException;

class Barang extends BaseController
{
    private $barangModel;
    function __construct() {
        $this->barangModel = new BarangModel();
    }
    public function index()
    {
        //
    }
    function list(){
        $dataBarang = $this->barangModel->getWithTerjual(sessiondata('login', 'username'));
        $session = session();
        $response = $session->getFlashdata('response');
        $data = [
            'activeMenu' => 'barang',
            'dataHeader' => [
                'title' => 'Daftar Barang ' . sessiondata('login', 'username'),
                'extra_js' => [
                    "vendor/datatables/jquery.dataTables.min.js",
                    "vendor/datatables-bs4/js/dataTables.bootstrap4.min.js",
                    "vendor/datatables-responsive/js/dataTables.responsive.min.js",
                    "vendor/datatables-responsive/js/responsive.bootstrap4.min.js",
                    "vendor/datatables-buttons/js/dataTables.buttons.min.js",
                    "vendor/datatables-buttons/js/buttons.bootstrap4.min.js",
                    "vendor/jszip/jszip.min.js",
                    "vendor/pdfmake/pdfmake.min.js",
                    "vendor/pdfmake/vfs_fonts.js",
                    "vendor/datatables-buttons/js/buttons.html5.min.js",
                    "vendor/datatables-buttons/js/buttons.print.min.js",
                    "vendor/datatables-buttons/js/buttons.colVis.min.js",
                ]
            ],
            'dataFooter' => [
                'extra_js' => [
                    'js/pages/barang.js'
                ]
            ],
            'contents' => [
                'barang' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'data' => $dataBarang,
                        'desc' => !empty($response) ? $response : 'Data Baran Hari Ini <a href="'. base_url('barang/tambah') .'" class="btn btn-primary">Tambah<a/>',
                        'header' => [
                            'No' => function($rec, $index, $row){return $row;},
                            'Gambar' => function($rec){
                                $photo = !empty($rec->photo) ? $rec->photo : 'contoh.jpg';
                                return '<img width="100px" src="'. assets_url('img/barang/' . $photo) .'" class="img-fluid rounded thumbnail-image">';
                            },
                            'Nama' => 'nama',
                            'Deskripsi' => 'deskripsi',
                            'Harga' => function($rec){return rupiah_format($rec->harga);},
                            'Terjual/Stok' => function($rec){
                                $terjual = $rec->terjual;
                                $stok = $rec->stok;
                                $satuan = $rec->satuan;
                                return $terjual . '/' . $stok . ' ' . ucfirst($satuan);
                            },
                            'Actions' => function($rec){
                                $buttons = '<div class="row" style="text-align:center">
                                    <div clas="col-sm-12 col-md-6 mt-2"><a class="btn btn-warning update-barang" href="barang/update/'.$rec->id.'">' . 'Update' . '</a></div>
                                    <div clas="col-sm-12 col-md-6 mt-2"><a class="btn btn-danger delete-barang" href="barang/delete/'.$rec->id.'">' . 'Delete' . '</a></div>
                                    </div>';
                                return $buttons;
                            }
                        ],
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function tambah(){
        $session = session();
        $response = $session->getFlashdata('response');
        $data = [
             'activeMenu' => 'barang',
            'dataHeader' => [
                'title' => 'Tambah Barang',
                'extra_js' => [
                    'vendor/dropzone/dropzone.js',
                    'vendor/inputmask/inputmask.js',
                    'vendor/inputmask/jquery.inputmask.js',
                ],
                'extra_css' => [
                    'vendor/dropzone/basic.css',
                    'vendor/dropzone/dropzone.css'
                ]
            ],
            'dataFooter' => [
                'extra_js' => [
                ]
            ],
            'contents' => [
                'barang' => [
                    'view' => 'pages/tambah_barang',
                    'data' => [
                        'mode' => 'baru',
                        'desc' => $response
                        
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function update($id){
        $session = session();
        $response = $session->getFlashdata('response');
        $dataBarang = $this->barangModel->find($id);
        $data = [
           'activeMenu' => 'barang',
            'dataHeader' => [
                'title' => 'Update Barang',
                'extra_js' => [
                    'vendor/dropzone/dropzone.js',
                    'vendor/inputmask/inputmask.js',
                    'vendor/inputmask/jquery.inputmask.js',
                ],
                'extra_css' => [
                    'vendor/dropzone/basic.css',
                    'vendor/dropzone/dropzone.css'
                ]
            ],
            'dataFooter' => [
                'extra_js' => [
                ]
            ],
            'contents' => [
                'barang' => [
                    'view' => 'pages/tambah_barang',
                    'data' => [
                        'mode' => 'edit',
                        'desc' => $response,
                        'dataBarang' => $dataBarang
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function post_tambah(){
        $post = $_POST;
        $mode = $post['mode'];
        if(!in_array($mode,['baru', 'edit']))
            throwException(New Exception("mode tidak valid", 403));

        $data = [
            'id' => random(8),
            'nama' => $post['nama'],
            'dibuat' =>waktu(),
            'diupdate' => waktu(),
            'deskripsi' => $post['desc'],
            'stok' => $post['stok'],
            'satuan' => $post['satuan'],
            'harga' => $post['harga'],
            'photo' => $post['photo'],
            'pemilik' => sessiondata('login', 'username')
        ];
        if($mode == 'edit'){
            unset($data['id'], $data['dibuat']);
        }

        try {
            if($mode == 'baru')
                $this->barangModel->insert($data);
            elseif($mode == 'edit')
                $this->barangModel->update($post['id'], $data);
            return redirect()->to(base_url(($mode == 'baru' ? 'barang/tambah' : 'barang/update/' . $post['id'])))->with('response', 'Berhasil '. ($mode == 'baru' ? 'tambah' : 'Update') .' barang' . ($mode == 'edit' ? $post['id'] : null));
        } catch (\Throwable $th) {
            return redirect()->to(base_url('barang/tambah'))->with('response', $th->getMessage())->with('postData', $post);
        }
    }
    function delete($id){
        $barang = $this->barangModel->where('pemilik', sessiondata('login', 'username'))->where('id', $id)->find();
        if(empty($barang))
            return redirect()->to(base_url('barang'))->with('response', 'Barang tidak ditemukan');
        
        $this->barangModel->delete($id);
        return redirect()->to(base_url('barang'))->with('response', 'Berhasil menghapus barang');
    }
}
