<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\Like;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class GetEvents
{
    /**
     * Returns all events with specified queries and filters or
     * returns only one record when `$id` is passed
     *
     * @return void|array
     */
    public function execute($slug = '')
    {
        $current_user = Auth::user();
        $name_condition = 'fullname AS name';

        $query = Event::addSelect([
            'likes' => Like::selectRaw('count(*) as total')
                ->whereColumn('event_id', 'events.id'),
        ]);
        if (! Auth::Guest()) {
            $query->addSelect([
                'likedByCurrentUser' => Like::select('user_id')
                    ->whereColumn('event_id', 'events.id')
                    ->where('user_id', '=', $current_user->id),
            ]);
        } else {
            $query->addSelect([
                'likedByCurrentUser' => Like::select('user_id')
                    ->whereColumn('event_id', 'events.id'),
            ]);
        }

        $query->addSelect([
            'byProfileName' => Profile::selectRaw($name_condition)
                ->whereColumn('user_id', 'events.user_id'),
        ])
            ->with([
                'comment' => function ($comment) use ($name_condition) {
                    $comment->addSelect([
                        'byProfileName' => Profile::selectRaw($name_condition)
                            ->whereColumn('user_id', 'comment.user_id'),
                    ]);
                },
            ]);

        $query->with('user')
            ->with('tickets');

        // Query specific event
        if ($slug) {
            return $query->whereSlug($slug)->first()->toArray();
        }

        // Paginate through all events
        return $query->orderBy('start_time', 'asc')->cursorPaginate(5)->toArray();
    }
}
