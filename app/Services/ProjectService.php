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

    public function all() {
        $user_id = \Authorizer::getResourceOwnerId();

        $ids = $this->projectMemberRepository->projectsOfWhichIsMember($user_id);

        return $this->repository->with(['client','owner'])->findWhereIn('id', $ids);
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

    public function members($project_id) {
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }

        // Foi feita uma adaptacao abaixo por causa do uso de presenters
        return $this->repository->find($project_id)['data']['membros'];
    }

    public function isMember($project_id, $user_id) {
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        if (is_null(User::find($user_id))) {
            return Errors::invalidId($user_id);
        }

        if ($this->repository->isMember($project_id, $user_id)) {
            return [
                'resp' => true,
                'message' => "Usuario ".$user_id." eh membro do projeto ".$project_id
            ];
        }
        else {
            return [
                'resp' => false,
                'message' => "Usuario ".$user_id." NAO eh membro do projeto ".$project_id
            ];
        }
    }

    public function addMember($data, $project_id) {
        $project = Project::find($project_id);
        if (is_null($project)) {
            return Errors::invalidId($project_id);
        }

        if (!array_key_exists('user_id', $data)) {
            return Errors::basic("Campo user_id obrigatorio");
        }

        $user_id = $data['user_id'];

        // Como o create ja insere o dono como membro, nao haveria necessidade desta verificacao
        if ($user_id == $project->owner_id) {
            return Errors::basic("Este usuario ja eh o dono do projeto");
        }

        if ($this->repository->isMember($project_id, $user_id)) {
            return Errors::basic("Este usuario ja eh membro do projeto");
        }

        $data['project_id'] = $project_id;
        return $this->projectMemberService->create($data);
    }

    public function removeMember($project_id, $member_id) {
        $project = Project::find($project_id);
        if (is_null($project)) {
            return Errors::invalidId($project_id);
        }

        if (is_null(User::find($member_id))) {
            return Errors::invalidId($member_id);
        }

        if ($member_id == $project->owner_id) {
            return Errors::basic("Não é possível remover o dono do projeto.");
        }

        $pm = $this->repository->findMemberAssociation($project_id, $member_id);
        if (is_null($pm)) { 
            return Errors::basic("Este usuário não é membro do projeto.");
        }

        return $this->projectMemberService->delete($pm->id);
    }
}
