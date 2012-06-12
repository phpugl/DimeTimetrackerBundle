<?php
namespace Dime\TimetrackerBundle\Entity;

use DateTime;
use Dime\TimetrackerBundle\Entity\User;
use Dime\TimetrackerBundle\Entity\Customer;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\SerializerBundle\Annotation\SerializedName;

/**
 * Dime\TimetrackerBundle\Entity\Project
 *
 * @UniqueEntity("alias");
 * @ORM\Table(name="projects")
 * @ORM\Entity(repositoryClass="Dime\TimetrackerBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var Customer $customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="projects")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
     */
    protected $customer;

    /**
     * @var string $name
     *
     * @Assert\NotBlank()
     * @Gedmo\Slug(fields={"name"})
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

    /**
     * @var DateTime $startedAt
     *
     * @Assert\Date()
     * @SerializedName("startetAt")
     * @ORM\Column(name="started_at", type="datetime", nullable=true)
     */
    protected $startedAt;

    /**
     * @var DateTime $stoppedAt
     *
     * @Assert\Date()
     * @SerializedName("stoppedAt")
     * @ORM\Column(name="stopped_at", type="datetime", nullable=true)
     */
    protected $stoppedAt;

    /**
     * @var DateTime $deadline
     *
     * @Assert\Date()
     * @ORM\Column(name="deadline", type="datetime", nullable=true)
     */
    protected $deadline;

    /**
     * @var string $description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer $budgetPrice
     *
     * @SerializedName("budgetPrice")
     * @ORM\Column(name="budget_price", type="integer", nullable=true)
     */
    protected $budgetPrice;

    /**
     * @var integer $fixedPrice
     *
     * @SerializedName("fixedPrice")
     * @ORM\Column(name="fixed_price", type="integer", length=255, nullable=true)
     */
    protected $fixedPrice;

    /**
     * @var integer $budgetTime
     *
     * @SerializedName("budgetTime")
     * @ORM\Column(name="budget_time", type="integer", length=255, nullable=true)
     */
    protected $budgetTime;

    /**
     * @var float $rate
     *
     * @ORM\Column(type="decimal", scale=2, precision=10, nullable=true)
     */
    protected $rate;

    /**
     * @var datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @SerializedName("createdAt")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @SerializedName("updatedAt")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * Set user
     *
     * @param  User    $user
     * @return Project
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
     * Set customer
     *
     * @param  Customer $customer
     * @return Project
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Project
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
     * @param  string  $alias
     * @return Project
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
     * Set startedAt
     *
     * @param  DateTime $startedAt
     * @return Project
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return datetime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set stoppedAt
     *
     * @param  datetime $stoppedAt
     * @return Project
     */
    public function setStoppedAt($stoppedAt)
    {
        $this->stoppedAt = $stoppedAt;

        return $this;
    }

    /**
     * Get stoppedAt
     *
     * @return datetime
     */
    public function getStoppedAt()
    {
        return $this->stoppedAt;
    }

    /**
     * Set deadline
     *
     * @param  datetime $deadline
     * @return Project
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return datetime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set description
     *
     * @param  string  $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set budgetPrice
     *
     * @param  integer $budgetPrice
     * @return Project
     */
    public function setBudgetPrice($budgetPrice)
    {
        $this->budgetPrice = $budgetPrice;

        return $this;
    }

    /**
     * Get budgetPrice
     *
     * @return int
     */
    public function getBudgetPrice()
    {
        return $this->budgetPrice;
    }

    /**
     * Set fixedPrice
     *
     * @param  integer $fixedPrice
     * @return Project
     */
    public function setFixedPrice($fixedPrice)
    {
        $this->fixedPrice = $fixedPrice;

        return $this;
    }

    /**
     * Get fixedPrice
     *
     * @return int
     */
    public function getFixedPrice()
    {
        return $this->fixedPrice;
    }

    /**
     * Set budgetTime
     *
     * @param  integer $budgetTime
     * @return Project
     */
    public function setBudgetTime($budgetTime)
    {
        $this->budgetTime = $budgetTime;

        return $this;
    }

    /**
     * Get budgetTime
     *
     * @return int
     */
    public function getBudgetTime()
    {
        return $this->budgetTime;
    }

    /**
     * Set rate
     *
     * @param  float   $rate
     * @return Project
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get created at datetime
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updated at datetime
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * get project as string
     *
     * @return string
     */
    public function __toString()
    {
        return (empty($this->name)) ? $this->getId() : $this->getName();
    }
}
