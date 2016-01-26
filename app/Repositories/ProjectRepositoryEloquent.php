<?php
namespace CodeProject\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;
/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function isMember($project_id, $user_id) {
        // assume-se que o project_id ja foi checado na camada de servico
        $project = Project::find($project_id);
        if ($project->owner_id == $user_id) {
            return true;
        }
        foreach ($project->members as $member) {
            if ($member->id == $user_id) {
                return true;
            }
        }
        return false;        
    }

    public function isOwner($project_id, $user_id) {
        // assume-se que o project_id ja foi checado na camada de servico
        $project = Project::find($project_id);
        if ($project->owner_id == $user_id) {
            return true;
        }
        return false;        
    }

    public function findMemberAssociation($project_id, $user_id) {
        // assume-se que o project_id ja foi checado na camada de servico
        $project = Project::find($project_id);
        foreach ($project->memberAssociations as $pm) {
            if ($pm->user_id == $user_id) {
                return $pm;
            }
        }
        return null;
    }

    public function presenter() {
        return \CodeProject\Presenters\ProjectPresenter::class;
    }
}


