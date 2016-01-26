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
