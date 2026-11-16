<?php

namespace Database\Seeders;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $catFiksi = Category::create(['name' => 'Fiksi & Novel']);
        $catTeknologi = Category::create(['name' => 'Teknologi & Pemograman']);
        $catSejarah =  Category::create(['name' => 'Sejarah & Pengetahuan']);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpus.test',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Nadyes',
            'email' => 'siswa@perpus.test',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas' => 'XII RPL 3'
        ]);

        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka', 
            'year' => 2005,
            'stock' => 4,
            'category_id' => $catFiksi->id
        ]);

        Book::create([
            'title' => 'Matering Laravel 11', 
            'author' => 'Tim Kreatif',
            'publisher' => 'Informatika',
            'year' => 2024,
            'stock' => 5,
            'category_id' => $catTeknologi->id
        ]);

        Book::create([
            'title' => 'Sejarah Dunia Yang Disembunyikan', 
            'author' => 'Jonathan Black',
            'publisher' => 'Alfabet',
            'year' => 2015,
            'stock' => 3,
            'category_id' => $catSejarah->id
        ]);
    }
}
