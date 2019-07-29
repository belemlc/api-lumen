<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'administrador@mail.com',
            'password' => app('hash')->make('1q2w3e4r'),
            'cpf' => '000.000.000-00',
            'cnpj' => ''
        ]);
    }
}
