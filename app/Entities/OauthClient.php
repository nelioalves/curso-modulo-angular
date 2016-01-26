<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    // definicao opcional - senao o ORM usa padrao: lower case plural, underline, ingles
	protected $table = 'oauth_clients';

	protected $fillable = [
		'id',
		'name',
		'secret',
	];
}
