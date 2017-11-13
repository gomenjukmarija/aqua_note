<?php

namespace AppBundle\Form;

use AppBundle\Entity\SubFamily;
use AppBundle\Entity\User;
use AppBundle\Repository\SubFamilyRepository;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class GenusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('subFamily', EntityType::class, [
                'placeholder' => 'Choose a Sub Family',
                'class' => SubFamily::class,
                'query_builder' => function(SubFamilyRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('speciesCount')
            ->add('funFact', null)
            ->add('isPublished', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ]
            ])
            ->add('firstDiscoveredAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ])
            ->add('genusScientists', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'email',
                'query_builder' => function(UserRepository $repo) {
                    return $repo->createIsScientistQueryBuilder();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Genus'
        ]);
    }
}