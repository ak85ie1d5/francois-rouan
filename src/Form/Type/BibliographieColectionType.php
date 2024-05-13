<?php
 namespace App\Form\Type;

 use App\Entity\OeuvreBibliographie;
 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\Extension\Core\Type\IntegerType;
 use Symfony\Component\Form\Extension\Core\Type\TextareaType;
 use Symfony\Component\Form\Extension\Core\Type\TextType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class BibliographieColectionType extends AbstractType
 {
     public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $builder
             ->add('titre', TextType::class)
             ->add('Year', IntegerType::class, ['label' => 'Année'])
             ->add('description', TextareaType::class)
             ->add('commentaire', TextareaType::class);
     }

     public function configureOptions(OptionsResolver $resolver)
     {
         $resolver->setDefaults([
             'data_class' => OeuvreBibliographie::class
         ]);
     }
 }