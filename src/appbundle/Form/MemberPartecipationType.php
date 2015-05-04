<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberPartecipationType extends AbstractType
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

        $builder->add('expected', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Expected'
        ));
        $builder->add('happened', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Happened'
        ));

    }

    public function getName()
    {
        return 'member_partecipation';
    }
}