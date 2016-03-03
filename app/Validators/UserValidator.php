<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UserValidator extends LaravelValidator {

	protected $rules = [
		'name' => 'required',
		'email' => 'required|email',
		'password' => 'required',
	];
}
