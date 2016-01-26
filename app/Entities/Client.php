<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
	protected $table = 'clients';

	protected $fillable = [
		'name',
		'responsible',
		'email',
		'phone',
		'address',
		'obs'
	];
    
    public function projects() {
    	return $this->hasMany(Project::class);
    }
}
