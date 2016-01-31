<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

	public function Model() {
		return User::class;
	}

    public function presenter() {
        return \CodeProject\Presenters\UserPresenter::class;
    }
}
