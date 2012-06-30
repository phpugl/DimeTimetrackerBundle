<?php

namespace Dime\TimetrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AbstractType
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
            ->add('description')
            ->add('rate')
            ->add('rateReference')  // TODO: add constraints
            ->add('service')
            ->add('customer')
            ->add('project')
        ;
    }

    public function getName()
    {
        return 'dime_timetrackerbundle_activitytype';
    }
}
