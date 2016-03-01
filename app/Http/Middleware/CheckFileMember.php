<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectFile;

use CodeProject\Services\Errors;

class CheckFileMember
{

    private $repository;

    public function __construct(ProjectRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file_id = $request->file;
        $user_id = \Authorizer::getResourceOwnerId();
        
        $file = ProjectFile::find($file_id);
        if (is_null($file)) {
            return Errors::invalidId($file_id);
        }

        if (!$this->repository->isMember($file->project_id, $user_id)) {
            return Errors::basic('Acesso negado! Você não é membro do projeto deste arquivo.');
        }
        return $next($request);
    }
}
