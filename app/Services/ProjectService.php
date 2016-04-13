<?php

namespace CodeProject\Services;

use CodeProject\Entities\Project;
use CodeProject\Entities\User;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use CodeProject\Repositories\ProjectMemberRepository;


class ProjectService {

    /**
    * @var ProjectRepository
    */
    protected $repository;

    /**
    * @var ProjectValidator
    */
    protected $validator;

    /**
    * @var ProjectMemberService
    */
    protected $projectMemberService;

    /**
    * @var ProjectTaskService
    */
    protected $projectTaskService;

    /**
    * @var ProjectNoteService
    */
    protected $projectNoteService;

    /**
    * @var ProjectMemberRepository
    */
    protected $projectMemberRepository;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, 
        ProjectMemberService $projectMemberService, ProjectTaskService $projectTaskService,
        ProjectMemberRepository $projectMemberRepository, ProjectNoteService $projectNoteService) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectMemberService = $projectMemberService;
        $this->projectTaskService = $projectTaskService;
        $this->projectNoteService = $projectNoteService;
        $this->projectMemberRepository = $projectMemberRepository;
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();

            $user_id = \Authorizer::getResourceOwnerId();
            if ($data['owner_id'] != $user_id) {
                return Errors::basic('Voce nao pode inserir um novo projeto cujo dono nao seja voce.');
            }

            $project = Project::create($data);

            $resp = $this->projectMemberService->create([
                'project_id' => $project->id,
                'user_id' => $data['owner_id'],
            ]);

            return $this->repository->find($project->id);
        } catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag()); 
        }
    }

    public function update(array $data, $id) {
        $project = Project::find($id);
        if (is_null($project)) {
            return Errors::invalidId($id);
        }

        try {
            $this->validator->with($data)->passesOrFail();
            if ($data['owner_id'] != $project->owner_id) {
                return Errors::basic('O dono do projeto nao pode ser alterado!');
            }
            return $this->repository->update($data, $id);
        }
        catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function allOwner($limit) {
        $user_id = \Authorizer::getResourceOwnerId();

        return $this->repository->findOwner($user_id, $limit);

//        $ids = $this->projectMemberRepository->projectsOfWhichIsMember($user_id);
//        return $this->repository->with(['client','owner'])->findWhereIn('id', $ids);
    }


    public function allMember($limit) {
        $user_id = \Authorizer::getResourceOwnerId();

        $ids = $this->projectMemberRepository->projectsOfWhichIsMember($user_id);
        return $this->repository->findMember($ids, $limit);
    }

    public function find($id) {
        if (is_null(Project::find($id))) {
            return Errors::invalidId($id);
        }
        return $this->repository->with(['client','owner'])->find($id);
    }

    public function delete($id) {
        $entity = Project::find($id);
        if (is_null($entity)) {
            return Errors::invalidId($id);
        }

        foreach ($entity->tasks as $task) {
            $this->projectTaskService->delete($task->id);
        }

        foreach ($entity->notes as $note) {
            $this->projectNoteService->delete($note->id);
        }

        foreach ($entity->memberAssociations as $pm) {
            $this->projectMemberService->delete($pm->id);
        }

        $this->repository->delete($id);
        return ['message' => "Registro deletado!"];    
    }

}
