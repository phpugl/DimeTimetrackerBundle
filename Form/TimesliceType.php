<?php

namespace Dime\TimetrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TimesliceType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class'      => 'Dime\Timetracker\Entity\Activity',
            'csrf_protection' => false
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration')
            ->add('startedAt', 'datetime', array('required' => false, 'widget' => 'single_text', 'with_seconds' => true))
            ->add('stoppedAt', 'datetime', array('required' => false, 'widget' => 'single_text', 'with_seconds' => true))
            ->add('activity')
        ;
    }

    public function getName()
    {
        return 'dime_timetrackerbundle_timeslicetype';
    }
}
