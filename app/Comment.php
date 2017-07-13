<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Comment extends Model
{
	
	protected $guarded = [];
	
    public function post()
	{
		return $this->belongsTo(Post::class);
	}
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
}
