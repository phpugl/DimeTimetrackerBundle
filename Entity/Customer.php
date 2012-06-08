<?php
namespace Dime\TimetrackerBundle\Entity;

use Dime\TimetrackerBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dime\TimetrackerBundle\Entity\Project
 *
 * @UniqueEntity("alias")
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="Dime\TimetrackerBundle\Entity\CustomerRepository")
 */
class Customer
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
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="customers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var string $name
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string $alias
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true, length=30)
     */
    protected $alias;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param  User     $user
     * @return Customer
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set name
     *
     * @param  string   $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alias
     *
     * @param  string   $alias
     * @return Customer
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * get customer as string
     *
     * @return string
     */
    public function __toString()
    {
        $customer = $this->getName();
        if (empty($customer)) {
            $customer = $this->getId();
        }

        return $customer;
    }
}
