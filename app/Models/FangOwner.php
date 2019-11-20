<?php

namespace App\Models;

use App\Observers\FangOwnerObserver;

class FangOwner extends Base {

    protected static function boot() {
        parent::boot();
        self::observe(FangOwnerObserver::class);
    }

}
