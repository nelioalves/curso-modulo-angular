<?php

namespace CodeProject\Services;

use CodeProject\Entities\User;

use CodeProject\Repositories\UserRepository;
use CodeProject\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService {

    /**
    * @var UserRepository
    */
    protected $repository;

    /**
    * @var UserValidator
    */
    protected $validator;

    public function __construct(UserRepository $repository, UserValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function authenticated() {
        $user_id = \Authorizer::getResourceOwnerId();
        return $this->repository->find($user_id);
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
        if (is_null(User::find($id))) {
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

    public function all() {
        return $this->repository->all();
    }

    public function find($id) {
        if (is_null(User::find($id))) {
            return Errors::invalidId($id);
        }
        return $this->repository->find($id);
    }

    public function delete($id) {
        $entity = User::find($id);
        if (is_null($entity)) {
            return Errors::invalidId($id);
        }

        if (count($entity->memberOf) > 0) {
            return Errors::basic("Este usuário participa de projetos. Exclusão cancelada.");
        }

        $this->repository->delete($id);
        return ['message' => "Registro deletado!"];    
    }
}
