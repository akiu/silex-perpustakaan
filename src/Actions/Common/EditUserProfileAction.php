<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;
use ExpressLibrary\Entities\UserProfile;

class EditUserProfileAction extends BaseAction
{
    public function handle(UserProfile $profile)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $fs = $this->app['fs'];

        $userId = $session->get('userId');

        $userId = $userId['value'];

        $userProfile = $conn->fetchAssoc("SELECT * FROM userProfile WHERE userId = ?", [$userId]);

        if (!$userProfile) {

            $conn->insert('userProfile', ['userId' => $userId]);

        }





        //if ($userProfile) {

            if ($profile->getNamaDepan()) {

                $conn->update("userProfile",
                    [
                        'namaDepan' => $profile->getNamaDepan()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getNamaBelakang()) {

                $conn->update("userProfile",
                    [
                        'namaBelakang' => $profile->getNamaBelakang()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getTtl()) {

                $conn->update("userProfile",
                    [
                        'ttl' => $profile->getTtl()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getAlamat()) {

                $conn->update("userProfile",
                    [
                        'alamat' => $profile->getAlamat()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getJenisIdentitas()) {

                $conn->update("userProfile",
                    [
                        'jenisIdentitas' => $profile->getJenisIdentitas()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getNoIdentitas()) {

                $conn->update("userProfile",
                    [
                        'noIdentitas' => $profile->getNoIdentitas()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getNoIdentitas()) {

                $conn->update("userProfile",
                    [
                        'noIdentitas' => $profile->getNoIdentitas()
                    ],
                    [
                        'userId' => $userId
                    ]

            );

            }

            if ($profile->getProfilePicture()) {

                $image = $profile->getProfilePicture();

                if ($userProfile['profilePicturePath']) {

                    $fs->remove($userProfile['profilePicturePath']);

                    $image->move('profilePicture', ltrim($userProfile['profilePicturePath'], 'profilePicture/'));


                } else {

                    $name = (string)$userId;

                    $exts = $image->guessExtension();

                    $image->move('profilePicture', $name . "." . $exts);

                    $conn->update("userProfile",
                        [
                            'profilePicturePath' => "profilePicture/" . $name . "." . $exts
                        ],
                        [
                            'userId' => $userId
                        ]
                    );
                }

            }
    }
}