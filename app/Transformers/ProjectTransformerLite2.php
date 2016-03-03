<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformerLite2 extends TransformerAbstract {

	public function transform(Project $project) {

		return [
			'id' => $project->id,
			'name' => $project->name,
			'status' => $project->status,
		];
	}
}
