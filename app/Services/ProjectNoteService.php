<?php

namespace CodeProject\Services;

use CodeProject\Entities\ProjectNote;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use CodeProject\Services\Errors;

class ProjectNoteService {

    /**
    * @var ProjectNoteRepository
    */
    protected $repository;

    /**
    * @var ProjectRepository
    */
    protected $projectRepository;

    /**
    * @var ProjectNoteValidator
    */
    protected $validator;

    public function __construct(ProjectNoteRepository $repository, ProjectRepository $projectRepository,
        ProjectNoteValidator $validator) {
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

    public function update(array $data, $note_id) {
        $note = ProjectNote::find($note_id);
        if (is_null($note)) {
            return Errors::invalidId($note_id);
        }

        try {
            $this->validator->with($data)->passesOrFail();

            if ($data['project_id'] != $note->project_id) {
                return Errors::basic('Você não pode alterar o projeto da nota.');
            }
            
            $user_id = \Authorizer::getResourceOwnerId();
            if (!$this->projectRepository->isMember($note->project_id, $user_id)) {
               return Errors::basic('Acesso negado. Você não é membro do projeto selecionado.');
            }

            return $this->repository->update($data, $note_id);
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

    public function find($project_id, $note_id) {
        $note = ProjectNote::find($note_id);
        if (is_null($note)) {
            return Errors::invalidId($note_id);
        }
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        if ($note->project_id != $project_id) {
            return Errors::basic("Falha. Projeto ".$project_id." nao possui a nota ".$note_id);
        }
        return $this->repository->find($note_id); 
    }

    public function delete($note_id) {
        $note = ProjectNote::find($note_id);
        if (is_null($note)) {
            return Errors::invalidId($note_id);
        }

        $user_id = \Authorizer::getResourceOwnerId();
        if (!$this->projectRepository->isMember($note->project_id, $user_id)) {
           return Errors::basic('Acesso negado. Você não é membro do projeto desta nota.');
        }

        $this->repository->delete($note_id);
        return ['message' => "Registro deletado!"];    
    }
}
