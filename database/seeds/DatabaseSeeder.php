<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Model::unguard(); // aparentemente de versao antiga

        // Truncates foram retirados pois estava dando erro de integridade:
        
        // \CodeProject\Entities\Project::truncate(); // apaga tudo
        // \CodeProject\Entities\Client::truncate(); // apaga tudo
        // \CodeProject\Entities\User::truncate(); // apaga tudo

        $this->call(UserTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(ProjectMemberTableSeeder::class);
        $this->call(ProjectTaskTableSeeder::class);
        $this->call(ProjectNoteTableSeeder::class);
        $this->call(OauthClientSeeder::class);

        // Model::reguard(); // aparentemente de versao antiga
    }
}
