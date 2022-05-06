<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\LatestBlogPost;
use App\Models\Subscription;


class SendPostCreatedNotification implements ShouldQueue
{
    public $delay = 60;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        Subscription::orderBy('id')->chunk(100, function ($subscribers) use($event) {
            foreach ($subscribers as $subscriber) {
                \Mail::to($subscriber->email)
                ->send(new LatestBlogPost($event->post));
            }
        });
    }
}
