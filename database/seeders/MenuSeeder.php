<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'nama_menu' => 'Nasi Paket Rendang',
                'kategori' => 'Paket Nasi',
                'harga' => 35000,
                'deskripsi' => 'Nasi putih hangat dengan rendang sapi pilihan yang dimasak dengan bumbu rempah khas Padang. Empuk, gurih, dan kaya rasa.',
                'foto' => 'image/nasirendang.png',
                'stok' => 50,
                'status' => 'tersedia'
            ],
            [
                'nama_menu' => 'Nasi Gurih',
                'kategori' => 'Paket Nasi',
                'harga' => 25000,
                'deskripsi' => 'Nasi yang dimasak dengan santan dan rempah pilihan, disajikan dengan telur balado dan sambal teri. Cocok untuk sarapan atau makan siang.',
                'foto' => 'image/nasigurih.png',
                'stok' => 50,
                'status' => 'tersedia'
            ],
            [
                'nama_menu' => 'Ricebowl Ayam Popcorn Chilipadi',
                'kategori' => 'Ricebowl',
                'harga' => 20000,
                'deskripsi' => 'Rice bowl dengan ayam popcorn chilipadi pedas gurih, ditambah telur mata sapi, timun, dan sambal. Porsi pas untuk satu orang.',
                'foto' => 'image/ricebowlchilipadi.png',
                'stok' => 50,
                'status' => 'tersedia'
            ],
            [
                'nama_menu' => 'Sambel Tempe Orek + Teri',
                'kategori' => 'Lauk',
                'harga' => 35000,
                'deskripsi' => 'Tempe orek pedas manis dicampur teri nasi gurih. Disajikan dengan nasi putih dan lalapan. Murah meriah tapi nagih!',
                'foto' => 'image/tempeorek.png',
                'stok' => 50,
                'status' => 'tersedia'
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
