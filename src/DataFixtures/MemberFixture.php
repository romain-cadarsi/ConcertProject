<?php
namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Member;

/**
 * Class MemberFixtures
 * @package App\DataFixtures
 */
class MemberFixture extends Fixture
{
    public const KORN_1 = 'a1';
    public const KORN_2 = 'a2';
    public const KORN_3 = 'a3';
    public const KORN_4 = 'a4';
    public const KORN_5 = 'a5';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $a1 = new Member();
        $a1->setName('Jonathan')
            ->setFirstName('Davies')
            ->setjob('Chanteur')
            ->setBirthDate(\DateTime::createFromFormat("d/m/Y", '18/01/1971'))
            ->setPicture(new Picture('jonathanDavies.jpg', 'Jonhatan Davies'));
        $manager->persist($a1);
        $manager->persist($a1->getPicture());

        $a2 = new Member();
        $a2->setName('Reginald')
            ->setFirstName('Arvizu')
            ->setjob('Bassiste')
            ->setBirthDate(\DateTime::createFromFormat("d/m/Y", '02/11/1969'))
            ->setPicture(new Picture('reginaldArvizu.jpg', "regina Arvizu"));
        $manager->persist($a2);
        $manager->persist($a2->getPicture());

        $a3 = new Member();
        $a3->setName('James')
            ->setFirstName('Shaffer')
            ->setjob('Guitariste')
            ->setBirthDate(\DateTime::createFromFormat("d/m/Y", '06/06/1970'))
            ->setPicture(new Picture('jamesShaffer.jpg',"james Shaffer"));
        $manager->persist($a3);
        $manager->persist($a3->getPicture());

        $a4 = new Member();
        $a4->setName('Brian')
            ->setFirstName('Welch')
            ->setjob('Guitariste')
            ->setBirthDate(\DateTime::createFromFormat("d/m/Y", '19/06/1970'))
            ->setPicture(new Picture('brianWelch.jpg', "Brian Welch"));
        $manager->persist($a4);
        $manager->persist($a4->getPicture());

        $a5 = new Member();
        $a5->setName('Ray')
            ->setFirstName('Luzier')
            ->setJob('Batteur')
            ->setPicture(new Picture('rayLuzier.jpg', 'ray Luzier'))
            ->setBirthDate(\DateTime::createFromFormat("d/m/Y", '02/11/1969'));
        $manager->persist($a5);
        $manager->persist($a5->getPicture());

        $manager->flush();

        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::KORN_1, $a1);
        $this->addReference(self::KORN_2, $a2);
        $this->addReference(self::KORN_3, $a3);
        $this->addReference(self::KORN_4, $a4);
        $this->addReference(self::KORN_5, $a5);
    }
}