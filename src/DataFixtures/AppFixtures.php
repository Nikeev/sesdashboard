<?php

namespace App\DataFixtures;

use App\Factory\EmailEventFactory;
use App\Factory\EmailFactory;
use App\Factory\ProjectFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Zenstruck\Foundry\Instantiator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = UserFactory::new()->admin()->create();

        $project = ProjectFactory::new()->create([
            'user' => $user,
        ]);

        EmailFactory::createMany(10, [
            'project' => $project,
        ]);

        $manager->flush();

        EmailEventFactory::createMany(70,
            function() {
                return ['email' => EmailFactory::random()];
            }
        );

        $manager->flush();
    }
}
