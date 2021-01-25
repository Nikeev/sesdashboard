<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create($attributes = [])
 */
final class UserFactory extends ModelFactory
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->unique()->safeEmail,
            'username' => self::faker()->userName,
            'password' => '12345678',
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            ->afterInstantiate(function(User $user) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            })
        ;
    }

    public function admin(): self
    {
        // call setPublishedAt() and pass a random DateTime
        return $this->addState([
            'email' => 'admin@admin.com',
            'username' => 'Admin',
        ]);
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
