<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProjectMemberRepository
 * @package namespace CodeProject\Repositories;
 */
interface ProjectMemberRepository extends RepositoryInterface
{
    // este metodo foi colocado aqui porque eu nao consegui instanciar um 
    // ProjectMemberRepository dentro de ProjectRepository
    public function projectsOfWhichIsMember($user_id);

    public function presenter();
}
