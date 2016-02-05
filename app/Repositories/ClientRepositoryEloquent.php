<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

use CodeProject\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

	protected $fieldSearchable = [
		'name',
	];

	public function Model() {
		return Client::class;
	}

    public function presenter() {
        return \CodeProject\Presenters\ClientPresenter::class;
    }

    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
