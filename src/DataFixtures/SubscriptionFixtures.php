<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use App\Entity\Subscription;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $k=>$v) {
            $subscription = new Subscription();
            $subscription->setPartner($v['partner']);
            $subscription->setInDate($v['indate']);
            $subscription->setOutDate($v['outdate']);
            $subscription->setInfo($v['info']);
            $subscription->setPrice($v['price']);
    
            $manager->persist($subscription);
        }
    
        $manager->flush();
    }

    private function getData()
    {
        return [
            [
                'partner' => $this->getReference(PartnerFixtures::PARTNER_1_REFERENCE), 'info' => 'Suscripción 1', 'price' => '1.11',
                'indate' => new \DateTime('2015-01-01'), 'outdate' => new \DateTime('2016-01-01')
            ],
            [
                'partner' => $this->getReference(PartnerFixtures::PARTNER_1_REFERENCE), 'info' => 'Suscripción 2', 'price' => '1.11',
                'indate' => new \DateTime('2016-01-01'), 'outdate' => new \DateTime('2017-01-01')
            ],
            [
                'partner' => $this->getReference(PartnerFixtures::PARTNER_1_REFERENCE), 'info' => 'Suscripción 3', 'price' => '1.11',
                'indate' => new \DateTime('2017-01-01'), 'outdate' => new \DateTime('2018-01-01')
            ],
            [
                'partner' => $this->getReference(PartnerFixtures::PARTNER_1_REFERENCE), 'info' => 'Suscripción 4', 'price' => '1.11',
                'indate' => new \DateTime('2018-01-01'), 'outdate' => new \DateTime('2019-01-01')
            ],
            [
                'partner' => $this->getReference(PartnerFixtures::PARTNER_2_REFERENCE), 'info' => 'Suscripción 1', 'price' => '2.22',
                'indate' => new \DateTime('2015-01-01'), 'outdate' => new \DateTime('2016-01-01')
            ],
        ];
    }

    public function getDependencies()
    {
        return array(
            PartnerFixtures::class,
        );
    }
}
