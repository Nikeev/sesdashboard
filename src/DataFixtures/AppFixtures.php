<?php

namespace App\DataFixtures;

use App\Entity\EmailEvent;
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

        for ($i = 0; $i < 2; $i++) {
            EmailFactory::createMany(100, [
                'project' => $project,
            ]);

            $manager->flush();

            EmailEventFactory::createMany(100,
                function () {
                    return [
                        'email' => EmailFactory::random(),
                        'event' => EmailEvent::EVENT_SEND,
                    ];
                }
            );

            EmailEventFactory::createMany(82,
                function () {
                    return [
                        'email' => EmailFactory::random(),
                        'event' => EmailEvent::EVENT_DELIVERY,
                    ];
                }
            );

            $manager->flush();

            EmailEventFactory::createMany(700,
                function () {
                    return ['email' => EmailFactory::random()];
                }
            );

            $manager->flush();
        }
    }
}
