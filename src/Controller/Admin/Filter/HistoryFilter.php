<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\HistoryFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\ChoiceFilterType;

class HistoryFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(HistoryFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {

        $values = $filterDataDto->getValue();

        if ($values !== null) {
            $queryBuilder->leftJoin($filterDataDto->getEntityAlias() . '.oeuvreHistoriques', 'oh');

            if ($values->getUnmappedDescription() === '0') {
                $queryBuilder->andWhere('oh.oeuvre IS NULL');
            }

            if ($values->getUnmappedDescription() === '1') {
                $queryBuilder->andWhere('oh.oeuvre IS NOT NULL');
            }

            if ($values->getDescription() !== null) {
                $queryBuilder
                    ->andWhere('oh.description LIKE :description')
                    ->setParameter('description', '%' . $values->getDescription() . '%');
            }
        }
    }
}
