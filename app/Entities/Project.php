<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use DateTime;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
    protected $table = 'projects';

    protected $fillable = [
    	'owner_id',
    	'client_id',
    	'name',
    	'description',
    	'progress',
    	'status',
    	'due_date',
    ];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function tasks() {
        return $this->hasMany(ProjectTask::class);
    }

    public function notes() {
        return $this->hasMany(ProjectNote::class);
    }

    public function files() {
        return $this->hasMany(ProjectFile::class);
    }

    public function memberAssociations() {
        return $this->hasMany(ProjectMember::class);
    }

    public function members() {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id');
    }

    public function setDueDateAttribute($date) {
        $this->attributes['due_date'] = DateTime::createFromFormat('d/m/Y', $date); 
    }
}
