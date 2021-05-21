<?php

namespace App\Observers;

use App\Models\Widget;

class WidgetObserver
{
    /**
     * Handle the Widget "creating" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function creating(Widget $widget)
    {
        $widget->user_id = auth()->id();
    }

    /**
     * Handle the Widget "created" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function created(Widget $widget)
    {
        //
    }

    /**
     * Handle the Widget "updated" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function updated(Widget $widget)
    {
        //
    }

    /**
     * Handle the Widget "deleted" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function deleted(Widget $widget)
    {
        //
    }

    /**
     * Handle the Widget "restored" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function restored(Widget $widget)
    {
        //
    }

    /**
     * Handle the Widget "force deleted" event.
     *
     * @param  \App\Models\Widget  $widget
     * @return void
     */
    public function forceDeleted(Widget $widget)
    {
        //
    }
}
