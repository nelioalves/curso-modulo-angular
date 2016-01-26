<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectFileService;

use CodeProject\Services\Errors;

class ProjectFileController extends Controller
{
    /**
    * @var ProjectFileService
    */
    private $service;

    public function __construct(ProjectFileService $service) {
        $this->service = $service;
    }

    public function index($project_id) {
        return $this->service->all($project_id);
    }

    public function show($project_id, $file_id) {
        return $this->service->find($project_id, $file_id);
    }

    public function store(Request $request) {

        $data = $request->all();

        if (array_key_exists('file', $data)) {
            $file = $request->file('file');
            if (!$file->isValid()) {
                return Errors::basic('Problema no upload. Arquivo inválido.');
            }
            $data['file'] = $file;
        }
        return $this->service->createFile($data);
    }

    public function destroy($file_id) {
        return $this->service->delete($file_id);
    }

}
