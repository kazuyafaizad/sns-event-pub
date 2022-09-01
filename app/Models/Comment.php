<?php

namespace App\Models;

use App\Notifications\PostNotification;
use App\Traits\HasReadableTimestampTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory, HasReadableTimestampTrait;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'content',
    ];

    protected $guarded = [];

    /**
     * Add a new comment to a related post data
     *
     * @return bool
     */
    public function makeComment($data, Event $event)
    {
        $data['user_id'] = Auth::user()->id;
        $data['event_id'] = $event->id;

        if ($this->create($data)) {
            $toBeNotified = $event->user;
            $notifier = Auth::user();

            if ($notifier->id !== $toBeNotified->id) {
                $notification = new PostNotification(PostNotification::COMMENT_NOTIFICATION, $notifier, $event);
                $toBeNotified->notify($notification);
            }
        }

        return true;
    }

    /**
     * DB Relational connection from Comment -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * DB Relational connection from Comment -> Event model
     *
     * @return object
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
