<?php

use App\Entity\Illustration;
use App\Service\FileUploader;

class IllustrationListener
{

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /** @PostRemove */
    public function postRemoveHandler(Illustration $illustration, LifecycleEventArgs $event)
    {
        $this->uploader->remove($illustration->getName());
    }
}
