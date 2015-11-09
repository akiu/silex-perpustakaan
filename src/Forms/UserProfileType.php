<?php

namespace ExpressLibrary\Forms;

use Symfony\Component\Form\AbstractType;
use SYmfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ExpressLibrary\Validator\Constraints\UniqueEmail;
use ExpressLibrary\Validator\Constraints\UniqueUserName;


class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('namaDepan', 'text',
            [
                'constraints' => [
                ]
            ]
        )
            ->add('namaBelakang', 'text',
                [
                    'constraints' =>
                        [
                        ]
                ]
            )
            ->add('ttl', 'text',
                [
                    'constraints' =>
                        [
                        ]
                ]
            )
            ->add('alamat', 'text',
                [
                    'constraints' =>
                        [

                        ]
                ]
            )
            ->add('jenisIdentitas', 'choice',
                [
                    'constraints' =>
                        [

                        ],
                    'choices' =>
                        [
                            'ktp' => 'KTP',
                            'sim' => 'SIM',
                            'kartuPelajar' => 'Kartu Pelajar'
                        ]
                ]
            )
            ->add('noIdentitas', 'text',
                [
                    'constraints' =>
                        [

                        ]
                ]
            )
            ->add('profilePicture', 'file',
                [
                    'constraints' =>
                        [

                            new Assert\File(
                                [
                                    'mimeTypes' => ['image/jpeg', 'image/png'],
                                    'mimeTypesMessage' => "Only JPG or PNG are allowed"
                                ]
                            )
                        ]
                ]
            )
            ->add('createProfile', 'submit');
    }
}