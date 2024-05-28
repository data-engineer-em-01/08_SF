<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\BookFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(10);

        BookFactory::createMany(100, function () {
            return [
                // propre à la relation many to many
                'categories' => CategoryFactory::randomRange(1,2)
            ];
        });
    }
}
