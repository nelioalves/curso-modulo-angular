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

    public function index(Request $request) {
        $limit = $request->query->get('limit', 8); // 8 eh valor default
        return $this->service->all($limit);
    }

    public function indexNoPaginate() {
        return $this->service->allNoPaginate();
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
