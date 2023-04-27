<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';
	protected $primaryKey = 'id';
	protected $fillable = ['title', 'content', 'author_name'];

    public function comments()
    {
        return $this->hasOne(Comment::class, 'article_id');
    }
}
