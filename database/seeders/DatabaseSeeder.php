<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\MataKuliah;
use App\Models\Material;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Dosen Pengampu Default
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@celoe.test'],
            [
                'name' => 'Dr. Ir. Budi Santoso, M.T.',
                'password' => Hash::make('dosen123'),
                'role' => 'dosen',
                'nomor_induk' => '198501012015041001',
            ]
        );

        // 2. Akun Mahasiswa Default
        $mahasiswa1 = User::updateOrCreate(
            ['email' => 'mahasiswa@celoe.test'],
            [
                'name' => 'Ahmad Pratama',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nomor_induk' => '1301210001',
            ]
        );

        // 3. Mata Kuliah Dasar (Modul 3)
        $course1 = MataKuliah::updateOrCreate(
            ['kode_mk' => 'IF301'],
            [
                'nama_mk' => 'Pengembangan Aplikasi Website',
                'deskripsi' => 'Mata kuliah yang membahas arsitektur aplikasi web modern menggunakan framework Laravel, MVC, Eloquent ORM, dan keamanan web.',
                'sks' => 4,
                'semester' => 'Ganjil 2026/2027',
                'dosen_id' => $dosen->id,
            ]
        );

        // 4. Daftarkan Mahasiswa ke Mata Kuliah Pertama (status approved)
        $course1->students()->syncWithoutDetaching([
            $mahasiswa1->id => ['status' => 'approved'],
        ]);

        // 5. Tambahkan Materi Contoh
        Material::updateOrCreate(
            ['course_id' => $course1->id, 'minggu_ke' => 1, 'urutan' => 1],
            [
                'judul' => 'Pengenalan Arsitektur MVC & Routing di Laravel 12',
                'konten' => 'Mempelajari alur HTTP Request, Route Middleware, Controller, dan pembuatan View menggunakan Blade Template.',
            ]
        );

        // TODO 8: Tambahkan minimal 2 mata kuliah lagi dengan semester berbeda, 1 mahasiswa tambahan, 2 tugas, dan contoh data submission

$course2 = MataKuliah::updateOrCreate(
    ['kode_mk' => 'IF204'],
    [
        'nama_mk' => 'Basis Data Relasional',
        'deskripsi' => 'Mata kuliah perancangan basis data relasional, normalisasi, ERD, dan optimasi query SQL.',
        'sks' => 3,
        'semester' => 'Ganjil 2026/2027',
        'dosen_id' => $dosen->id,
    ]
);

$course3 = MataKuliah::updateOrCreate(
    ['kode_mk' => 'IF402'],
    [
        'nama_mk' => 'Analisis dan perancangan sistem informasi',
        'deskripsi' => 'Mata kuliah membahas cara menganalisis dan merancang sistem berdasarkan informasi .',
        'sks' => 2,
        'semester' => 'Genap 2027/2028',
        'dosen_id' => $dosen->id,
    ]
);

$mahasiswa2 = User::updateOrCreate(
    ['email' => 'kuzaima@celoe.test'],
    [
        'name' => 'Kuzaima Nurasana',
        'password' => Hash::make('mahasiswa123'),
        'role' => 'mahasiswa',
        'nomor_induk' => '102042400053',
    ]
);


$course1->students()->syncWithoutDetaching([
    $mahasiswa2->id => ['status' => 'approved'],
]);
$course2->students()->syncWithoutDetaching([
    $mahasiswa1->id => ['status' => 'approved'],
]);

$tugas1 = Assignment::updateOrCreate(
    ['course_id' => $course1->id, 'judul' => 'Tugas 1: Implementasi Middleware & Eloquent ORM'],
    [
        'deskripsi' => 'Jelaskan dimana activity diagram dibuat',
        'deadline' => now()->addDays(5),
    ]
);

$tugas2 = Assignment::updateOrCreate(
    ['course_id' => $course2->id, 'judul' => 'Tugas 1: Perancangan ERD'],
    [
        'deskripsi' => 'Buatlah ERD untuk sistem perpustakaan sederhana beserta penjelasan relasi antar entitas.',
        'deadline' => now()->addDays(7),
    ]
);

Submission::updateOrCreate(
    ['assignment_id' => $tugas1->id, 'user_id' => $mahasiswa1->id],
    [
        'jawaban' => 'bikin diagram activity pakai visual paradigma.',
        'submitted_at' => now(),
        'nilai' => 80,
        'catatan_dosen' => 'Lumayan baik Pertahankan!',
    ]
);

Submission::updateOrCreate(
    ['assignment_id' => $tugas1->id, 'user_id' => $mahasiswa2->id],
    [
        'jawaban' => 'Route middleware dipasang di routes/web.php. Middleware auth memastikan user sudah login, sedangkan role middleware mengecek kolom role pada tabel users.',
        'submitted_at' => now(),
        'nilai' => 90,
        'catatan_dosen' => 'Sudah baik sekali.',
    ]
);
    }
}
