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

    public function indexOwner(Request $request) {
        $limit = $request->query->get('limit');
        return $this->service->allOwner($limit);
    }

    public function indexMember(Request $request) {
        $limit = $request->query->get('limit');
        return $this->service->allMember($limit);
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
