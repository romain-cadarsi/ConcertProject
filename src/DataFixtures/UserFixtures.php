<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ConcertHall;
use App\Entity\Hall;
use Symfony\Component\Security\Core\User\User;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $ch1 = new \App\Entity\User();
        $ch1->setEmail('user@gmail.com')
            //Le mdp est roro
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$V1hHg+E9785IUr8SQbYIsA$08aPrj3wbsrds9TIUojv5b1FQr29VOfUCLVJXH3L1Dc')
            ->setFirstName('Utilisateur')
            ->setLastName('test');
        $manager->persist($ch1);

        $ch2 = new \App\Entity\User();
        $ch2->setEmail('admin@gmail.com')
            //Le mdp est roro
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$V1hHg+E9785IUr8SQbYIsA$08aPrj3wbsrds9TIUojv5b1FQr29VOfUCLVJXH3L1Dc')
            ->setFirstName('admin')
            ->setLastName('admin')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($ch2);

        $manager->flush();
    }

}