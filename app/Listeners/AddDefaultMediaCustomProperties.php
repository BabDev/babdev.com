<?php

namespace BabDev\Listeners;

use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class AddDefaultMediaCustomProperties
{
    public function handle(MediaHasBeenAdded $event): void
    {
        if (!$event->media->hasCustomProperty('downloads')) {
            $event->media->setCustomProperty('downloads', 0);
        }

        if (!$event->media->hasCustomProperty('md5_hash')) {
            $event->media->setCustomProperty('md5_hash', \hash_file('md5', $event->media->getPath()));
        }

        if (!$event->media->hasCustomProperty('sha1_hash')) {
            $event->media->setCustomProperty('sha1_hash', \hash_file('sha1', $event->media->getPath()));
        }

        $event->media->save();
    }
}
