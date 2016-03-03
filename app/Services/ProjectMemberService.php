<?php

namespace CodeProject\Services;

use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectMemberService {

    /**
    * @var ProjectMemberRepository
    */
    protected $repository;

    /**
    * @var ProjectMemberValidator
    */
    protected $validator;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($project_id) {
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        return $this->repository->findWhere(['project_id'=>$project_id]);
    }

    public function find($project_id, $member_id) {
        $pm = ProjectMember::find($member_id);
        if (is_null($pm)) {
            return Errors::invalidId($member_id);
        }
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        if ($pm->project_id != $project_id) {
            return Errors::basic("Falha. Projeto ".$project_id." nao possui membro ".$member_id);
        }
        return $this->repository->find($member_id); 
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function delete($id) {
        if (is_null(ProjectMember::find($id))) {
            return Errors::invalidId($id);
        }
        $this->repository->delete($id);
        return ['message' => "Registro deletado!"];    
    }
}
