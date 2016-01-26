<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectNote;

use CodeProject\Services\Errors;

class CheckNoteMember
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
        $note_id = $request->note;
        $user_id = \Authorizer::getResourceOwnerId();
        
        $note = ProjectNote::find($note_id);
        if (is_null($note)) {
            return Errors::invalidId($note_id);
        }

        if (!$this->repository->isMember($note->project_id, $user_id)) {
            return Errors::basic('Acesso negado! Você não é membro do projeto desta nota.');
        }
        return $next($request);
    }
}
