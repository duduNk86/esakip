<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@wonosobokab.go.id',
            'password' => Hash::make('Superadmin@p4ssw00rd!'),
            'role' => 'superadmin',
            'active' => '1',
        ]);

        // Viewer
        User::create([
            'name' => 'Viewer',
            'email' => 'viewer@wonosobokab.go.id',
            'password' => Hash::make('Viewer@p4ssw00rd!'),
            'role' => 'viewer',
            'active' => '1',
        ]);

        // User OPD
        $opdUsers = [
            ['name' => 'Admin Setda', 'email' => 'setda@wonosobokab.go.id', 'opd_id' => 1],
            ['name' => 'Admin Itda', 'email' => 'inspektorat@wonosobokab.go.id', 'opd_id' => 2],
            ['name' => 'Admin Setwan', 'email' => 'setwan@wonosobokab.go.id', 'opd_id' => 3],
            ['name' => 'Admin Disdikpora', 'email' => 'dikpora@wonosobokab.go.id', 'opd_id' => 4],
            ['name' => 'Admin Dinkes', 'email' => 'dinkes@wonosobokab.go.id', 'opd_id' => 5],
            ['name' => 'Admin Dpupr', 'email' => 'dpupr@wonosobokab.go.id', 'opd_id' => 6],
            ['name' => 'Admin Disperkimhub', 'email' => 'disperkimhub@wonosobokab.go.id', 'opd_id' => 7],
            ['name' => 'Admin Dinsospmd', 'email' => 'dinsospmd@wonosobokab.go.id', 'opd_id' => 8],
            ['name' => 'Admin Dppkbpppa', 'email' => 'dppkbpppa@wonosobokab.go.id', 'opd_id' => 9],
            ['name' => 'Admin Dispaperkan', 'email' => 'dispaperkan@wonosobokab.go.id', 'opd_id' => 10],
            ['name' => 'Admin Dlh', 'email' => 'dlh@wonosobokab.go.id', 'opd_id' => 11],
            ['name' => 'Admin Disdukcapil', 'email' => 'disdukcapil@wonosobokab.go.id', 'opd_id' => 12],
            ['name' => 'Admin Diskominfo', 'email' => 'diskominfo@wonosobokab.go.id', 'opd_id' => 13],
            ['name' => 'Admin Disdagkopukm', 'email' => 'disdagkopukm@wonosobokab.go.id', 'opd_id' => 14],
            ['name' => 'Admin Dpmptsp', 'email' => 'dpmptsp@wonosobokab.go.id', 'opd_id' => 15],
            ['name' => 'Admin Disnakerintrans', 'email' => 'disnakerintrans@wonosobokab.go.id', 'opd_id' => 16],
            ['name' => 'Admin Disarpusda', 'email' => 'arpusda@wonosobokab.go.id', 'opd_id' => 17],
            ['name' => 'Admin Disparbud', 'email' => 'disparbud@wonosobokab.go.id', 'opd_id' => 18],
            ['name' => 'Admin SatpolPP', 'email' => 'satpolpp@wonosobokab.go.id', 'opd_id' => 19],
            ['name' => 'Admin Bappeda', 'email' => 'bappeda@wonosobokab.go.id', 'opd_id' => 20],
            ['name' => 'Admin Bppkad', 'email' => 'bppkad@wonosobokab.go.id', 'opd_id' => 21],
            ['name' => 'Admin Bkd', 'email' => 'bkd@wonosobokab.go.id', 'opd_id' => 22],
            ['name' => 'Admin Bpbd', 'email' => 'bpbd@wonosobokab.go.id', 'opd_id' => 23],
            ['name' => 'Admin Bakesbangpol', 'email' => 'bakesbangpol@wonosobokab.go.id', 'opd_id' => 24],
            ['name' => 'Admin Kec. Wonosobo', 'email' => 'kecamatanwonosobo@wonosobokab.go.id', 'opd_id' => 25],
            ['name' => 'Admin Kec. Kertek', 'email' => 'kecamatankertek@wonosobokab.go.id', 'opd_id' => 26],
            ['name' => 'Admin Kec. Selomerto', 'email' => 'kecamatanselomerto@wonosobokab.go.id', 'opd_id' => 27],
            ['name' => 'Admin Kec. Leksono', 'email' => 'kecamatanleksono@wonosobokab.go.id', 'opd_id' => 28],
            ['name' => 'Admin Kec. Garung', 'email' => 'kecamatangarung@wonosobokab.go.id', 'opd_id' => 29],
            ['name' => 'Admin Kec. Kejajar', 'email' => 'kecamatankejajar@wonosobokab.go.id', 'opd_id' => 30],
            ['name' => 'Admin Kec. Mojotengah', 'email' => 'kecamatanmojotengah@wonosobokab.go.id', 'opd_id' => 31],
            ['name' => 'Admin Kec. Watumalang', 'email' => 'kecamatanwatumalang@wonosobokab.go.id', 'opd_id' => 32],
            ['name' => 'Admin Kec. Kalikajar', 'email' => 'kecamatankalikajar@wonosobokab.go.id', 'opd_id' => 33],
            ['name' => 'Admin Kec. Sapuran', 'email' => 'kecamatansapuran@wonosobokab.go.id', 'opd_id' => 34],
            ['name' => 'Admin Kec. Kepil', 'email' => 'kecamatankepil@wonosobokab.go.id', 'opd_id' => 35],
            ['name' => 'Admin Kec. Kaliwiro', 'email' => 'kecamatankaliwiro@wonosobokab.go.id', 'opd_id' => 36],
            ['name' => 'Admin Kec. Wadaslintang', 'email' => 'kecamatanwadaslintang@wonosobokab.go.id', 'opd_id' => 37],
            ['name' => 'Admin Kec. Sukoharjo', 'email' => 'kecamatansukoharjo@wonosobokab.go.id', 'opd_id' => 38],
            ['name' => 'Admin Kec. Kalibawang', 'email' => 'kecamatankalibawang@wonosobokab.go.id', 'opd_id' => 39],

        ];

        foreach ($opdUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('@p4ssw00rd!'),
                'role' => 'user',
                'opd_id' => $user['opd_id'],
                'active' => '1',
            ]);
        }

        // Penilai (APIP)
        $penilaiUsers = [
            ['name' => 'Penilai 1', 'email' => 'penilai1@wonosobokab.go.id', 'password' => 'Penilai1@p4ssw00rd!'],
            ['name' => 'Penilai 2', 'email' => 'penilai2@wonosobokab.go.id', 'password' => 'Penilai2@p4ssw00rd!'],
            ['name' => 'Penilai 3', 'email' => 'penilai3@wonosobokab.go.id', 'password' => 'Penilai3@p4ssw00rd!'],
            ['name' => 'Penilai 4', 'email' => 'penilai4@wonosobokab.go.id', 'password' => 'Penilai4@p4ssw00rd!'],
            ['name' => 'Penilai 5', 'email' => 'penilai5@wonosobokab.go.id', 'password' => 'Penilai5@p4ssw00rd!'],
        ];

        foreach ($penilaiUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => 'penilai',
                'active' => '1',
            ]);
        }
    }
}
