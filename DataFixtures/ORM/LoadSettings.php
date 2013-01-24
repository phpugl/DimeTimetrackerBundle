<?php
namespace Dime\TimetrackerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Dime\TimetrackerBundle\Entity\Setting;

class LoadSettings extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dayFilterSetting = new Setting();
        $dayFilterSetting->setNamespace('activity-filter');
        $dayFilterSetting->setName('date-period');
        $dayFilterSetting->setValue('this-week');
        $dayFilterSetting->setUser($manager->merge($this->getReference('default-user')));
        $manager->persist($dayFilterSetting);

        $manager->flush();
    }

    /**
     * the order in which fixtures will be loaded
     *
     * @return int
     */
    public function getOrder()
    {
        return 80;
    }
}

