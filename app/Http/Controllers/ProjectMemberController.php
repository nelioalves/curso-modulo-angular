<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectMemberService;

class ProjectMemberController extends Controller
{
    /**
    * @var ProjectMemberService
    */
    private $service;

    public function __construct(ProjectMemberService $service) {
        $this->service = $service;
    }

    public function index($project_id) {
        return $this->service->all($project_id);
    }

    public function show($project_id, $member_id) {
        return $this->service->find($project_id, $member_id);
    }

    public function store(Request $request, $project_id) {
        $data = $request->all();
        $data['project_id'] = $project_id;
        return $this->service->create($data);
    }

    public function destroy($project_id, $member_id) {
        return $this->service->delete($member_id);
    }
}
