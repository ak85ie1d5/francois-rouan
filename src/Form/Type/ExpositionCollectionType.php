<?php
namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreExposition;
use App\Service\Options;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpositionCollectionType extends AbstractType
{
    private $options;

    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoutez ici les champs que vous souhaitez afficher pour chaque élément de la collection OeuvreHistorique
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class)
            ->add('FirstDay', ChoiceType::class, [
                'choices' => $this->options->getDayNumeric(),
                'label' => 'Jour'
            ])
            ->add('FirstMonth', ChoiceType::class, [
                'choices' => $this->options->getMonthTextual(),
                'label' => 'Mois'
            ])
            ->add('FirstYear', IntegerType::class, [
                'label' => 'Année'
            ])
            ->add('SecondDay', ChoiceType::class, [
                'choices' => $this->options->getDayNumeric(),
                'label' => 'Jour'
            ])
            ->add('SecondMonth', ChoiceType::class, [
                'choices' => $this->options->getMonthTextual(),
                'label' => 'Mois'
            ])
            ->add('SecondYear', IntegerType::class, [
                'label' => 'Année'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreExposition::class
        ]);
    }
}
