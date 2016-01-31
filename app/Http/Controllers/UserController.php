<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

use CodeProject\Services\UserService;

class UserController extends Controller
{
    /**
    * @var UserService
    */
    private $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function authenticated() {
    	return $this->service->authenticated();
    }
}
