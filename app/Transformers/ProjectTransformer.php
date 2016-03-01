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
			'name' => $project->name,
			'description' => $project->description,
			'progress' => (int) $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
			'client_id' => $project->client_id,
			'owner_id' => $project->owner_id,
			'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
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
