<?php

namespace CodeProject\Services;

use CodeProject\Entities\User;

use CodeProject\Repositories\UserRepository;

class UserService {

    /**
    * @var UserRepository
    */
    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function authenticated() {
        $user_id = \Authorizer::getResourceOwnerId();
        return $this->repository->find($user_id);
    }
}
