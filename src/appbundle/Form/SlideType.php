<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');

        $builder->add('description', 'text', array('required' => false));

        $builder->add('date_creation', 'date', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false
        ));

        $builder->add('width', 'number');

        $builder->add('height', 'number');

        $builder->add('tileDim', 'number');

        $builder->add('vendor', 'entity', array(
            'class' => 'AppBundle:Vendor',
            'property' => 'name',
        ));

        $builder->add('notes', 'textarea', array('required' => false));
    }

    public function getName()
    {
        return 'slide';
    }
}
