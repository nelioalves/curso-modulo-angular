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

            $aux = $this->repository->skipPresenter()->findWhere(['user_id'=>$data['user_id'], 'project_id'=>$data['project_id']]);
            if (count($aux) > 0) {
                return Errors::basic("Falha. Este usuario ja eh membro deste projeto");
            }            

            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function delete($id) {
        $pm = ProjectMember::find($id);
        if (is_null($pm)) {
            return Errors::invalidId($id);
        }

        // Lembrete: a verificacao se o usuario autenticado eh o dono do projeto ja foi
        // feita via middleware. Basta agora testar se o membro nao eh o usuario autenticado
        $user_id = \Authorizer::getResourceOwnerId();
        if ($user_id == $pm->user_id) {
            return Errors::basic("Voce eh dono do projeto e portanto nao pode se excluir dele");
        }

        $this->repository->delete($id);
        return ['message' => "Registro deletado!"];    
    }
}
