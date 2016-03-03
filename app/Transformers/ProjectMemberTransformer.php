<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'user', 'project',
	];

	public function transform(ProjectMember $member) {

		return [
			'id' => $member->id,
			'user_id' => $member->user_id,
			'project_id' => $member->project_id,
		];
	}

	public function includeProject(ProjectMember $member) {
		return $this->item($member->project, new ProjectTransformerLite2());
	}

	public function includeUser(ProjectMember $member) {
		return $this->item($member->user, new UserTransformer());
	}
}
