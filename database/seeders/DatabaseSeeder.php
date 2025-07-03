<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Stage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //   \App\Models\User::create([
        //      'email' => 'anas@admin.com',
        //      'password' => Hash::make('1'),
        //  ]);

        // Stage::create([
        //     'name' => 'المرحلة الابتدائية' ,
        //     'tag' => 'p' ,
        // ]);
        // Stage::create([
        //     'name' => 'المرحلة الاعدادية' ,
        //     'tag' => 'm' ,
        // ]);
        // Stage::create([
        //     'name' => 'المرحلة الثانوية' ,
        //     'tag' => 'h' ,
        // ]);


        $stagep = Stage::getIdByTag('h');

        // Section::create([
        //     'name' => '1' ,
        // ]);



        // Grade::create([
        //     'name' => 'الصف الاول',
        //     'stage_id' => $stagep,
        //     'tag' => '1',
        // ]);

        // Grade::create([
        //     'name' => 'الصف الثاني',
        //     'stage_id' => $stagep,
        //     'tag' => '2',
        // ]);
        // Grade::create([
        //     'name' => 'الصف الثالث',
        //     'stage_id' => $stagep,
        //     'tag' => '3',
        // ]);
        // Grade::create([
        //     'name' => 'الصف الرابع',
        //     'stage_id' => $stagep,
        //     'tag' => '4',
        // ]);
        // Grade::create([
        //     'name' => 'الصف الخامس',
        //     'stage_id' => $stagep,
        //     'tag' => '5',
        // ]);
        // Grade::create([
        //     'name' => 'الصف السادس',
        //     'stage_id' => $stagep,
        //     'tag' => '6',
        // ]);
        // Grade::create([
        //     'name' => 'الصف السابع',
        //     'stage_id' => $stagep,
        //     'tag' => '7',
        // ]);
        // Grade::create([
        //     'name' => 'الصف الثامن',
        //     'stage_id' => $stagep,
        //     'tag' => '8',
        // ]);
        // Grade::create([
        //     'name' => 'الصف التاسع',
        //     'stage_id' => $stagep,
        //     'tag' => '9',
        // ]);
        Grade::create([
            'name' => 'الصف العاشر',
            'stage_id' => $stagep,
            'tag' => '10',
        ]);
        Grade::create([
            'name' => 'الصف الحادي عشر',
            'stage_id' => $stagep,
            'tag' => '11',
        ]);
        Grade::create([
            'name' => 'الصف الثاني عشر',
            'stage_id' => $stagep,
            'tag' => '12',
        ]);
    }
}
