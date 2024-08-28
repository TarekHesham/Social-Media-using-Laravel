<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = ["content", "post_id", "creator_id"];

    function post()
    {
        return $this->belongsTo(Post::class);
    }

    function creator()
    {
        return $this->belongsTo(Creator::class);
    }
}
