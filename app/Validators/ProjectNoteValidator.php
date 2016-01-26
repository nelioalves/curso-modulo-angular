<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteValidator extends LaravelValidator {

	protected $rules = [
		'project_id' => 'required|integer', 
		'title' => 'required',
		'content' => 'required',
	];

}
