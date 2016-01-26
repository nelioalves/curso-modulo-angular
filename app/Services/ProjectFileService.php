<?php

namespace CodeProject\Services;

use CodeProject\Entities\ProjectFile;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\FileSystem\FileSystem;
use Illuminate\Contracts\FileSystem\Factory as Storage;

class ProjectFileService {

    /**
    * @var ProjectFileRepository
    */
    protected $repository;

    /**
    * @var ProjectFileValidator
    */
    protected $validator;

    /**
    * @var ProjectRepository
    */
    protected $projectRepository;

    /**
    * @var FileSystem
    */
    protected $filesystem;

    /**
    * @var Storage
    */
    protected $storage;

    public function __construct(ProjectFileRepository $repository, FileSystem $filesystem, 
        Storage $storage, ProjectFileValidator $validator, ProjectRepository $projectRepository) {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;
    }

    public function all($project_id) {
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        return $this->repository->findWhere(['project_id'=>$project_id]);
    }

    public function find($project_id, $file_id) {
        $projectFile = ProjectFile::find($file_id);
        if (is_null($projectFile)) {
            return Errors::invalidId($file_id);
        }
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }
        if ($projectFile->project_id != $project_id) {
            return Errors::basic("Falha. Projeto ".$project_id." nao possui o arquivo ".$file_id);
        }
        return $this->repository->find($file_id); 
    }

    public function createFile(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();

            $project = Project::find($data['project_id']);
            if (is_null($project)) {
                return Errors::invalidId($data['project_id']);
            }

            $user_id = \Authorizer::getResourceOwnerId();
            if (!$this->projectRepository->isMember($data['project_id'], $user_id)) {
               return Errors::basic('Acesso negado. Você não é membro do projeto selecionado.');
            }

            $data['extension'] = $data['file']->getClientOriginalExtension();
            
            $projectFile = $this->repository->create($data);

        	$nome = $projectFile->id.".".$data['extension'];
        	$arquivo = $this->filesystem->get($data['file']);
        	$this->storage->put($nome, $arquivo);

        	return ['message' => 'Arquivo criado'];
        } catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag()); 
        }
    }

    public function delete($file_id) {
        $projectFile = ProjectFile::find($file_id);
        if (is_null($projectFile)) {
            return Errors::invalidId($file_id);
        }

        $user_id = \Authorizer::getResourceOwnerId();
        if (!$this->projectRepository->isMember($projectFile->project_id, $user_id)) {
           return Errors::basic('Acesso negado. Você não é membro do projeto deste arquivo.');
        }

        $nome = $projectFile->id.'.'.$projectFile->extension;
        $this->repository->delete($file_id);
        $this->storage->delete($nome);
        return ['message' => "Registro e arquivo deletados!"];    
    }

}
