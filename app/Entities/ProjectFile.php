<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectFile extends Model implements Transformable
{
    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
	protected $table = 'project_files';

    use TransformableTrait;

    protected $fillable = [
    	'name',
    	'description',
    	'extension',
    	'project_id',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
