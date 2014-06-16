<?php

namespace MarincsakIstvan\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;
use MarincsakIstvan\ApiBundle\Entity\Type as RobotType;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Robot
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="name_unique_idx", columns={"name"})}))
 * @ORM\Entity(repositoryClass="MarincsakIstvan\ApiBundle\Entity\RobotRepository")
 * @UniqueEntity(fields="name", message="Name is already in use")
 * @ExclusionPolicy("none")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Robot
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Type("string")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Name field is required")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Type
     *
     * @Assert\NotBlank(message="Type field is required")
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Type("string")
     * @Accessor(getter="getTypeName")
     */
    private $type;

    /**
     * @var integer
     *
     * @Assert\NotBlank(message="Year field is required")
     * @Assert\GreaterThan(
     *      value = 1970,
     *      message = "You are too old robot :)"
     * )
     * @Type("string")
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var \DateTime
     *
     * @Exclude()
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \DateTime $created
     *
     * @Exclude()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $created
     *
     * @Exclude()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Visszaadja a type nevét
     *
     * @return string
     */
    public function getTypeName() {
        if(!$this->type) {
            return '';
        }
        return $this->type->getName();
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
     * @param string $name
     * @return Robot
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
     * Set type
     *
     * @param string $type
     * @return Type
     */
    public function setType(RobotType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Robot
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
