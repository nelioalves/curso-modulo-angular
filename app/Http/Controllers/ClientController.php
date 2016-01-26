<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ClientService;

class ClientController extends Controller
{
    /**
    * @var ClientService
    */
    private $service;

    public function __construct(ClientService $service) {
        $this->service = $service;
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
