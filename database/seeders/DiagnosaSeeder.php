<?php

namespace Database\Seeders;

use App\Models\Rule;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiagnosaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Seed Penyakit
          $penyakits = [
            [
                'kode_penyakit' => 'P001',
                'nama_penyakit' => 'Stadium 0',
                'deskripsi' => 'Kanker payudara stadium 0 adalah yang paling ringan dan tidak invasif. Artinya, pada tahap ini, sel kanker belum menyerang jaringan di sekitarnya. Jenis kanker payudara stadium 0 adalah ductal carcinoma in situ yang disingkat DCIS.',
            ],
            [
                'kode_penyakit' => 'P002',
                'nama_penyakit' => 'Stadium 1',
                'deskripsi' => 'Stadium awal kanker payudara adalah ketika sel kanker belum menyebar luas ke area lain. Pada tahap ini, kanker sudah menyebar ke jaringan sekitar tapi masih di area yang relatif kecil.',
            ],
        ];

        foreach ($penyakits as $penyakit) {
            Penyakit::create($penyakit);
        }

        // Seed Gejala
        $gejalas = [
            [
                'kode_gejala' => 'G001',
                'nama_gejala' => 'pada payudara terdapat tumor berukuran diameter > 5cm',
            ],
            [
                'kode_gejala' => 'G002',
                'nama_gejala' => 'terdapat metastasis ke kelenjar getah bening aksilla yang masih dapat digerakan',
            ],
            [
                'kode_gejala' => 'G003',
                'nama_gejala' => 'terjadi pembengkakan pada payudara',
            ],
            [
                'kode_gejala' => 'G004',
                'nama_gejala' => 'terdapat metastasis ke kelenjar getah bening yang sulit digerakan',
            ],
        ];

        foreach ($gejalas as $gejala) {
            Gejala::create($gejala);
        }

        // Seed Rules
        $rules = [
            [
                'id_penyakit' => 1, // ID Penyakit stadium 0
                'daftar_gejala' => ['G001', 'G002'], // Contoh gejala
                'penanganan' => 'Penanganan pada gejala G001 dapat diberikan antibiotic dan obat pereda nyeri dan penangannya lainnya dapat melalui tindakan Krioterapi yaitu pengobatan untuk menghancurkan sel abnormal dengan cara dibekukan.',
            ],
            [
                'id_penyakit' => 2, // ID Penyakit stadium 1
                'daftar_gejala' => ['G001', 'G004'], // Contoh gejala
                'penanganan' => 'Penanganan pada gejala G004 adalah dengan melakukan tindakan kemoterapi, kemoterapi merupakan tindakan yang paling umum. Selain itu dapat dilakukan tindakan imunoterapi untuk meningkatkan kekebalan sistem imun untuk mendeteksi kanker.',
            ],
        ];

        foreach ($rules as $rule) {
            $gejalaIds = Gejala::whereIn('kode_gejala', $rule['daftar_gejala'])->pluck('id')->toArray();

            Rule::create([
                'id_penyakit' => $rule['id_penyakit'],
                'daftar_gejala' => implode(',', $gejalaIds),
                'penanganan' => $rule['penanganan'],
            ]);
        }
    }
}
