<?php

namespace CodeProject\Services;

use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService {

    /**
    * @var ClientRepository
    */
    protected $repository;

    /**
    * @var ClientValidator
    */
    protected $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } 
        catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function update(array $data, $id) {
        if (is_null(Client::find($id))) {
            return Errors::invalidId($id);
        }

        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }
        catch (ValidatorException $e) {
            return Errors::basic($e->getMessageBag());
        }
    }

    public function all($limit) {
        return $this->repository->paginate($limit);
    }

    public function allNoPaginate() {
        return $this->repository->all();
    }

    public function find($id) {
        if (is_null(Client::find($id))) {
            return Errors::invalidId($id);
        }
        return $this->repository->find($id);
    }

    public function delete($id) {
        $entity = Client::find($id);
        if (is_null($entity)) {
            return Errors::invalidId($id);
        }

        if (count($entity->projects) > 0) {
            return Errors::basic("Este cliente possui projetos. Exclusão cancelada.");
        }

        $this->repository->delete($id);
        return ['message' => "Registro deletado!"];    
    }
}
