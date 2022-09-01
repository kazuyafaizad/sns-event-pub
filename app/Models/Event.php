<?php

namespace App\Models;

use App\Traits\HasReadableTimestampTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, HasReadableTimestampTrait, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_reference',
        'visibility',
        'start_time',
        'end_time',
        'venue',
        'type',
    ];

    const EVENT = 1;

    const DONATION = 2;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'id'],
            ],
        ];
    }

    /**
     * DB Relational connection from Event -> Comment model
     *
     * @return object
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * DB Relational connection from Event -> Comment model
     *
     * @return object
     */
    public function comment()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    /**
     * DB Relational connection from Event -> Like model
     *
     * @return object
     */
    public function like()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * DB Relational connection from Event -> Like model
     *
     * @return object
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
