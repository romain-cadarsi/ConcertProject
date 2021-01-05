<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Band;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $b1 = new Band();
        $b1->setName('Korn')
            ->setStyle('Metal')
            ->setPicture(new Picture('Korn.jpg', 'Korn Band'))
            ->setYearOfCreation(new \DateTime(1993))
            ->setLastAlbumName('The Nothing')
            ->addMember($this->getReference(MemberFixture::KORN_1))
            ->addMember($this->getReference(MemberFixture::KORN_2))
            ->addMember($this->getReference(MemberFixture::KORN_3))
            ->addMember($this->getReference(MemberFixture::KORN_4))
            ->addMember($this->getReference(MemberFixture::KORN_5));

        $manager->persist($b1);
        $manager->persist($b1->getPicture());

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MemberFixture::class,
        );
    }
}