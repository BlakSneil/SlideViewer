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

        $builder->add('streetName', 'text');
        $builder->add('streetNumber', 'text');
        $builder->add('locality', 'text');
        $builder->add('zipCode', 'text');
        $builder->add('state', 'text');
        $builder->add('telephoneNumber', 'text');
        $builder->add('cellularNumber', 'text');
        $builder->add('email', 'email');
        $builder->add('notes', 'textarea');

        $builder->add('school', 'text');

        $builder->add('liveYear', 'entity', array(
            'class' => 'AppBundle:LiveYear',
            'property' => 'name',
        ));
        $builder->add('cell', 'entity', array(
            'class' => 'AppBundle:Cell',
            'property' => 'name',
        ));

        $builder->add('pathPhoto', 'file');

        $builder->add('color', 'entity', array(
            'class' => 'AppBundle:Color',
            'property' => 'name',
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
