<?php
namespace CodeProject\Repositories;
use Prettus\Repository\Contracts\RepositoryInterface;
/**
 * Interface ProjectRepository
 * @package namespace CodeProject\Repositories;
 */
interface ProjectRepository extends RepositoryInterface
{
    //
    public function isMember($project_id, $user_id);
    public function findMemberAssociation($project_id, $user_id);
    public function isOwner($project_id, $user_id);

    public function presenter();
}
