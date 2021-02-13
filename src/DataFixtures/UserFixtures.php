<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $usersData = [
            [
                'email' => 'admin@admin.ru',
                'role' => ['ROLE_ADMIN'],
                'name' => 'Алексей',
                'password' => 'admin'
            ],
            [
                'email' => 'user@admin.ru',
                'role' => ['ROLE_USER'],
                'name' => 'Иван',
                'password' => 'user'
            ]
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setRoles($user['role']);
            $newUser->setName($user['name']);
            $newUser->setPassword($this->passwordEncoder->encodePassword($newUser, $user['password']));
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
