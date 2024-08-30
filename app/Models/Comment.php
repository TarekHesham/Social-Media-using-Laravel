<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = ["content", "post_id", "user_id"];

    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
