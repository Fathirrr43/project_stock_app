<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class stokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        $Areas = [
            'Palembang' => 'PLG',
            'Bandung' => 'BDG',
            'Jakarta' => 'JKT',
            'Padang' => 'PDG',
            'Medan' => 'MDN',
            'Makassar' => 'MKS',
            'Surabaya' => 'SBY',
        ];

        for ($i=0; $i < 10; $i++){

            $randomArea = $faker->randomElement($Areas);

            $data[] = [
                'kode_barang' => strtoupper($faker->lexify('???'). $faker->unique()->numerify('####')),
                'nama_barang' => $faker->word('10', true),
                'harga' => $faker->numberBetween(10000, 750000),
                'stok' => $faker->numberBetween(10, 70),
                'suplier' => $faker->numberBetween(1,   5),
                'cabang'=> $randomArea,
            ];
        }
        DB::table('stoks')->insert($data);
    }
}
