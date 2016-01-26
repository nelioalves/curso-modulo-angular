<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileValidator extends LaravelValidator {

	protected $rules = [
		'project_id' => 'required',
		'file' => 'required',
		'name' => 'required',
		'description' => 'required',
	];

}
