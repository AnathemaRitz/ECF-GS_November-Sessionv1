<?php

namespace App\EventListener;

use App\Entity\Order;
use Doctrine\ORM\Event\PreUpdateEventArgs;
class OrderStateChangeListener
{
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Order) {
            return;
        }

        $changeSet = $event->getEntityChangeSet();

        if (isset($changeSet['state'])) {
//                $entity->setUpdatedAt(new \DateTimeImmutable());
//            dd ("Je suis dans le listener");
            }
        }
}
