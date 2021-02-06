<?php

namespace App\Factory;

use App\Entity\Email;
use App\Entity\EmailEvent;
use App\Repository\EmailEventRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static EmailEvent|Proxy createOne(array $attributes = [])
 * @method static EmailEvent[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static EmailEvent|Proxy findOrCreate(array $attributes)
 * @method static EmailEvent|Proxy random(array $attributes = [])
 * @method static EmailEvent|Proxy randomOrCreate(array $attributes = [])
 * @method static EmailEvent[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static EmailEvent[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmailEventRepository|RepositoryProxy repository()
 * @method EmailEvent|Proxy create($attributes = [])
 */
final class EmailEventFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'event' => self::faker()->boolean(82) ?
                self::faker()->randomElement([
                    EmailEvent::EVENT_OPEN,
                    EmailEvent::EVENT_CLICK,
                ]) :
                self::faker()->randomElement([
                    EmailEvent::EVENT_REJECT,
                    EmailEvent::EVENT_BOUNCE,
                    EmailEvent::EVENT_COMPLAINT,
                    EmailEvent::EVENT_FAILURE,
            ]),
            'timestamp' => self::faker()->dateTimeBetween('-5 days', '-1 minute'),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(EmailEvent $emailEvent) {})
        ;
    }

    protected static function getClass(): string
    {
        return EmailEvent::class;
    }
}
