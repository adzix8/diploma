<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var integer
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var float
     * @ORM\Column(name="top_speed", type="float")
     */
    private $topSpeed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistics", mappedBy="player", cascade={"persist", "remove"})
     */
    private $statistics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerPositions", mappedBy="player", cascade={"persist", "remove"})
     */
    private $positions;

    /**
     * @var float
     */
    private $score;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getTopSpeed(): ?float
    {
        return $this->topSpeed;
    }

    /**
     * @param float $topSpeed
     */
    public function setTopSpeed(float $topSpeed): void
    {
        $this->topSpeed = $topSpeed;
    }

    /**
     * @var Statistics
     * @return Collection|Statistics[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    /**
     * @return Collection|PlayerPositions[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * @param float $score
     */
    public function setScore(float $score): void
    {
        $this->score = $score;
    }
}
