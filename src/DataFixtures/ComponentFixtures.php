<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Component;

class ComponentFixtures extends ParentFixtures
{

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 100;
        
        $this->component();
        $this->manager->flush();
    }
   
    private function component()
    {
        for ($i = 0; $i <= $this->entrys; $i++){

            $component = new Component();
            $component->setCategory(rand(0, $this->entrys));
            $component->setLink('component' . rand(0, $this->entrys));
            $component->setTitle('component ' . rand(0, $this->entrys));
            $component->setDescription('Some Random Text ' . rand(0, $this->entrys));
            $component->setPicture(rand(0, $this->entrys));
            $component->setTags($this->getJson(7));
    
            $this->manager->persist($component);
        }
    }

}