<?php

use Illuminate\Database\Seeder;

class ProjectMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criando os registros referentes aos donos dos projetos
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 1, 'project_id'=>1]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 2, 'project_id'=>2]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 5, 'project_id'=>3]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 3, 'project_id'=>4]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 1, 'project_id'=>5]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 10,'project_id'=>6]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 4, 'project_id'=>7]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 6, 'project_id'=>8]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 7, 'project_id'=>9]);
    	factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 1, 'project_id'=>10]);

        // Adicionando mais dois membros nao-donos em cada projeto de que o usuario de teste (1) eh dono
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 4, 'project_id'=>1]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 8, 'project_id'=>1]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 3, 'project_id'=>5]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 5, 'project_id'=>5]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 2, 'project_id'=>10]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 9, 'project_id'=>10]);

        // Adicionando o usuario de teste (1) como membro de projetos dos quais nao eh dono
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 1, 'project_id'=>3]);
        factory(\CodeProject\Entities\ProjectMember::class)->create(['user_id' => 1, 'project_id'=>8]);
    }
}
