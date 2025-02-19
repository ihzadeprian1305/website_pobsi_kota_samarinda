<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DocumentCategory;
use App\Models\Handicap;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\StructureField;
use App\Models\StructurePosition;
use App\Models\User;
use App\Models\UserDatum;
use App\Models\UserImage;
use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        UserLevel::create([
            'name' => 'Admin',
            'description' => 'Pengguna Khusus Admin'
        ]);
        UserLevel::create([
            'name' => 'Ketua Umum',
            'description' => 'Pengguna Khusus Ketua Umum'
        ]);
        UserLevel::create([
            'name' => 'Ketua Kompartemen',
            'description' => 'Pengguna Khusus Ketua Kompartemen'
        ]);
        UserLevel::create([
            'name' => 'Ketua Bidang',
            'description' => 'Pengguna Khusus Ketua Bidang'
        ]);
        UserLevel::create([
            'name' => 'Anggota',
            'description' => 'Pengguna Khusus Anggota'
        ]);

        UserDatum::create([
            'name' => 'coba1234',
            'sex' => 'Laki-laki',
            'user_id' => 1,
        ]);

        UserImage::create([
            'image' => null,
            'image_name' => null,
            'user_id' => 1,
        ]);

        User::create([
            'username' => 'coba1234',
            'email' => 'coba1234@gmail.com',
            'phone_number' => '012345678910',
            'password' => bcrypt('coba1234'),
            'user_level_id' => 1,
        ]);

        NewsCategory::create([
            'name' => 'Informasi'
        ]);
        NewsCategory::create([
            'name' => 'Berita'
        ]);
        NewsTag::create([
            'name' => 'pool'
        ]);
        NewsTag::create([
            'name' => 'samarinda'
        ]);
        NewsTag::create([
            'name' => 'pobsi'
        ]);

        StructureField::create([
            'name' => 'Pengurus Utama',
            'description' => 'Pengurus Utama POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Teknis dan Kepelatihan',
            'description' => 'Bidang Teknis dan Kepelatihan POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Pertandingan dan Perwasitan',
            'description' => 'Bidang Pertandingan dan Perwasitan POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Hukum dan Disiplin',
            'description' => 'Bidang Hukum dan Disiplin POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Hubungan Kelembagaan',
            'description' => 'Bidang Hubungan Kelembagaan POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Perencanaan Anggaran dan Sarana',
            'description' => 'Bidang Perencanaan Anggaran dan Sarana POBSI',
        ]);

        StructureField::create([
            'name' => 'Bidang Humas dan Promosi',
            'description' => 'Bidang Humas dan Promosi POBSI',
        ]);

        StructurePosition::create([
            'name' => 'Ketua Umum',
            'description' => 'Ketua Umum POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Ketua Harian',
            'description' => 'Ketua Harian POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Sekretaris Umum',
            'description' => 'Sekretaris Umum POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Wakil Sekretaris',
            'description' => 'Wakil Sekretaris POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Bendahara Umum',
            'description' => 'Bendahara Umum POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Ketua I Kompartemen Pembinaan Prestasi',
            'description' => 'Ketua I Kompartemen Pembinaan Prestasi POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Ketua II Kompartemen Organisasi',
            'description' => 'Ketua I Kompartemen Organisasi POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Ketua III Kompartemen Umum',
            'description' => 'Ketua I Kompartemen Umum POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 1
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Teknis dan Kepelatihan',
            'description' => 'Kepala Bidang Teknis dan Kepelatihan POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 2
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Teknis dan Kepelatihan',
            'description' => 'Anggota Bidang Teknis dan Kepelatihan POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 2
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Pertandingan dan Perwasitan',
            'description' => 'Kepala Bidang Pertandingan dan Perwasitan POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 3
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Pertandingan dan Perwasitan',
            'description' => 'Anggota Bidang Pertandingan dan Perwasitan POBSI',
            'maximum_position' => 3
            ,
            'structure_field_id' => 3
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Hukum dan Disiplin',
            'description' => 'Kepala Bidang Hukum dan Disiplin POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 4
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Hukum dan Disiplin',
            'description' => 'Anggota Bidang Hukum dan Disiplin POBSI',
            'maximum_position' => 3,
            'structure_field_id' => 4
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Hubungan Kelembagaan',
            'description' => 'Kepala Bidang Hubungan Kelembagaan POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 5
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Hubungan Kelembagaan',
            'description' => 'Anggota Bidang Hubungan Kelembagaan POBSI',
            'maximum_position' => 3,
            'structure_field_id' => 5
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Perencanaan Anggaran dan Sarana',
            'description' => 'Kepala Bidang Perencanaan Anggaran dan Sarana POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 6
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Perencanaan Anggaran dan Sarana',
            'description' => 'Anggota Bidang Perencanaan Anggaran dan Sarana POBSI',
            'maximum_position' => 3,
            'structure_field_id' => 6
        ]);
        StructurePosition::create([
            'name' => 'Kepala Bidang Humas dan Promosi',
            'description' => 'Kepala Bidang Humas dan Promosi POBSI',
            'maximum_position' => 1,
            'structure_field_id' => 7
        ]);
        StructurePosition::create([
            'name' => 'Anggota Bidang Humas dan Promosi',
            'description' => 'Anggota Bidang Humas dan Promosi POBSI',
            'maximum_position' => 3,
            'structure_field_id' => 7
        ]);

        Handicap::create([
            'name' => '2',
            'description' => 'Handicap 3B merupakan Handicap di bawah Handicap 2'
        ]);

        Handicap::create([
            'name' => '3B',
            'description' => 'Handicap 3B merupakan Handicap di bawah Handicap 3'
        ]);

        Handicap::create([
            'name' => '3',
            'description' => 'Handicap 3 merupakan Handicap di bawah Handicap 4 dan di atas Handicap 3B'
        ]);

        Handicap::create([
            'name' => '4',
            'description' => 'Handicap 4 merupakan Handicap di bawah Handicap 5 dan di atas Handicap 3'
        ]);

        Handicap::create([
            'name' => '5',
            'description' => 'Handicap 5 merupakan Handicap di bawah Handicap 6 dan di atas Handicap 4'
        ]);

        Handicap::create([
            'name' => '6',
            'description' => 'Handicap 6 merupakan Handicap di atas Handicap 5'
        ]);

        Handicap::create([
            'name' => '7',
            'description' => 'Handicap 6 merupakan Handicap di atas Handicap 7'
        ]);

        DocumentCategory::create([
            'name' => 'Peraturan Dasar POBSI Samarinda'
        ]);
        DocumentCategory::create([
            'name' => 'Hasil Pertandingan'
        ]);
    }
}
