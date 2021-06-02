<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="player_positions")
 */
class PlayerPositions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="id")
     * @ORM\JoinColumn(name="position", referencedColumnName="id")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="positions")
     * @ORM\JoinColumn(name="player", referencedColumnName="id")
     */
    private $player;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player): void
    {
        $this->player = $player;
    }
}
