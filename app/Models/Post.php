<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $table = 'posts';
    protected $fillable = ["title", "description", "image", "user_id", "slug"];

    function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    protected static function boot()
    {
        parent::boot();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('g:i a l')
        );
    }
}
