<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'user',
	];

	public function transform(ProjectMember $member) {

		return [
			'project_id' => $member->project_id,
		];
	}

	public function includeUser(ProjectMember $member) {
		return $this->item($member->user, new UserTransformer());
	}
}
