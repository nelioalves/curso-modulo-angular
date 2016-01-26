<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

use CodeProject\Entities\Project;

use CodeProject\Services\Errors;

class CheckProjectMember
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
        $project_id = $request->project;
        $user_id = \Authorizer::getResourceOwnerId();
        
        if (is_null(Project::find($project_id))) {
            return Errors::invalidId($project_id);
        }

        if (!$this->repository->isMember($project_id, $user_id)) {
            return Errors::basic('Acesso negado! Você não é membro deste projeto.');
        }
        return $next($request);
    }
}
