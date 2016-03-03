<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskValidator extends LaravelValidator {

	protected $rules = [
		'name' => 'required',
		'project_id' => 'required|integer', 
		//'start_date' => 'required|date_format:Y-m-d',
		//'due_date' => 'required|date_format:Y-m-d',
		'status' => 'required',
	];

}
