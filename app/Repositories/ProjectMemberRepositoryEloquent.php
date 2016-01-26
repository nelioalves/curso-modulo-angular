<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Entities\ProjectMember;

/**
 * Class ProjectMemberRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectMemberRepositoryEloquent extends BaseRepository implements ProjectMemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectMember::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    // este metodo foi colocado aqui porque eu nao consegui instanciar um 
    // ProjectMemberRepository dentro de ProjectRepository
    public function projectsOfWhichIsMember($user_id) {
        $this->skipPresenter(true);
        $resp = $this->findWhere(['user_id'=>$user_id]);
        $this->skipPresenter(false);
        $ids = array();
        foreach ($resp as $r) {
           array_push($ids, $r->project_id);
        }
        return $ids;
    }

}
