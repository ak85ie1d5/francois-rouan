<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('prenom'),
            TextField::new('nom'),
            TextField::new('identifiant'),
            TextField::new('password')->setFormType(PasswordType::class)->hideOnIndex(),
            EmailField::new('email'),
            ArrayField::new('roles'),
            BooleanField::new('actif')->setValue(true),
            DateField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateField::new('dateModification')->setDisabled()->hideWhenCreating(),
            DateField::new('derniereConnexion')->setDisabled()->hideWhenCreating()

        ];
    }

}
