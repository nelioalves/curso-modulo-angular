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

    public function index() {
        return $this->service->all();
    }

    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    public function show($id) {
        return $this->service->find($id);
    }

    public function destroy($id) {
        return $this->service->delete($id);
    }

    public function update(Request $request, $id) {
        return $this->service->update($request->all(), $id);
    }
}
