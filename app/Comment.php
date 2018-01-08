<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Comment extends Model
{
	
	protected $guarded = [];

    /**
     * Связь с моделью Post
     * @return mixed
     */
    public function post()
	{
		return $this->belongsTo(Post::class);
	}

    /**
     * Связь с моделью User
     * @return mixed
     */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
}
