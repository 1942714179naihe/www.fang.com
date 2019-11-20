<?php

namespace App\Observers;

use App\Models\FangAttr;

class FangAttrObserver
{
    /**
     * Handle the fang attr "created" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function creating(FangAttr $fangAttr)
    {
        $field_name = request()->get('field_name');

    }

    /**
     * Handle the fang attr "updated" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function updated(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "deleted" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function deleted(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "restored" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function restored(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "force deleted" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function forceDeleted(FangAttr $fangAttr)
    {
        //
    }
}
