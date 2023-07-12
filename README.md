# Sistem Kelompok Nelayan Menggunakan Codeigniter 4

## Requirenment
1. PHP versi 8.24 ^

## Cara Install
1. Buka Command prompt kemudian ketikkan perintah  ``` cd Documents``` kemudian enter
1. Clone project dari github repositrory "https://github.com/nersus15/nelayan" dengan perintah ```git clone https://github.com/nersus15/nelayan```
1. Setelah proses clone selesai kemudian ktik perintah ``` cd nelayan ```
1. Setelah masuk ke folder project (nelayan) selanjutnya install seluruh dependensi yang dibutuhkan dengan perintah ``` composer install ``` sebelum itu, pastikan terlebih dahulu bahwa di laptop anda sudah terinstall PHP (rekomendasi PHP 8, bisa menggunakan XAMPP) dan juga Composer, jika muncul error seperti ``` composer not defined``` atau sejenisnya, itu berarti composer belum terinstall atau belum di daftarkan di Environment Variable, silahkan kunjungi ``` https://www.niagahoster.co.id/blog/cara-install-composer/ ``` untuk cara install composer.
1. Setelah dependensi di install, selanjutnya buat database dengan masuk ke phpmyadmin (jika menggunakan XAMPP nyalakan apache dan mysql) untuk nama database itu bebas (rekomendasi nelayan agar tidak utak atik config)
1. Setelah membuat database, selanjutnya buat table dengan menjalankan perinta ``` php spark migrate ```
2. Setelah itu tambahkan database wilayah secara manual dengan cara import file ``` app/Database/sql/wilayah.sql ``` ke daalam database nelayan (database project)
3. Selanjutnya ketikkan perintah ``` php spark db:seed UserSeeder``` untuk membuat akun default, untuk username dan password akun default, silahkan buka file ``` app\Database\Seeds\UserSeeder.php ```
4. Setelah semua persiapan selesai, selanjutnya jalankan server untuk aplikasi webnya dengan perintah ``` php spark serve ```, maka server akan berjalan secara otomatis di port 8080, untuk membuka website kunjungi ``` http://localhost:8080 ```
