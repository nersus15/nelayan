<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use Exception;

use function PHPUnit\Framework\throwException;

class Barang extends BaseController
{
    private $barangModel;
    function __construct()
    {
        $this->barangModel = new BarangModel();
    }
    public function keluar()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $dataPenjualan = $transaksiModel->select('hasil_tangkapan.nama, hasil_tangkapan.harga, transaksi.*')
            ->join('hasil_tangkapan', 'hasil_tangkapan.id = transaksi.barang')
            // ->where('hasil_tangkapan.nelayan', sessiondata('login', 'username'))
            ->orderBy('transaksi.dibuat', 'DESC')
            ->findAll();


        $wilayah = getWil();
        $session = session();
        $respnse = $session->getFlashdata('response');
        $data = [
            'dataHeader' => [
                'title' => 'Barang Keluar',
                'extra_js' => [
                    'vendor/dropzone/dropzone.js',
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
                    "vendor/lightbox/lightbox.js",
                ],
                'extra_css' => [
                    "vendor/lightbox/lightbox.css",
                    'vendor/dropzone/basic.css',
                    'vendor/dropzone/dropzone.css'
                ]
            ],
            'dataFooter' => [
                'extra_js' => [
                    'js/pages/penjualan.js'
                ]
            ],
            'contents' => [
                'dt-penjualan' => [
                    'view' => 'components/datatables',
                    'data' => [
                        'desc' => $respnse,
                        'header' => [
                            'No' => function ($rec, $k, $i) {
                                return $i;
                            },
                            'Bukti Bayar' => function($rec, $k, $i){
                                $sudahBayar = assetsExistByName(ASSETS_PATH . 'img/bayar/' . $rec['token'], ['png', 'jpg', 'jpeg'], true);
                                if(!$sudahBayar){
                                    return 'Belum Bayar';
                                }
                                return '<a  href="'. assets_url('img/bayar/' . $rec['token'])  . '.' . $sudahBayar.'" data-lightbox="image-'.$rec['token'] . '-' .  $i .'" data-title="Bukti Pembayaran"> <img style="width:100px;height:auto" src="' . assets_url('img/bayar/' . $rec['token'])  . '.' . $sudahBayar. '"></a>';
                            },
                            'Bukti Refund' => function($rec, $k, $i){
                                $sudahRefund = assetsExistByName(ASSETS_PATH . 'img/refund/' . $rec['id'], ['png', 'jpg', 'jpeg'], true);
                                if(!$sudahRefund){
                                    return $rec['status'] == 'batal' ? 'Tidak Di Refund' : '';
                                }
                                return '<a  href="'. assets_url('img/refund/' . $rec['id'])  . '.' . $sudahRefund.'" data-lightbox="image-'.$rec['id'] . '-' .'" data-title="Bukti Refund"> <img style="width:100px;height:auto" src="' . assets_url('img/refund/' . $rec['id'])  . '.' . $sudahRefund. '"></a>';
                            },
                            'Barang' => function ($rec) {
                                return '<a href="' . base_url('barang/info/' . $rec['barang']) . '">' . $rec['nama'] . '</a>';
                            },
                            'Harga' => function ($rec) {
                                return rupiah_format($rec['harga']);
                            },
                            'Cara Pengambilan' => function($rec){
                                return $rec['jenis'] == 'cod' ? 'COD - Ongkir Rp.5000,00' : 'Ambil Sendiri';
                            },
                            'Jumlah' => 'jumlah',
                            'Nama Pembeli' => 'pembeli',
                            'No.Hp' => 'hp',
                            'Alamat' => function ($rec) use ($wilayah) {
                                $desa = '';
                                $kecamatan = '';
                                $alamat = $rec['alamat_pembeli'];
                                if (level_wilayah($alamat) == 3)
                                    $kecamatan == 'Kecamatan ' . $wilayah['kecamtan'][$alamat];
                                else {
                                    $desa = 'Desa ' . $wilayah['desa'][$alamat] . ', ';
                                    $kecamatan = $wilayah['kecamatan'][substr($alamat, 0, 8) . '.0000'];
                                }

                                return $desa . $kecamatan;
                            },
                            'Detail Alamat' => 'detail_alamat_pembeli',
                            'Status' => function ($rec) {
                                $flag = 'bg-warning';
                                $status = $rec['status'];
                                if ($status == 'siap')
                                    $flag = 'bg-info';
                                elseif ($status == 'selesai')
                                    $flag = 'bg-success';
                                elseif ($status == 'batal')
                                    $flag = 'bg-danger';

                                $status = '<span class="badge ' . $flag . '">' . ucfirst($rec['status']) . '</span>';
                                return $status;
                            },
                            'Actions' => function ($rec) {
                                $sudahBayar = assetsExistByName(ASSETS_PATH . 'img/bayar/' . $rec['token'], ['png', 'jpg', 'jpeg']);
                                $btnTerima = $sudahBayar ? '<a href="' . base_url('terima/' . $rec['id']) . '" data-id="' . $rec['id'] . '" class="btn btn-info col-sm-8">Terima</a>' : '';
                                $btnCancel = '<a href="' . base_url('tolak') . '" data-id="' . $rec['id'] . '" class="btn batalkan-pesanan btn-warning col-sm-8">Tolak</a>';
                                $btnInfo = '<button data-id="' . $rec['id'] . '" class="info-pesanan btn-sm btn btn-info">Info Pembatalan</button>';

                                return $rec['status'] == 'batal' ? $btnInfo : ($rec['status'] == 'proses' ? '<div class="row" style="justify-content: center;row-gap: 6px;">' . $btnTerima . $btnCancel . '</div>' : '');
                            }
                        ],
                        'data' => $dataPenjualan
                    ]
                ],
                'modal' => [
                    'view' => 'pages/form_pembatalan',
                    'data' => [
                        'pembatal' => 'penjual'
                    ]
                ],
                

            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function info($id)
    {
        $model = new BarangModel();
        $dataBarang = $model->getWithTerjual(null, $id)[$id];
        $data = [
            'dataHeader' => [
                'title' => $dataBarang->nama,
                'extra_js' => [],
            ],
            'dataFooter' => [
                'extra_js' => [
                    'js/pages/penjualan.js'
                ]
            ],
            'contents' => [
                'dt-penjualan' => [
                    'view' => 'pages/info_barang',
                    'data' => [
                        'barang' => $dataBarang
                    ]
                ],

            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function list()
    {
        $dataBarang = $this->barangModel->getWithTerjual();
        $session = session();
        $response = $session->getFlashdata('response');
        $wilayah = getWil();
        $data = [
            'activeMenu' => 'barang',
            'dataHeader' => [
                'title' => 'Daftar Barang Masuk',
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
                        'desc' => !empty($response) ? $response : 'Data Barang Masuk <a href="' . base_url('barang/tambah') . '" class="btn btn-primary">Tambah<a/>',
                        'header' => [
                            'No' => function ($rec, $index, $row) {
                                return $row;
                            },
                            'Gambar' => function ($rec) {
                                $photo = !empty($rec->photo) ? $rec->photo : 'contoh.jpg';
                                return '<img width="100px" src="' . assets_url('img/barang/' . $photo) . '" class="img-fluid rounded thumbnail-image">';
                            },
                            'Nama' => 'nama',
                            'Deskripsi' => 'deskripsi',
                            'Harga' => function ($rec) {
                                return rupiah_format($rec->harga);
                            },
                            'Terjual/Stok' => function ($rec) {
                                $terjual = $rec->terjual;
                                $stok = $rec->stok;
                                $satuan = $rec->satuan;
                                return $terjual . '/' . $stok . ' ' . ucfirst($satuan);
                            },
                            'Nelayan' => 'nama_lengkap',
                            'No. Hp' => 'hp',
                            'Alamat' => function ($rec) use ($wilayah) {
                                $text_alamat = $rec->detail_alamat;
                                $alamat = $rec->alamat;
                                if (!empty($text_alamat)) $text_alamat .= ', ';
                                if (!empty($alamat) && level_wilayah($alamat) == 3)
                                    $text_alamat .= ' Kecmatan ' . $wilayah['kecamatan'][$alamat];
                                elseif (!empty($alamat) && level_wilayah($alamat) ==  4)
                                    $text_alamat .= ' Desa ' . $wilayah['desa'][$alamat] . ', Kec. ' . $wilayah['kecamatan'][substr($alamat, 0, 8) . '.0000'];

                                return $text_alamat;
                            },
                            'Actions' => function ($rec) {
                                $buttons = '<div class="row" style="text-align:center">
                                    <div clas="col-sm-12 col-md-6 mt-2"><a class="btn btn-warning update-barang" href="' . base_url('barang/update/' . $rec->id) . '">' . 'Update' . '</a></div>
                                    <div clas="col-sm-12 col-md-6 mt-2"><a class="btn btn-danger delete-barang" href="' . base_url('barang/delete/' . $rec->id) . '">' . 'Delete' . '</a></div>
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
    function tambah()
    {
        $session = session();
        $response = $session->getFlashdata('response');
        $nelayanModel = new \App\Models\NelayanModel();
        $nelayan = $nelayanModel->findAll();

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
                'extra_js' => []
            ],
            'contents' => [
                'barang' => [
                    'view' => 'pages/tambah_barang',
                    'data' => [
                        'mode' => 'baru',
                        'desc' => $response,
                        'nelayan' => $nelayan
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function update($id)
    {
        $session = session();
        $response = $session->getFlashdata('response');
        $dataBarang = $this->barangModel->find($id);
        $nelayanModel = new \App\Models\NelayanModel();
        $nelayan = $nelayanModel->findAll();
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
                'extra_js' => []
            ],
            'contents' => [
                'barang' => [
                    'view' => 'pages/tambah_barang',
                    'data' => [
                        'mode' => 'edit',
                        'desc' => $response,
                        'dataBarang' => $dataBarang,
                        'nelayan' => $nelayan
                    ]
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }
    function post_tambah()
    {
        $post = $_POST;
        $mode = $post['mode'];
        if (!in_array($mode, ['baru', 'edit']))
            throwException(new Exception("mode tidak valid", 403));

        $data = [
            'id' => random(8),
            'nama' => $post['nama'],
            'dibuat' => waktu(),
            'diupdate' => waktu(),
            'deskripsi' => $post['desc'],
            'stok' => $post['stok'],
            'satuan' => $post['satuan'],
            'harga' => $post['harga'],
            'nelayan' => $post['nelayan'],
        ];
        if (isset($post['photo']) && !empty($post['photo']))
            $data['photo'] = $post['photo'];

        if ($mode == 'edit') {
            unset($data['id'], $data['dibuat']);
        }

        try {
            if ($mode == 'baru')
                $this->barangModel->insert($data);
            elseif ($mode == 'edit')
                $this->barangModel->update($post['id'], $data);
            return redirect()->to(base_url(($mode == 'baru' ? 'barang/tambah' : 'barang/update/' . $post['id'])))->with('response', 'Berhasil ' . ($mode == 'baru' ? 'tambah' : 'Update') . ' barang' . ($mode == 'edit' ? $post['id'] : null));
        } catch (\Throwable $th) {
            return redirect()->to(base_url('barang/tambah'))->with('response', $th->getMessage())->with('postData', $post);
        }
    }
    function delete($id)
    {
        $barang = $this->barangModel->where('id', $id)->find();
        if (empty($barang))
            return redirect()->to(base_url('barang'))->with('response', 'Barang tidak ditemukan');

        $this->barangModel->delete($id);
        return redirect()->to(base_url('barang'))->with('response', 'Berhasil menghapus barang');
    }
}
