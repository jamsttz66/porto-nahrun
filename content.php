<?php
/** Flat-file content store. Keep content.json outside the public web root when possible. */
const PORTFOLIO_CONTENT_FILE = __DIR__ . '/storage/content.json';

function portfolio_defaults(): array
{
    return [
        'name' => ['first' => 'Muhammad', 'middle' => 'Nahrun', 'last' => 'Ukasya'],
        'tagline' => 'Saya fotografer dan editor foto. Selain berkarya lewat visual, saya juga bikin website dan aplikasi dengan bantuan AI.',
        'location' => 'Matakali',
        'focus' => 'Visual + Digital',
        'status' => 'Siap kolaborasi',
        'email' => 'nahrunganz@gmail.com',
        'about_statement' => 'Saya suka mengubah ide jadi karya visual dan produk digital yang enak dilihat sekaligus mudah dipakai.',
        'about_one' => 'Saya lulusan S1 Universitas Al Asyariah Mandar tahun 2026. Pengalaman saya mencakup fotografi, edit foto, serta organisasi mahasiswa di jurusan Sistem Informasi.',
        'about_two' => 'Dalam bekerja, saya memakai AI sebagai alat bantu untuk mempercepat proses kreatif, bikin website, dan mengembangkan aplikasi lewat vibe coding.',
        'facts' => [
            ['value' => 'S1', 'label' => 'Universitas Al Asyariah Mandar'],
            ['value' => '2026', 'label' => 'Tahun lulus'],
            ['value' => 'Visual + Tech', 'label' => 'Fokus utama'],
            ['value' => 'Litbang', 'label' => 'Pengalaman organisasi'],
        ],
        'skills' => [
            ['title' => 'Fotografi', 'description' => 'Memotret dan menyiapkan materi visual yang pas untuk kebutuhan proyek.'],
            ['title' => 'Edit Foto', 'description' => 'Merapikan warna, cahaya, dan detail foto sampai hasilnya siap dipakai.'],
            ['title' => 'Website & Aplikasi', 'description' => 'Bikin website dan aplikasi lewat vibe coding, dari ide awal sampai bisa dicoba.'],
            ['title' => 'AI', 'description' => 'Memakai AI untuk mencari ide, mempercepat kerja kreatif, dan membantu proses teknis.'],
            ['title' => 'Microsoft Word', 'description' => 'Membuat dan merapikan dokumen agar tampil jelas, rapi, dan siap dipakai.'],
            ['title' => 'Koordinasi Tim', 'description' => 'Terbiasa mengatur kerja tim lewat pengalaman sebagai Koordinator Litbang di organisasi mahasiswa.'],
        ],
        'experience' => [
            ['period' => '2026', 'title' => 'Fotografer & Editor Foto', 'organization' => 'KodexStudio', 'description' => 'Mulai bergabung sejak semester delapan. Di sini saya memotret, menyiapkan materi visual, dan mengedit foto sampai hasil akhirnya siap dipakai.'],
            ['period' => 'Organisasi', 'title' => 'Koordinator Litbang', 'organization' => 'Himpunan Mahasiswa Sistem Informasi', 'description' => 'Mengatur kegiatan bidang penelitian dan pengembangan, sambil kerja bareng pengurus lain untuk menjalankan program organisasi.'],
            ['period' => 'Lulus 2026', 'title' => 'Sarjana (S1)', 'organization' => 'Universitas Al Asyariah Mandar', 'description' => 'Lulus tahun 2026. Selama kuliah, saya aktif di Himpunan Mahasiswa Sistem Informasi dan belajar menggabungkan sisi teknologi, organisasi, serta pemecahan masalah.'],
        ],
        'targets' => [
            ['code' => 'SEC-01', 'title' => 'Bug Hunter', 'description' => 'Target belajar keamanan siber dan cara menemukan celah keamanan dengan benar.'],
            ['code' => 'AI-02', 'title' => 'AI', 'description' => 'Target memperdalam cara memakai AI untuk kerja kreatif dan digital.'],
            ['code' => 'DEV-03', 'title' => 'Coding', 'description' => 'Target memperkuat dasar coding untuk membangun website dan aplikasi.'],
        ],
        'social' => ['instagram' => 'https://www.instagram.com/nhrunn_', 'facebook' => 'https://www.facebook.com/muhammadnahrununikearenk.nahrun/'],
    ];
}

function portfolio_load(): array
{
    $defaults = portfolio_defaults();
    if (!is_file(PORTFOLIO_CONTENT_FILE)) return $defaults;
    $decoded = json_decode((string) file_get_contents(PORTFOLIO_CONTENT_FILE), true);
    return is_array($decoded) ? array_replace_recursive($defaults, $decoded) : $defaults;
}

function portfolio_e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function portfolio_save(array $content): bool
{
    $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return $json !== false && file_put_contents(PORTFOLIO_CONTENT_FILE, $json . PHP_EOL, LOCK_EX) !== false;
}
