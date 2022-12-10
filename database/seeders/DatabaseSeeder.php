<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\Umum;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();
        Roles::factory()->create();
        Umum::factory()->create();

        DB::table('roles_items')->insert([
            [ 'nama' => 'Umum', 'created_at' => Carbon::now(), ],
            [ 'nama' => 'Roles', 'created_at' => Carbon::now(), ],
            [ 'nama' => 'RolesItem', 'created_at' => Carbon::now(), ],
            [ 'nama' => 'Users', 'created_at' => Carbon::now(), ],
        ]);


        DB::table('roles_item_pivot')->insert([
            [
                'roles_id'  => 1,
                'roles_item_id' => 1,
                'create'    => 1,
                'read'  => 1,
                'update' => 1,
                'delete' => 1,
                'print' => 1,
                'created_at' => Carbon::now(),
            ], [
                'roles_id'  => 1,
                'roles_item_id' => 2,
                'create'    => 1,
                'read'  => 1,
                'update' => 1,
                'delete' => 1,
                'print' => 1,
                'created_at' => Carbon::now(),
            ], [
                'roles_id'  => 1,
                'roles_item_id' => 3,
                'create'    => 1,
                'read'  => 1,
                'update' => 1,
                'delete' => 1,
                'print' => 1,
                'created_at' => Carbon::now(),
            ], [
                'roles_id'  => 1,
                'roles_item_id' => 4,
                'create'    => 1,
                'read'  => 1,
                'update' => 1,
                'delete' => 1,
                'print' => 1,
                'created_at' => Carbon::now(),
            ]
        ]);

        DB::table('roles_user')->insert([
            [
                'user_id'   => 1,
                'roles_id'  => 1,
                'created_at' => Carbon::now(),
            ]
        ]);

    }
}
