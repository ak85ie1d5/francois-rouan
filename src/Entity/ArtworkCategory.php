<?php

namespace App\Entity;

use App\Repository\ArtworkCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Umanit\EasyAdminTreeBundle\Entity\AbstractTreeItem;

#[ORM\Entity(repositoryClass: ArtworkCategoryRepository::class)]
class ArtworkCategory extends AbstractTreeItem
{

}
