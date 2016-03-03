<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

	protected $fieldSearchable = [
		'name',
	];

	public function Model() {
		return User::class;
	}

//    public function presenter() {
//        return \CodeProject\Presenters\UserPresenter::class;
//    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
