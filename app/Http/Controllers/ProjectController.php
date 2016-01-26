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

    public function indexMembers($project_id) {
        return $this->service->members($project_id);
    }

    public function checkMember($project_id, $member_id) {
        return $this->service->isMember($project_id, $member_id);
    }

    public function storeMember(Request $request, $project_id) {
        return $this->service->addMember($request->all(), $project_id);
    }

    public function destroyMember($project_id, $member_id) {
        return $this->service->removeMember($project_id, $member_id);
    }
}
