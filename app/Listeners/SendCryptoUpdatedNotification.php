<?php

namespace App\Listeners;

use App\Events\CryptoUpdated;

class SendCryptoUpdatedNotification
{
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
     * @param  \App\Events\Crypto  $event
     * @return void
     */
    public function handle(CryptoUpdated $asset)
    {
    }
}
