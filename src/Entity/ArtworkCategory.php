<?php

namespace App\Entity;

use App\Entity\Trait\TimeColumnTrait;
use App\Repository\ArtworkCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Umanit\EasyAdminTreeBundle\Entity\AbstractTreeItem;

#[ORM\Entity(repositoryClass: ArtworkCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ArtworkCategory extends AbstractTreeItem
{
    use TimeColumnTrait;
}
