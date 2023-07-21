<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Nelayan extends BaseController
{
    private $nelayanModel;
    public function __construct()
    {
        $this->nelayanModel = new \App\Models\NelayanModel();
    }
    public function index()
    {
        $wilayah = getWil();
        $session = session();
        $respnse = $session->getFlashdata('response');
        $data = [
            'dataHeader' => [
                'title' => 'Data Nelayan',
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
                ],
            ],
            'dataFooter' => [
                'extra_js' => [
                ]
            ],
            'contents' => [
                'dt-nelayan' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'createdRow' => load_script('pages/nelayan'),
                        'desc' => $respnse . '<button id="tambah-nelayan" class="btn btn-success btn-sm"> Tambah </button>',
                        'header' => [
                            'No' => function ($rec, $k, $i) {
                                return $i;
                            },
                            'Nama' => 'nama_lengkap',
                            'No.Hp' => 'hp',
                            'Alamat' => function ($rec) use ($wilayah) {
                                $text_alamat = $rec['detail_alamat'];
                                $alamat = $rec['alamat'];
                                if (!empty($text_alamat)) $text_alamat .= ', ';
                                if (!empty($alamat) && level_wilayah($alamat) == 3)
                                    $text_alamat .= ' Kecmatan ' . $wilayah['kecamatan'][$alamat];
                                elseif (!empty($alamat) && level_wilayah($alamat) ==  4)
                                    $text_alamat .= ' Desa ' . $wilayah['desa'][$alamat] . ', Kec. ' . $wilayah['kecamatan'][substr($alamat, 0, 8) . '.0000'];

                                return $text_alamat;
                            },
                            'Actions' => function ($rec) {
                                $btnUpdate = '<a data-id="' . $rec['id'] . '" class="btn update-nelayan btn-info col-sm-8">Update</a>';
                                $btnDelete = '<a href="' . base_url('nelayan/hapus/' . $rec['id']) . '" data-id="' . $rec['id'] . '" class="btn hapus-nelayan btn-warning col-sm-8">Hapus</a>';

                                return $btnUpdate . $btnDelete;
                            }
                        ],
                        'data' => $this->nelayanModel->findAll()
                    ]
                ],
                'modal' => [
                    'view' => 'pages/tambah_nelayan',
                    'data' => [
                        'wilayah' => $wilayah
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }

    function find($id)
    {
        $data = $this->nelayanModel->find($id);
        return $this->response->setJSON($data);
    }
    function save()
    {
        $post = $this->request->getPost();
        $data = [
            'nama_lengkap' => $post['nama'],
            'hp' => $post['hp'],
            'alamat' => isset($post['desa']) ? $post['desa'] : $post['kecamatan'],
            'detail_alamat' => $post['detail_alamat']
        ];
        $baru = empty($post['id']);
        // echo json_encode($baru);
        // die;
        try {
            if ($baru) {
                $this->nelayanModel->insert($data);
            } else {
                $this->nelayanModel->update($post['id'], $data);
            }
            return redirect()->to(base_url('nelayan'))->with('response', 'Berhasil update/tambah data');
        } catch (\Throwable $th) {
            return  redirect()->to(base_url('nelayan'))->with('response', $th->getMessage());
        }
    }

    function hapus($id){
        try {
            $this->nelayanModel->delete($id);
            return redirect()->to(base_url('nelayan'))->with('response', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->to(base_url('nelayan'))->with('response', $th->getMessage());
           
        }
    }
}
