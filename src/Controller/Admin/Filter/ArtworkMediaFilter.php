<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\ArtworkMediaFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class ArtworkMediaFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(ArtworkMediaFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $values = $filterDataDto->getValue();

        if ($values !== null) {
            $queryBuilder->leftJoin($filterDataDto->getEntityAlias() . '.ArtworkMedias', 'am');

            if ($values->getNom() === '0') {
                $queryBuilder->andWhere('am.id IS NULL');
            }

            if ($values->getNom() === '1') {
                $queryBuilder->andWhere('am.id IS NOT NULL');
            }
        }
    }
}
