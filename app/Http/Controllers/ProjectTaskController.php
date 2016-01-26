<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectTaskService;

class ProjectTaskController extends Controller
{
    /**
    * @var ProjectTaskService
    */
    private $service;

    public function __construct(ProjectTaskService $service) {
        $this->service = $service;
    }

    public function index($project_id) {
        return $this->service->all($project_id);
    }

    public function store(Request $request) {
    	return $this->service->create($request->all());
    }

    public function show($project_id, $task_id) {
        return $this->service->find($project_id, $task_id);
    }

    public function destroy($task_id) {
    	return $this->service->delete($task_id);
    }

    public function update(Request $request, $task_id) {
        return $this->service->update($request->all(), $task_id);
    }
}
