<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'members', 'client', 'owner', 'notes', 'tasks', 'files'
	];

	public function transform(Project $project) {

		$tasks = $project->tasks;

		return [
			'id' => $project->id,
			'name' => $project->name,
			'description' => $project->description,
			'progress' => (int) $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
			'client_id' => $project->client_id,
			'owner_id' => $project->owner_id,
			'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
			'tasks_count' => $tasks->count(),
			'tasks_opened' => $this->countTasksOpened($tasks),
		];
	}

	public function includeNotes(Project $project) {
		return $this->collection($project->notes, new ProjectNoteTransformer());
	}

	public function includeTasks(Project $project) {
		return $this->collection($project->tasks, new ProjectTaskTransformer());
	}

	public function includeFiles(Project $project) {
		return $this->collection($project->files, new ProjectFileTransformer());
	}

	public function includeMembers(Project $project) {
		return $this->collection($project->members, new UserTransformer());
	}

	public function includeClient(Project $project) {
		return $this->item($project->client, new ClientTransformer());
	}

	public function includeOwner(Project $project) {
		return $this->item($project->owner, new UserTransformer());
	}

	function countTasksOpened($tasks) {
		$count = 0;
		foreach ($tasks as $task) {
			if ($task->status == 1) {
				$count++;
			}
		}
		return $count;
	}
}
