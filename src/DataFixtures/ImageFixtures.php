<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Image;

class ImageFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var int
     */
    private $entrys;

    /**
     * @param ObjectManager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->entrys = 100;

        $this->image();

        $this->manager->flush();
    }

    private function image(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $image = new Image();

            $image->setUploadedFile(
                new UploadedFile('/var/www/html/public/img/placeholder.jpg', 'bildschirmfoto.jpg')
            );

            $image->setTitle('image '.rand(0, $this->entrys));
            $image->setDescription('Some Random Text '.rand(0, $this->entrys));

            $this->manager->persist($image);
        }
    }
}
