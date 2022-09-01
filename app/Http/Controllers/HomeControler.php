<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class HomeControler extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Home', [
            'events' => Event::where('user_id', auth()->user()->id)
                ->paginate(5),
        ]);
    }
}
