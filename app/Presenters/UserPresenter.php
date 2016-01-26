<?php

namespace CodeProject\Presenters;

use CodeProject\Entities\User;
use Prettus\Repository\Presenter\FractalPresenter;
use CodeProject\Transformers\UserTransformer;

class UserPresenter extends FractalPresenter {

	public function getTransformer() {
		return new UserTransformer();
	}
}
