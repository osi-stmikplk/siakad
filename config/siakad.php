<?php
/**
 * Masukkan disini adalah setting global untuk siakad kita tercinta :D
 * User: toni
 * Date: 09/04/16
 * Time: 10:01
 */
return [
    'nama' => 'SIAKADpinginOl',
    'title' => 'SIAKAD STMIK Palangka Raya',
    'slogan' => 'Kuliah Beneran, Benar-benar Kuliah',
    'versi' => '0.1',
    /*
     * pada versi production akan digunakan cache, di sini akan ditentukan berapa lama cache disimpan di system. Dibagi
     * menjadi beberapa tingkatan yaitu lama, menengah dan cepat. Adapun masing-masing nilai adalah menit!
     */
    'cache-diingat' => [
        'lama'     => 120,
        'menengah' => 45,
        'cepat'    => 15
    ],
    /*
     * Apabila ini diaktifkan maka pastikan bahwa setting untuk https telah diset serta diusahakan untuk menggunakan
     * sertifikat ssl yang valid. Adapun penjelasan nilai untuk
     * - mati => tidak wajib HTTPS
     * - sebagian => hanya login dan setting data diri serta akun yang menggunakan HTTPS,
     * - full => semua akan dilewatkan melalui HTTPS.
     * Setting di sini akan diaktifkan melalui middleware RequestHarusHTTPS.
     */
    'https' => env('SIAKAD_HTTPS', 'mati'), // 'sebagian', 'penuh'
];