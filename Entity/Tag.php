<?php
namespace Dime\TimetrackerBundle\Entity;

use Dime\TimetrackerBundle\Entity\Timeslice;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SerializerBundle\Annotation\SerializedName;

/**
 * Dime\TimetrackerBundle\Entity\Tag
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Dime\TimetrackerBundle\Entity\TagRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tag
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
     * @var string $name
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $name;

    /**
     * Entity constructor
     */
    public function __construct()
    {
        $this->timeslices = new ArrayCollection();
    }

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
     * Set name
     *
     * @param  string   $name
     * @return Tag
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
     * get tag as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}

