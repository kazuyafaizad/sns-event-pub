<?php

namespace App\Http\Controllers;

use App\Actions\CreateEvent;
use App\Actions\GetEvents;
use App\Actions\UpdateEvent;
use App\Http\Requests\Event\CommentRequest;
use App\Http\Requests\Event\EventRequest;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Like;
use App\Models\User;
use App\Traits\HasImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class EventController extends Controller
{
    use HasImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GetEvents $getEvents)
    {
        return Inertia::render('Event/Index', [
            'events' => fn () => $getEvents->execute(),
        ]);
    }

    /**
     * Modifies event visibility to private or public
     *
     * @param  Event  $event
     * @param  string  $visibility public|private
     * @return \Illuminate\Http\Response
     */
    public function updateVisibility(Event $event, $visibility)
    {
        $result = $event->update([
            'visibility' => $visibility,
        ]);

        if ($result) {
            return back()
                ->with('type', 'alert-success')
                ->with('message', "Page is now $visibility.");
        }
    }

    public function store(EventRequest $request)
    {
        $image = $this->upload($request, 'post');

        if ($image && $image->wasRecentlyCreated) {
            $event = (new CreateEvent)->execute($request->validated(), $image);
        } else {
            $event = (new CreateEvent)->execute($request->validated());
        }

        return redirect()
            ->route('event.edit', $event)
            ->with('type', 'alert-success')
            ->with('message', 'event is now published.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($slug, GetEvents $getEvents)
    {
        return Inertia::render('Event/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'event' => $getEvents->execute($slug),
        ]);
    }

    public function create()
    {
        return Inertia::render('Event/Create');
    }

    public function edit(Event $event)
    {
        return Inertia::render('Event/Edit', [
            'event' => $event,
            'tickets' => $event->tickets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function storeComment(CommentRequest $request, Event $event)
    {
        $data = $request->validated();

        $comment = new Comment();
        $comment->makeComment($data, $event);

        return back()
            ->with('type', 'alert-success')
            ->with('message', 'Page is now published.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function storeLike(Request $request, Event $event)
    {
        $like = new Like();
        $like->likeOrUnlike($request, $event);

        return back();
    }

    /**
     * Send user notifications of the client-side
     *
     * @param  User  $user
     * @return json
     */
    public function showNotifications(User $user)
    {
        return response()->json($user->notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Profile\EventRequest  $EventRequest
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Event $event, EventRequest $EventRequest)
    {
        $image = $this->upload($EventRequest, 'post');

        if ($image && $image->wasRecentlyCreated) {
            $event = (new UpdateEvent)->execute($event, $EventRequest->validated(), $image);
        } else {
            $event = (new UpdateEvent)->execute($event, $EventRequest->validated());
        }

        return redirect()
            ->route('event.edit', $event)
            ->with('type', 'alert-success')
            ->with('message', 'event is now published.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
