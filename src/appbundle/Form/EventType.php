<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('description', 'text');
        $builder->add('dateFrom', 'date', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false
        ));
        $builder->add('dateTo', 'date', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false
        ));
        $builder->add('locality', 'text', array('required' => false));
        $builder->add('notes', 'textarea', array('required' => false));
    }

    public function getName()
    {
        return 'event';
    }
}