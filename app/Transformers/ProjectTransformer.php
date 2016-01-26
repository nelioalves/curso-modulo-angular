<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'membros', 'client', 'owner',
	];

	public function transform(Project $project) {

		return [
			'id' => $project->id,
			'project' => $project->name,
			'description' => $project->description,
			'progress' => $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
		];
	}

	public function includeMembros(Project $project) {
		return $this->collection($project->members, new UserTransformer());
	}

	public function includeClient(Project $project) {
		return $this->item($project->client, new ClientTransformer());
	}

	public function includeOwner(Project $project) {
		return $this->item($project->owner, new UserTransformer());
	}
}
