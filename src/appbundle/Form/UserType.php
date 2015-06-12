<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManager;

class UserType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // secondo me lo username non va fatto modificare, una volta che lo crei!
        // $builder->add('username', 'text');

        $builder->add('email', 'email', array('label' => 'Email'));
        $builder->add('enabled', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Enabled'
        ));
        $builder->add('locked', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Locked'
        ));
        $builder->add('credentials_expired', 'choice', array(
            'choices' => array('0' => 'No', '1' => 'Yes'),
            'label' => 'Credentials expired'
        ));
        $builder->add('credentials_expire_at', 'date', array(
            'label' => 'Credentials expire at',
            'widget' => 'single_text',
            'required' => false
        ));
        
        // $builder->add('roles', 'entity', array(
        //     'class' => 'BSUserBundle:Role',
        //     'property' => 'role',
        //     'expanded' => true,
        //     'multiple' => true
        // ));

        $builder->add('roles', 'choice', array(
            //'mapped'  => false,
            'choices' => $this->buildRoleChoices(),
            'expanded' => true,
            'multiple' => true
        ));


        /*
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
        ));
        */
    }

    public function getName()
    {
        return 'app_bundle_user_type';
    }

    protected function buildRoleChoices() {
        $choices = [];
        $repo = $this->em->getRepository('AppBundle:Role');
        $roles = $repo->findAll();

        foreach ($roles as $role) {
            $choices[$role->getRole()] = $role->getRole();
        }

        return $choices;
    }
}
