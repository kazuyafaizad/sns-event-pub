<?php

namespace App\Models;

use App\Notifications\PostNotification;
use App\Traits\HasReadableTimestampTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{
    use HasFactory, HasReadableTimestampTrait;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'like';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'user_id',
    ];

    protected $guarded = [];

    /**
     * Add a new like to a related post data
     *
     * @return bool
     */
    public function likeOrUnlike($data, Event $event)
    {
        $current_user = Auth::user();

        $likeInstance = $this->where([
            'event_id' => $event->id,
            'user_id' => $current_user->id,
        ])->first();

        if ($likeInstance && $likeInstance->exists) {
            return $likeInstance->delete();
        } else {
            $like = $this->create([
                'event_id' => $event->id,
                'user_id' => Auth::user()->id,
            ]);

            if ($like->wasRecentlyCreated) {
                $toBeNotified = $event->user;
                $notifier = $current_user;

                if ($notifier->id !== $toBeNotified->id) {
                    $notification = new PostNotification(PostNotification::LIKE_NOTIFICATION, $notifier, $event);
                    $toBeNotified->notify($notification);
                }

                return true;
            }
        }
    }

    /**
     * DB Relational connection from Like -> Event model
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * DB Relational connection from Like -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
