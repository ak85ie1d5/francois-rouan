<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\ExhibitionFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class ExhibitionFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(ExhibitionFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $values = $filterDataDto->getValue();

        if ($values !== null) {
            $queryBuilder->leftJoin($filterDataDto->getEntityAlias() . '.oeuvreExpositions', 'oe');

            if ($values->getTitre() !== null) {
                $queryBuilder
                    ->andWhere('oe.titre LIKE :titre')
                    ->setParameter('titre', '%' . $values->getTitre() . '%');
            }


            if ($values->getDescription() !== null) {
                $queryBuilder
                    ->andWhere('oe.description LIKE :description')
                    ->setParameter('description', '%' . $values->getDescription() . '%');
            }
        }
    }
}
