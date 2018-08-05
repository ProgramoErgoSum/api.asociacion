<?php

namespace App\DataFixtures;

use App\Entity\Admin;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $k=>$v) {
            $admin = new Admin();
            $admin->setUsername($v['username']);
            $admin->setPassword($v['password']);
            $admin->setSalt($v['salt']);
            $admin->setRole($v['role']);

            $manager->persist($admin);
        }
    
        $manager->flush();
    }

    private function getData()
    {
        return [
            ['username' => 'admin', 'password' => password_hash('pa$$w0rd', PASSWORD_BCRYPT, ['cost' => 4]),'salt' => md5(uniqid()),'role' => Admin::ROLE_ADMIN]        
        ];
    }
}
