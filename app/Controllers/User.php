<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Files\File;

class User extends BaseController
{
    private $userModel;
    function __construct()
    {
        $this->userModel = new UserModel();
    }
    function profile()
    {
        $data = [
            'activeMenu' => '',
            'dataHeader' => [
                'title' => 'Profile',
                'extra_js' => [
                    'vendor/select2/js/select2.js'
                ],
                'extra_css' => [
                    'css/profile.css',
                    'vendor/select2/css/select2.css',
                    'vendor/select2-bootstrap4-theme/select2-bootstrap4.css'
                ]
            ],
            'contents' => [
                'dashboard' => [
                    'view' => 'pages/profile',
                    'data' => sessiondata()
                ]
            ]
        ];
        return view('templates/sbadmin', $data);
    }

    function update_profile()
    {
        $post = $this->request->getPost();
        $userModel = new \App\Models\UserModel();

        $username = $post['username'];
        $password = $post['password'];

        unset($post['username'], $post['password']);
        if (!empty($password)) {
            $post['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $post['alamat'] = empty($post['desa']) ? $post['kecamatan'] : $post['desa'];
        unset($post['kecamatan'], $post['desa']);
        $files = $this->request->getFiles();
        try {
            if (isset($files['photo'])) {
                $img = $this->request->getFile('photo');
                $nama = random(8) . '.' . getExt($img->getName(), true);
                if (!$img->hasMoved()) {
                    $filepath = $img->store(ASSETS_PATH . 'img/profile/', $nama);
                    new File($filepath);
                }
                $post['photo'] = $nama;
            }
            $userModel->update($username, $post);
        } catch (\Throwable $th) {
            return redirect()->to('profile')->with('response', $th->getMessage());
        }

        $session = session();
        $session->set('login', $post + ['username' => $username]);
        return redirect()->to('profile')->with('response', 'Berhasil memperbarui profile');
    }

    function login()
    {
        return view('pages/login');
    }
    function register()
    {
        $db = \Config\Database::connect();
        $dataWil = $db->table('wilayah')->get()->getResultArray();
        $desa = [];
        foreach ($dataWil as $key => $value) {
            if ($value['level'] < 4) continue;

            $kode = substr($value['id'], 0, 8);
            if (isset($desa[$kode])) {
                $desa[$kode][] = $value;
            } else {
                $desa[$kode] = [$value];
            }
        }
        $data = [
            'kec' => array_filter($dataWil, function ($arr) {
                return $arr['level'] == 3;
            }),
            'desa' => $desa
        ];

        return view('pages/register', $data);
    }
    function logout()
    {
        $session = session();
        $session->remove('login');
        return redirect()->to(base_url())->with('response', 'Anda baru saja logout');
    }
    function login_post()
    {
        $post = $this->request->getPost();
        if (empty($post['user']))
            return redirect()->to(base_url('login'))->with('response', '"Username atau No. Hp" tidak boleh kosong');
        if (empty($post['password']))
            return redirect()->to(base_url('login'))->with('response', '"Password" tidak boleh kosong')->with('loginData', $post);;

        // Cari User
        $user = $this->userModel->where('username', $post['user'])->orWhere('hp', $post['user'])->find();
        if (empty($user))
            return redirect()->to(base_url('login'))->with('response', 'User tidak ditemukan')->with('loginData', $post);

        $session = session();
        $user = $user[0];
        if (password_verify($post['password'], $user['password'])) {
            $session->set('login', $user);
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('login'))->with('response', 'Password salah')->with('loginData', $post);;
        }
    }
    function register_post()
    {
        $post = $this->request->getPost();
        if ($post['password'] != $post['repass'])
            return redirect()->to(base_url('register'))->with('response', '"password" dan "ulangi password" tidak sama')->with('registerData', $post);

        $userByUsername = $this->userModel->where('username', $post['username'])->find();
        if (!empty($userByUsername))
            return redirect()->to(base_url('register'))->with('response', 'Username sudah terdaftar')->with('registerData', $post);

        $userByHp = $this->userModel->where('hp', $post['hp'])->find();
        if (!empty($userByHp))
            return redirect()->to(base_url('register'))->with('response', 'No Hp sudah terdaftar')->with('registerData', $post);

        $userByEmail = $this->userModel->where('email', $post['email'])->find();
        if (!empty($userByEmail))
            return redirect()->to(base_url('register'))->with('response', 'Email sudah terdaftar')->with('registerData', $post);

        $data = [
            'dibuat' => waktu(),
            'username' => $post['username'],
            'nama_lengkap' => $post['nama'],
            'hp' => $post['hp'],
            'email' => $post['email'],
            'alamat' => empty($post['desa']) ? $post['kecamatan'] : $post['desa'],
            'detail_alamat' => $post['alamat'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT)
        ];

        $this->userModel->insert($data);
        return redirect()->to(base_url('login'))->with('response', 'Silahkan login dengan akun yang sudah dibuat')->with('loginData', ['user' => $post['username'], 'password' => $post['password']]);
    }

    function keranjang()
    {
        $db = \Config\Database::connect();
        $dataWil = $db->table('wilayah')->get()->getResultArray();
        $desa = [];
        foreach ($dataWil as $key => $value) {
            if ($value['level'] < 4) continue;

            $kode = substr($value['id'], 0, 8);
            if (isset($desa[$kode])) {
                $desa[$kode][] = $value;
            } else {
                $desa[$kode] = [$value];
            }
        }
        $data = [
            'kec' => array_filter($dataWil, function ($arr) {
                return $arr['level'] == 3;
            }),
            'desa' => $desa,
            'user' => is_login() ? sessiondata() : []
        ];
        return view('pages/keranjang', $data);
    }

    function pesan()
    {
        $post = $this->request->getPost();
        if (!isset($post['barang']) || empty($post['barang']))
            return redirect()->to(base_url());

        // Buat Transaksi
        $data = [];
        $token = random(15);
        foreach ($post['barang'] as $k => $barang) {
            $data[] = [
                'id' => random(8),
                'dibuat' => waktu(),
                'diupdate' => waktu(),
                'barang' => $barang,
                'jumlah' => $post['jumlah'][$k],
                'pembeli' => $post['nama'],
                'alamat_pembeli' => $post['desa'],
                'detail_alamat_pembeli' => $post['alamat'],
                'hp' => $post['hp'],
                'status' => 'proses',
                'token' => $token
            ];
        }
        try {
            $transaksiModel = new \App\Models\TransaksiModel();
            $transaksiModel->insertBatch($data);
        } catch (\Throwable $th) {
            return redirect()->to(base_url('keranjang'))->with('response', $th->getMessage());
        }
        return redirect()->to(base_url('keranjang'))->with('response', "Berhasil melakukan pemesanan")->with('token', $token);
        return $this->response->setJSON($this->request->getPost());
    }
    function penjualan()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $dataPenjualan = $transaksiModel->select('barang.nama, barang.harga, transaksi.*')
            ->join('barang', 'barang.id = transaksi.barang')
            ->where('barang.pemilik', sessiondata('login', 'username'))
            ->orderBy('transaksi.dibuat', 'DESC')
            ->findAll();

        $db = \Config\Database::connect();
        $dataWil = $db->table('wilayah')->get()->getResultArray();
        $wilayah = [
            'desa' => [],
            'kecamatan' => []
        ];
        $session = session();
        $respnse = $session->getFlashdata('response');
        foreach ($dataWil as $w) {
            if ($w['level'] == 3)
                $wilayah['kecamatan'][$w['id']] = $w['nama'];
            elseif ($w['level'] == 4)
                $wilayah['desa'][$w['id']] = $w['nama'];
        }
        $data = [
            'dataHeader' => [
                'title' => 'Penjualan',
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
                            'Barang' => 'nama',
                            'Harga' => function ($rec) {
                                return rupiah_format($rec['harga']);
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
                                $btnTerima = '<a href="' . base_url('terima/' . $rec['id']) . '" data-id="' . $rec['id'] . '" class="btn btn-info col-sm-8">Terima</a>';
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
                ]
            ]
        ];

        return view('templates/sbadmin', $data);
    }

    function terima($id)
    {
        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksi = $transaksiModel->find($id);
        if (empty($transaksi)) {
            return redirect()->to(base_url('penjualan'))->with('response', 'Tidak ada transaksi yang ditemukan');
        }

        $data = [
            'diupdate' => waktu(),
            'status' => 'siap'
        ];
        $transaksiModel->update($id, $data);
        return redirect()->to(base_url('penjualan'))->with('response', 'Anda telah menerima pesanan, segera persiapkan pesanan');
    }
    function tolak()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $post = $this->request->getPost();
        $transaksi = $transaksiModel->find($post['id']);
        if (empty($transaksi)) {
            return redirect()->to(base_url('penjualan'))->with('response', 'Tidak ada transaksi yang ditemukan');
        }

        $data = [
            'diupdate' => waktu(),
            'status' => 'batal',
            'pembatal' => $post['pembatal'],
            'alasan_batal' => $post['alasan']
        ];
        $transaksiModel->update($post['id'], $data);
        return redirect()->to($post['pembatal'] == 'pembeli' ? base_url('tracking') : base_url('penjualan'))->with('response', 'Anda telah membatalkan pesanan');
    }


    function tracking()
    {
        return view('pages/tracking');
    }
    function track($token)
    {
        try {
            $transaksiModel = new \App\Models\TransaksiModel();
            $selects = [
                'transaksi.id',
                'users.username',
                'users.nama_lengkap',
                'users.alamat',
                'users.detail_alamat',
                'users.hp',
                'barang.nama',
                'barang.harga',
                'transaksi.jumlah',
                'transaksi.status',
                'transaksi.pembeli',
                'transaksi.alamat_pembeli',
                'transaksi.detail_alamat_pembeli'
            ];

            $data = $transaksiModel->select(join(', ', $selects))
                ->join('barang', 'barang.id = transaksi.barang')
                ->join('users', 'users.username = barang.pemilik')
                ->where('transaksi.token', $token)
                ->findAll();
            if (empty($data))
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Transaksi dengan token <b>' . $token . '</b> tidak ditemukan']);
            $db = \Config\Database::connect();
            $dataWil = $db->table('wilayah')->get()->getResultArray();
            $wilayah = [
                'desa' => [],
                'kecamatan' => []
            ];
            foreach ($dataWil as $w) {
                if ($w['level'] == 3)
                    $wilayah['kecamatan'][$w['id']] = $w['nama'];
                elseif ($w['level'] == 4)
                    $wilayah['desa'][$w['id']] = $w['nama'];
            }

            foreach ($data as $k => $d) {
                $textAlamtPenjual = '';
                $textAlamtPembeli = '';

                if (!empty($d['detail_alamat'])) {
                    $textAlamtPenjual = $d['detail_alamat'] . ', ';
                }
                if (level_wilayah($d['alamat']) == 3) {
                    $textAlamtPenjual .= ' Kec. ' . $wilayah['kecamatan'][$d['alamat']];
                } else {
                    $textAlamtPenjual .= ' Desa ' . $wilayah['desa'][$d['alamat']] . ', ' . $wilayah['kecamatan'][substr($d['alamat'], 0, 8) . '.0000'];
                }

                if (!empty($d['detail_alamat_pembeli'])) {
                    $textAlamtPembeli = $d['detail_alamat_pembeli'] . ', ';
                }
                if (level_wilayah($d['alamat_pembeli']) == 3) {
                    $textAlamtPembeli .= ' Kec. ' . $wilayah['kecamatan'][$d['alamat_pembeli']];
                } else {
                    $textAlamtPembeli .= ' Desa ' . $wilayah['desa'][$d['alamat_pembeli']] . ', ' . $wilayah['kecamatan'][substr($d['alamat_pembeli'], 0, 8) . '.0000'];
                }

                $data[$k]['alamat_penjual'] = $textAlamtPenjual;
                $data[$k]['alamat_pembeli'] = $textAlamtPembeli;
                return $this->response->setJSON($data);
            }
        } catch (\Throwable $th) {
            return $this->response->setStatusCode(500)->setJSON(['message' => $th->getMessage()]);
        }
    }

    function info($id)
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        return $this->response->setJSON($transaksiModel->find($id));
    }
}
