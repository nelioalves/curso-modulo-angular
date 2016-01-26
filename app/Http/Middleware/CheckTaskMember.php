<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectTask;

use CodeProject\Services\Errors;

class CheckTaskMember
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
        $task_id = $request->task;
        $user_id = \Authorizer::getResourceOwnerId();
        
        $task = ProjectTask::find($task_id);
        if (is_null($task)) {
            return Errors::invalidId($task_id);
        }

        if (!$this->repository->isMember($task->project_id, $user_id)) {
            return Errors::basic('Acesso negado! Você não é membro do projeto desta tarefa.');
        }
        return $next($request);
    }
}
