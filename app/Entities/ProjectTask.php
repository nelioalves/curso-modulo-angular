<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use DateTime;

class ProjectTask extends Model implements Transformable
{
    use TransformableTrait;

    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
    protected $table = 'project_tasks';

    protected $fillable = [
		'name',
		'project_id', 
		'start_date',
		'due_date',
		'status',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function setStartDateAttribute($date) {
        $this->attributes['start_date'] = DateTime::createFromFormat('d/m/Y', $date); 
    }

    public function setDueDateAttribute($date) {
        $this->attributes['due_date'] = DateTime::createFromFormat('d/m/Y', $date); 
    }

}
