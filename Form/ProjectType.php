<?php

namespace Dime\TimetrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends AbstractType
{
    public function getDefaultOptions()
    {
        return array(
            'csrf_protection' => false
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('alias')
            ->add('customer')
            ->add('startedAt', 'datetime', array('required' => false, 'widget' => 'single_text', 'with_seconds' => true))
            ->add('stoppedAt', 'datetime', array('required' => false, 'widget' => 'single_text', 'with_seconds' => true))
            ->add('deadline', 'datetime', array('required' => false, 'widget' => 'single_text', 'with_seconds' => true))
            ->add('description')
            ->add('budgetPrice')
            ->add('fixedPrice')
            ->add('budgetTime')
            ->add('rate')
        ;
    }

    public function getName()
    {
        return 'dime_timetrackerbundle_projecttype';
    }
}
