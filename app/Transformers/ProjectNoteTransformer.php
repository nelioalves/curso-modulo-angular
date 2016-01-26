<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract {

	public function transform(ProjectNote $note) {

		return [
			'id' => $note->id,
			'project_id' => $note->name,
			'title' => $note->title,
			'content' => $note->content,
		];
	}
}
