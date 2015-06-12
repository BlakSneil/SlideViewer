<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
        ));
    }

    public function getName()
    {
        return 'user_password';
    }
}
