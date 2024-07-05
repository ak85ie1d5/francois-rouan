<?php
namespace App\Service;

use App\Entity\Trait\UserColumnTrait;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Bundle\SecurityBundle\Security;

class UserColumnSubscriber implements EventSubscriber
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(UserColumnTrait::class, class_uses($entity))) {
            $entity->setCreatedBy($this->security->getUser());
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array(UserColumnTrait::class, class_uses($entity))) {
            $entity->setUpdatedBy($this->security->getUser());
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
            Events::preUpdate => 'preUpdate',
        ];
    }
}