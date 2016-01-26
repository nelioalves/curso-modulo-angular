<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformerLite extends TransformerAbstract {

	// TRANSFORMER CRIADO PARA SER INCLUDE DE ProjectTask (nao possui presenter)

	protected $defaultIncludes = [
		'client', 'owner',
	];

	public function transform(Project $project) {

		return [
			'id' => $project->id,
			'project' => $project->name,
		];
	}

	public function includeClient(Project $project) {
		return $this->item($project->client, new ClientTransformer());
	}

	public function includeOwner(Project $project) {
		return $this->item($project->owner, new UserTransformer());
	}
}
