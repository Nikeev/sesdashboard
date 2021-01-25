<?php

namespace App\Factory;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Utils\TokenGenerator;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Project|Proxy createOne(array $attributes = [])
 * @method static Project[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Project|Proxy findOrCreate(array $attributes)
 * @method static Project|Proxy random(array $attributes = [])
 * @method static Project|Proxy randomOrCreate(array $attributes = [])
 * @method static Project[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Project[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ProjectRepository|RepositoryProxy repository()
 * @method Project|Proxy create($attributes = [])
 */
final class ProjectFactory extends ModelFactory
{

    private $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        parent::__construct();
        $this->tokenGenerator = $tokenGenerator;
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->domainName,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            ->afterInstantiate(function(Project $project) {
                $project->setToken($this->tokenGenerator->generate());
            })
        ;
    }

    protected static function getClass(): string
    {
        return Project::class;
    }
}
