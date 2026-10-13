<?php

return [
    'wifi_allowed_ips' => array_filter(array_map('trim', explode(',', env(
        'SCHOOL_WIFI_IPS',
        '192.168.1.0/24,192.168.0.0/24,10.0.0.0/8'
    )))),

    'absensi' => [
        'mulai'   => env('ABSENSI_JAM_MULAI', '06:00'),
        'selesai' => env('ABSENSI_JAM_SELESAI', '08:00'),
    ],

    'nama'            => env('SCHOOL_NAME', 'SMA Negeri Contoh'),
    'alamat'          => env('SCHOOL_ADDRESS', 'Jl. Pendidikan No. 123, Jakarta'),
    'telepon'         => env('SCHOOL_PHONE', '(021) 1234567'),
    'email'           => env('SCHOOL_EMAIL', 'tu@sekolah.sch.id'),
    'jam_operasional' => env('SCHOOL_HOURS', 'Senin - Jumat, 07.00 - 15.00'),

    // Domain email yang diizinkan registrasi (pisahkan dengan koma)
    'allowed_email_domains' => array_filter(array_map('trim', explode(',', env(
        'SCHOOL_EMAIL_DOMAINS',
        'sekolah.sch.id,siswa.sch.id'
    )))),
];
