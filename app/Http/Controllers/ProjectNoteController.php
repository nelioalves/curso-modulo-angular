<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectNoteService;

class ProjectNoteController extends Controller
{
    /**
    * @var ProjectNoteService
    */
    private $service;

    public function __construct(ProjectNoteService $service) {
        $this->service = $service;
    }

    public function index($project_id) {
        return $this->service->all($project_id);
    }

    public function store(Request $request) {
    	return $this->service->create($request->all());
    }

    public function show($project_id, $note_id) {
        return $this->service->find($project_id, $note_id);
    }

    public function destroy($note_id) {
    	return $this->service->delete($note_id);
    }

    public function update(Request $request, $note_id) {
        return $this->service->update($request->all(), $note_id);
    }
}
