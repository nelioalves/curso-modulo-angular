<?php

namespace CodeProject\Services;

use CodeProject\Entities\ProjectTask;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use CodeProject\Services\Errors;

class ProjectTaskService {

    /**
    * @var ProjectTaskRepository
    */
    protected $repository;

    /**
    * @var ProjectRepository
    */
    protected $projectRepository;

    /**
    * @var ProjectTaskValidator
    */
    protected $validator;

    public function __construct(ProjectTaskRepository $repository, ProjectRepository $projectRepository,
        ProjectTaskValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();

            if (is_null(Project::find($data['project_id']))) {
                return Errors::invalidId($data['project_id']);
            }
            
            $user_id = \Authorizer::getResourceOwnerId();
            if (!$this->projectRepository->isMember($data['project_id'], $user_id)) {
               return Errors::basic('Acesso negado. Você não é membro do projeto selecionado.');
            }

            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function update(array $data, $task_id) {
        $task = ProjectTask::find($task_id);
        if (is_null($task)) {
            return Errors::invalidId($task_id);
        }

        try {
            $this->validator->with($data)->passesOrFail();

            if ($data['project_id'] != $task->project_id) {
                return Errors::basic('Você não pode alterar o projeto da tarefa.');
            }
            
            $user_id = \Authorizer::getResourceOwnerId();
            if (!$this->projectRepository->isMember($task->project_id, $user_id)) {
               return Errors::basic('Acesso negado. Você não é membro do projeto selecionado.');
            }

            return $this->repository->update($data, $task_id);
        }
        catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function all($project_id) {
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        return $this->repository->findWhere(['project_id'=>$project_id]);
    }

    public function find($project_id, $task_id) {
        $task = ProjectTask::find($task_id);
        if (is_null($task)) {
            return Errors::invalidId($task_id);
        }
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        if ($task->project_id != $project_id) {
            return Errors::basic("Falha. Projeto ".$project_id." nao possui a tarefa ".$task_id);
        }
        return $this->repository->find($task_id); 
    }

    public function delete($task_id) {
        $task = ProjectTask::find($task_id);
        if (is_null($task)) {
            return Errors::invalidId($task_id);
        }

        $user_id = \Authorizer::getResourceOwnerId();
        if (!$this->projectRepository->isMember($task->project_id, $user_id)) {
           return Errors::basic('Acesso negado. Você não é membro do projeto desta tarefa.');
        }

        $this->repository->delete($task_id);
        return ['message' => "Registro deletado!"];    
    }
}
