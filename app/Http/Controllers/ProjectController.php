<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectService;

class ProjectController extends Controller
{
    /**
    * @var ProjectService
    */
    private $service;

    public function __construct(ProjectService $service) {
        $this->service = $service;
    }

    public function index() {
        return $this->service->all();
    }

    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    public function show($project_id) {
        return $this->service->find($project_id);
    }

    public function destroy($project_id) {
        return $this->service->delete($project_id);
    }

    public function update(Request $request, $project_id) {
        return $this->service->update($request->all(), $project_id);
    }

}
