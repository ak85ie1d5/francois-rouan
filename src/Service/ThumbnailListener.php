<?php
namespace App\Service;

use App\Entity\OeuvreMediaTest;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\File;

class ThumbnailListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::POST_UPLOAD => 'onPostUpload',
            Events::PRE_REMOVE => 'onPreRemove',
        ];
    }

    public function onPostUpload(Event $event): void
    {
        $entity = $event->getObject();

        // Ensure the entity is an instance of the class that holds the uploaded file
        if (!$entity instanceof OeuvreMediaTest) {
            return;
        }

        $file = $entity->getImageFile();

        if (!$file instanceof File) {
            return;
        }

        $imagick = new \Imagick($file->getRealPath());
        $imagick->thumbnailImage(370, 0);  // Resize to 370px width, maintaining aspect ratio

        // Save the thumbnail to the thumbnail directory
        $thumbnailPath = pathinfo($file->getRealPath(), PATHINFO_DIRNAME).'/thumbnail_'.$file->getBasename();
        file_put_contents($thumbnailPath, $imagick->getImageBlob());
    }

    public function onPreRemove(Event $event): void
    {
        $entity = $event->getObject();

        // Ensure the entity is an instance of the class that holds the uploaded file
        if (!$entity instanceof OeuvreMediaTest) {
            return;
        }

        $file = $entity->getImageFile();

        if (!$file instanceof File) {
            return;
        }

        // Construct the thumbnail path
        $thumbnailPath = pathinfo($file->getRealPath(), PATHINFO_DIRNAME).'/thumbnail_'.$file->getBasename();

        // Delete the thumbnail if it exists
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }
}