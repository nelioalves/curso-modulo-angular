<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 1]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 2]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 5]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 3]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 1]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 10]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 4]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 6]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 7]);
    	factory(\CodeProject\Entities\Project::class)->create(['owner_id' => 1]);
    }
}
