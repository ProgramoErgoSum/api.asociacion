<?php

namespace App\DataFixtures;

use App\Entity\Partner;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PartnerFixtures extends Fixture
{
    public const PARTNER_1_REFERENCE = 1;
    public const PARTNER_2_REFERENCE = 2;

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $k=>$v) {
            $partner = new Partner();
            $partner->setCode($v['code']);
            $partner->setName($v['name']);
            $partner->setSurname($v['surname']);
            $partner->setEmail($v['email']);
            $partner->setPassword($v['password']);
            $partner->setSalt($v['salt']);
            $partner->setActive($v['active']);
            $partner->setRole($v['role']);
            $partner->setCDate($v['cdate']);
            $partner->setMDate($v['mdate']);
    
            if($k===0) $this->addReference(self::PARTNER_1_REFERENCE, $partner);
            if($k===1) $this->addReference(self::PARTNER_2_REFERENCE, $partner);

            $manager->persist($partner);
        }
    
        $manager->flush();
    }

    private function getData()
    {
        return [
            [
                'code' => 'AAAAAA', 'name' => 'Name 1', 'surname' => 'Surname 1','email' => 'email1@email.com',
                'password' => password_hash('pa$$w0rd', PASSWORD_BCRYPT, array('cost' => 4)),'salt' => md5(uniqid()),
                'active' => 1, 'role' => Partner::ROLE_PREMIUM, 
                'cdate' => new \DateTime('2015-01-01'), 'mdate' => new \DateTime('2015-01-01')
            ],
            [
                'code' => 'BBBBBB', 'name' => 'Name 2', 'surname' => 'Surname 2','email' => 'email2@email.com',
                'password' => password_hash('pa$$w0rd', PASSWORD_BCRYPT, array('cost' => 4)),'salt' => md5(uniqid()),
                'active' => 1, 'role' => Partner::ROLE_PREMIUM, 
                'cdate' => new \DateTime('2015-01-01'), 'mdate' => new \DateTime('2015-01-01')
            ],
            [
                'code' => 'CCCCCC', 'name' => 'Name 3', 'surname' => 'Surname 3','email' => 'email3@email.com',
                'password' => password_hash('pa$$w0rd', PASSWORD_BCRYPT, array('cost' => 4)),'salt' => md5(uniqid()),
                'active' => 1, 'role' => Partner::ROLE_USER, 
                'cdate' => new \DateTime('2015-01-01'), 'mdate' => new \DateTime('2015-01-01')
            ],
            [
                'code' => 'DDDDDD', 'name' => 'Name 4', 'surname' => 'Surname 4','email' => 'email4@email.com',
                'password' => password_hash('pa$$w0rd', PASSWORD_BCRYPT, array('cost' => 4)),'salt' => md5(uniqid()),
                'active' => 0, 'role' => Partner::ROLE_PREMIUM, 
                'cdate' => new \DateTime('2015-01-01'), 'mdate' => new \DateTime('2015-01-01')
            ],
        ];
    }
}
