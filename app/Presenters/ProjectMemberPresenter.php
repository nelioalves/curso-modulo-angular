<?php

namespace CodeProject\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use CodeProject\Transformers\ProjectMemberTransformer;

class ProjectMemberPresenter extends FractalPresenter {

	public function getTransformer() {
		return new ProjectMemberTransformer();
	}
}
