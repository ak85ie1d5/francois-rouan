<?php

namespace App\Service;

use App\Entity\InternalLocation;
use App\Repository\InternalLocationRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * Doctrine event subscriber that automatically reorders the InternalLocation
 * nested set tree by RoomCode (ascending) after any persist or update operation.
 *
 * It sets a flag on postPersist/postUpdate, then triggers the actual reorder
 * in postFlush, once all lft/rgt values have been stabilized by the Gedmo Tree listener.
 */
#[AsDoctrineListener(event: Events::postPersist)]
#[AsDoctrineListener(event: Events::postUpdate)]
#[AsDoctrineListener(event: Events::postFlush)]
class InternalLocationTreeSubscriber
{
    /**
     * Flag indicating whether a reorder is needed after the current flush cycle.
     * @var bool
     */
    private bool $needsReorder = false;

    /**
     * Sets the reorder flag when an InternalLocation entity has been persisted.
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        if ($args->getObject() instanceof InternalLocation) {
            $this->needsReorder = true;
        }
    }

    /**
     * Sets the reorder flag when an InternalLocation entity has been updated.
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        if ($args->getObject() instanceof InternalLocation) {
            $this->needsReorder = true;
        }
    }

    /**
     * Reorders the entire InternalLocation tree by RoomCode (ASC) after the flush is complete.
     *
     * This method is intentionally called in postFlush (not postPersist/postUpdate) to ensure
     * that all lft/rgt nested set values computed by the Gedmo Tree listener are already
     * written to the database before reordering.
     *
     * The reorder() call executes direct SQL UPDATE statements and does NOT trigger
     * a new flush, so there is no risk of infinite recursion.
     *
     * @param PostFlushEventArgs $args
     * @return void
     */
    public function postFlush(PostFlushEventArgs $args): void
    {
        if (!$this->needsReorder) {
            return;
        }

        $this->needsReorder = false;

        /**
         * @Var InternalLocationRepository $repo
         */
        $repo = $args->getObjectManager()->getRepository(InternalLocation::class);
        $repo->reorder(null, 'RoomCode', 'ASC');
    }
}
