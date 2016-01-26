<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectNote extends Model implements Transformable
{
    use TransformableTrait;

    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
    protected $table = 'project_notes';

    protected $fillable = [
    	'project_id',
    	'title',
    	'content',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
