<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\LocationFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class LocationFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(LocationFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $values = $filterDataDto->getValue();

        if ($values !== null) {
            $queryBuilder->leftJoin($filterDataDto->getEntityAlias() . '.oeuvreStockages', 'os');

            if ($values->getType() !== null) {
                $queryBuilder
                    ->andWhere('os.type = :type')
                    ->setParameter('type', $values->getType());
            }

            if ($values->getPrecisions() !== null) {
                $queryBuilder
                    ->andWhere('os.precisions = :precisions')
                    ->setParameter('precisions', $values->getPrecisions());
            }

            if ($values->getLieu() !== null) {
                $queryBuilder
                    ->andWhere('os.lieu = :lieu')
                    ->setParameter('lieu', $values->getLieu());
            }

            if ($values->getDescription() !== null) {
                $queryBuilder
                    ->andWhere('os.description LIKE :description')
                    ->setParameter('description', '%' . $values->getDescription() . '%');
            }
        }
    }
}
