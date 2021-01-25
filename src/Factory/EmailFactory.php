<?php

namespace App\Factory;

use App\Entity\Email;
use App\Repository\EmailRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Email|Proxy createOne(array $attributes = [])
 * @method static Email[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Email|Proxy findOrCreate(array $attributes)
 * @method static Email|Proxy random(array $attributes = [])
 * @method static Email|Proxy randomOrCreate(array $attributes = [])
 * @method static Email[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Email[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmailRepository|RepositoryProxy repository()
 * @method Email|Proxy create($attributes = [])
 */
final class EmailFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'message_id' => self::faker()->uuid,
            'destination' => [
                self::faker()->safeEmail,
            ],
            'source' => self::faker()->safeEmail,
            'subject' => self::faker()->realText(50),
            'status' => self::faker()->boolean(70)
                ? Email::EMAIL_STATUS_DELIVERED : self::faker()->randomElement([Email::EMAIL_STATUS_SENT, Email::EMAIL_STATUS_NOT_DELIVERED]),
            'timestamp' => self::faker()->dateTimeBetween('-5 days', '-1 minute'),
            'opens' => self::faker()->randomNumber(1),
            'clicks' => self::faker()->randomNumber(1),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Email $email) {})
        ;
    }

    protected static function getClass(): string
    {
        return Email::class;
    }
}
