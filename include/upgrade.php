<?php

function tanya_komen_default_config()
{
    return [
        'version' => TanyaKomen::$version,
        'pertanyaan' => [
            [
                'tanya' => "Di negara manakah desa ini terletak?",
                'jawab' => 'Indonesia',
            ],
            [
                'tanya' => "Di kabupaten manakah desa ini terletak?",
                'jawab' => 'banjarnegara',
            ],
            [
                'tanya' => 'Warna bendera Indonesia adalah merah dan ...',
                'jawab' => 'putih',
            ],
            [
                'tanya' => 'Warna bendera Indonesia adalah ... dan putih',
                'jawab' => 'merah',
            ],
            [
                'tanya' => 'Bhineka Tunggal ...?',
                'jawab' => 'Ika',
            ],
            [
                'tanya' => 'Kemerdekaan Indonesia dilaksanakan pada bulan apa?',
                'jawab' => 'Agustus',
            ],
            [
                'tanya' => 'Tahun berapa indonesia merdeka? (angka)',
                'jawab' => '1945',
            ],
            [
                'tanya' => 'Huruf pertama pada urutan abjad adalah?',
                'jawab' => 'A',
            ],
            [
                'tanya' => 'Huruf terakhir pada urutan abjad adalah?',
                'jawab' => 'Z',
            ],

        ],
    ];
}

function tanya_komen_merge_config()
{
    $ignore = ['pertanyaan'];
    $default = tanya_komen_default_config();
    foreach ( $default as $key => $value ) {
        if ( in_array( $key, $ignore ) ) {
            continue;
        }
        if ( empty( @TanyaKomen::$config[$key] ) ) {
            TanyaKomen::$config[$key] = $value;
        }
    }
    TanyaKomen::$config['version'] = TanyaKomen::$version;
}

if ( empty( TanyaKomen::$config ) ) {
    TanyaKomen::$config = tanya_komen_default_config();
    TanyaKomen::save_config();
} elseif ( TanyaKomen::$config['version'] != TanyaKomen::$version ) {
    tanya_komen_merge_config();
    TanyaKomen::save_config();
}
