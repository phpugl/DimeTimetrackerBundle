<?php

namespace Dime\TimetrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceType extends AbstractType
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
            ->add('description')
            ->add('rate')
        ;
    }

    public function getName()
    {
        return 'dime_timetrackerbundle_servicetype';
    }
}
