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
        $dayFilterSetting->setNamespace('defaultActivityFilter');
        $dayFilterSetting->setName('date-period');
        $dayFilterSetting->setValue('D');
        $dayFilterSetting->setUser($manager->merge($this->getReference('default-user')));
        $manager->persist($dayFilterSetting);

        $withoutTagsFilterSetting = new Setting();
        $withoutTagsFilterSetting->setNamespace('defaultActivityFilter');
        $withoutTagsFilterSetting->setName('withoutTags');
        $withoutTagsFilterSetting->setValue('invoiced');
        $withoutTagsFilterSetting->setUser($manager->merge($this->getReference('default-user')));
        $manager->persist($withoutTagsFilterSetting);

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

