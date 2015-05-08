<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text');
        $builder->add('surname', 'text');
        $builder->add('birthday', 'date', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ));

        $builder->add('streetName', 'text', array(
            'required' => false
        ));
        $builder->add('streetNumber', 'text', array(
            'required' => false
        ));
        $builder->add('locality', 'text', array(
            'required' => false
        ));
        $builder->add('zipCode', 'text', array(
            'required' => false
        ));
        //$builder->add('state', 'text', array(
        //    'required' => false
        //));
        $builder->add('telephoneNumber', 'text', array(
            'required' => false
        ));
        $builder->add('cellularNumber', 'text', array(
            'required' => false
        ));
        $builder->add('email', 'email', array(
            'required' => false
        ));
        $builder->add('notes', 'textarea', array(
            'required' => false
        ));

        $builder->add('school', 'text', array(
            'required' => false
        ));

        $builder->add('liveYear', 'entity', array(
            'class' => 'AppBundle:LiveYear',
            'property' => 'name',
            'required' => false
        ));
        $builder->add('cell', 'entity', array(
            'class' => 'AppBundle:Cell',
            'property' => 'name',
            'required' => false
        ));

        $builder->add('pathPhoto', 'file', array(
            'required' => false
        ));

        $builder->add('color', 'entity', array(
            'class' => 'AppBundle:Color',
            'property' => 'name',
            'required' => false
        ));

        $builder->add('isActive', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Is active'
        ));
    }

    public function getName()
    {
        return 'member';
    }
}
