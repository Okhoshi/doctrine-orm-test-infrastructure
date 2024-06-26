<?php

namespace Webfactory\Doctrine\Tests\ORMTestInfrastructure\Fixtures\EntityWithAnnotation\DependencyResolverFixtures\JoinedTableInheritanceWithTwoSubclasses;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class", type="string")
 * @ORM\DiscriminatorMap({"base" = "BaseEntity",  "first" = "Entity", "second" = "SecondEntity"})
 */
#[ORM\Entity]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'class', type: 'string')]
#[ORM\DiscriminatorMap(['base' => 'BaseEntity', 'first' => 'Entity', 'second' => 'SecondEntity'])]
class BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    private $id;

    /**
     * @ORM\Column
     */
    #[ORM\Column]
    protected $fieldA;
}

/**
 * @ORM\Entity()
 */
#[ORM\Entity]
class SecondEntity extends BaseEntity
{
    /**
     * @ORM\Column
     */
    #[ORM\Column]
    protected $fieldB;
}

/**
 * @ORM\Entity()
 */
#[ORM\Entity]
class Entity extends BaseEntity
{
    /**
     * @ORM\Column
     */
    #[ORM\Column]
    protected $fieldC;
}
