<?php

namespace CodeProject\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ownerOf() {
        return $this->hasMany(Project::class);
    }

    public function memberOf() {
        return $this->belongsToMany(Project::class, 'project_members', 'user_id', 'project_id');
    }

    public function projectAssociations() {
        return $this->hasMany(ProjectMember::class);
    }
}
