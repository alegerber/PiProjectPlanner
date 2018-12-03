<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends ParentFixtures
{

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 50;
        
        $this->tag();
        $this->manager->flush();
        

    }

    private function tag()
    {
        for ($i = 0; $i <= $this->entrys; $i++){
            $tag = new Tag();
            $tag->setName('tag ' .rand(0, $this->entrys));
            

            $tag->setProject($this->getJson(7));
    
            $this->manager->persist($tag);
        }
    }
}