<?php

namespace Dime\TimetrackerBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dime\TimetrackerBundle\Entity\Setting
 *
 * @UniqueEntity(fields={"key", "namespace", "user"})
 * @ORM\Table(
 *      name="settings",
 *      uniqueConstraints={ @ORM\UniqueConstraint(name="unique_setting_key_user", columns={"key", "namespace", "user_id"}) }
 * )
 * @ORM\Entity(repositoryClass="Dime\TimetrackerBundle\Entity\SettingRepository")
 */
class Setting extends Entity
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $key
     *
     * @Assert\NotNull()
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    protected $key;

    /**
     * @var string $namespace
     *
     * @Assert\NotNull()
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    protected $namespace;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param  string   $key
     * @return Setting
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set namespace
     *
     * @param  string   $namespace
     * @return Setting
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set value
     *
     * @param  string  $value
     * @return Setting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
