<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskValidator extends LaravelValidator {

	protected $rules = [
		'name' => 'required',
		'project_id' => 'required|integer', 
		'start_date' => 'required|date_format:d/m/Y',
		'due_date' => 'required|date_format:d/m/Y',
		'status' => 'required',
	];

}
