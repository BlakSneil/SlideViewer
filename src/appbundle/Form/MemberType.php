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
    }

    public function getName()
    {
        return 'member';
    }
}
