<?php

use Illuminate\Database\Seeder;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(\CodeProject\Entities\OauthClient::class)->create([
    		'id' => 'appid1',
            'name' => 'AngularAPP',
            'secret' => 'secret',
    	]);
    }
}
