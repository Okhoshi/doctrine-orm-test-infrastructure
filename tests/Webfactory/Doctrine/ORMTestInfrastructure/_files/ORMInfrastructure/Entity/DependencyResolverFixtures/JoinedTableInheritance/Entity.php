<?php

namespace Webfactory\Doctrine\ORMTestInfrastructure\_files\ORMInfrastructure\Entity\DependencyResolverFixtures\JoinedTableInheritance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class", type="string")
 * @ORM\DiscriminatorMap({"base" = "BaseEntity",  "sub" = "Entity"})
 */
class BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column
     */
    protected $fieldA;
}

/**
 * @ORM\Entity()
 */
class Entity extends BaseEntity
{
    /**
     * @ORM\Column
     */
    protected $fieldB;
}
