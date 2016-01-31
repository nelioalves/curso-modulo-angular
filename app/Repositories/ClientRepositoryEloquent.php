<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

	public function Model() {
		return Client::class;
	}

    public function presenter() {
        return \CodeProject\Presenters\ClientPresenter::class;
    }
}
