<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\Image;
use Carbon\Carbon;

class CreateEvent
{
    /**
     * Creates a event for a user and includes image reference when available.
     *
     * @return void
     */
    public function execute(array $inputs, Image $image = null)
    {
        if ($image instanceof Image) {
            return Event::create([
                'user_id' => auth()->user()->id,
                'title' => $inputs['title'],
                'content' => $inputs['content'],
                'image_reference' => $image->path,
                'type' => $inputs['type'],
                'visibility' => 'public',
                'start_time' => Carbon::parse($inputs['start_time'])->setTimezone('Asia/Singapore')->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($inputs['end_time'])->format('Y-m-d H:i:s'),
                'venue' => $inputs['venue'],
            ]);
        } else {
            return Event::create([
                'user_id' => auth()->user()->id,
                'title' => $inputs['title'],
                'content' => $inputs['content'],
                'type' => $inputs['type'],
                'visibility' => 'public',
                'start_time' => Carbon::parse($inputs['start_time'])->setTimezone('Asia/Singapore')->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($inputs['end_time'])->format('Y-m-d H:i:s'),
                'venue' => $inputs['venue'],
            ]);
        }
    }
}
