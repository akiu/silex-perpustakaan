<?php

namespace ExpressLibrary\Forms;

use Symfony\Component\Form\AbstractType;
use SYmfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ExpressLibrary\Validator\Constraints\UniqueEmail;
use ExpressLibrary\Validator\Constraints\UniqueUserName;

class SignupType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('username', 'text',
            [
                'constraints' => [
                    new Assert\NotBlank(),
                    new UniqueUserName()
                ]
            ]
        )

				->add('password', 'repeated',
					[
    					'type' => 'password',
    					'invalid_message' => 'The password fields must match.',
    					'options' =>
                            [
                                'attr' =>
                                    [
                                        'class' => 'password-field'
                                    ],
    					        'required' => true
                            ],
                        'first_options'  => ['label' => 'Password'],
                        'second_options' => ['label' => 'Repeat Password']

                    ])

				->add('email', 'email',
                    [
					    'constraints' =>
                            [
                                new Assert\NotBlank(),
                                new Assert\Email(),
                                new UniqueEmail()
                            ]
					]
                )
				->add('signup', 'submit');
	}
}
