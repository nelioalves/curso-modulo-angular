<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'project_id' => 'required',
			'file' => 'required', // |mimes:jpeg,jpg,png,gif,pdf,zip
			'name' => 'required',
			'description' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
			'project_id' => 'required',
			'name' => 'required',
			'description' => 'required',
        ]
   ];

}
