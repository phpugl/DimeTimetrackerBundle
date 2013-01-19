<?php
namespace Dime\TimetrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Dime\TimetrackerBundle\Entity\Tag
 *
 * @UniqueEntity(fields={"name", "user"})
 * @ORM\Table(
 *      name="tags",
 *      uniqueConstraints={ @ORM\UniqueConstraint(name="unique_tag_name_user", columns={"name", "user_id"}) }
 * )
 * @ORM\Entity(repositoryClass="Dime\TimetrackerBundle\Entity\TagRepository")
 */
class Tag extends Entity
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
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    protected $name;

    /**
     * is tag for intern system purposes
     *
     * @var boolean $system
     *
     * @ORM\Column(type="boolean")
     */
    protected $system;

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

    /**
     * @param boolean $system
     */
    public function setSystem($system)
    {
        $this->system = $system;
    }

    /**
     * @return boolean
     */
    public function getSystem()
    {
        return $this->system;
    }


}

