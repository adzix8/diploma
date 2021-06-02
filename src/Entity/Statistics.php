<?php
/**
 * Created by PhpStorm.
 * User: Adaś
 * Date: 10.05.2021
 * Time: 16:18
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="statistics")
 */
class Statistics
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="statistics")
     * @ORM\JoinColumn(name="player", referencedColumnName="id")
     */
    private $player;

    /**
     * @var integer
     * @ORM\Column(name="goals", type="integer")
     */
    private $goals;

    /**
     * @var integer
     * @ORM\Column(name="assists", type="integer")
     */
    private $assists;

    /**
     * @var integer
     * @ORM\Column(name="duals_won", type="integer")
     */
    private $dualsWon;

    /**
     * @var float
     * @ORM\Column(name="clearances", type="float")
     */
    private $clearances;

    /**
     * @var integer
     * @ORM\Column(name="errors", type="integer")
     */
    private $errors;

    /**
     * @var float
     * @ORM\Column(name="passes_completed", type="float")
     */
    private $passesCompleted;

    /**
     * @var float
     * @ORM\Column(name="crosses", type="float")
     */
    private $crosses;

    /**
     * @var float
     * @ORM\Column(name="dribbles", type="float")
     */
    private $dribbles;

    /**
     * @var integer
     * @ORM\Column(name="chances", type="integer")
     */
    private $chances;

    /**
     * @var float
     * @ORM\Column(name="touches", type="float")
     */
    private $touches;

    /**
     * @var integer
     * @ORM\Column(name="shoot_accuracy", type="integer")
     */
    private $shootAccuracy;

    /**
     * @var float
     * @ORM\Column(name="saves", type="float")
     */
    private $saves;

    /**
     * @var integer
     * @ORM\Column(name="clean_sheets", type="integer")
     */
    private $clean_sheets;

    /**
     * @var float
     * @ORM\Column(name="goals_conceded", type="float")
     */
    private $goalsConceded;

    /**
     * @var integer
     * @ORM\Column(name="penalty_saves", type="integer")
     */
    private $penaltySaves;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGoals(): int
    {
        return $this->goals;
    }

    /**
     * @param int $goals
     */
    public function setGoals(int $goals): void
    {
        $this->goals = $goals;
    }

    /**
     * @return int
     */
    public function getAssists(): int
    {
        return $this->assists;
    }

    /**
     * @param int $assists
     */
    public function setAssists(int $assists): void
    {
        $this->assists = $assists;
    }

    /**
     * @return int
     */
    public function getDualsWon(): int
    {
        return $this->dualsWon;
    }

    /**
     * @param int $dualsWon
     */
    public function setDualsWon(int $dualsWon): void
    {
        $this->dualsWon = $dualsWon;
    }

    /**
     * @return float
     */
    public function getClearances(): float
    {
        return $this->clearances;
    }

    /**
     * @param float $clearances
     */
    public function setClearances(float $clearances): void
    {
        $this->clearances = $clearances;
    }

    /**
     * @return int
     */
    public function getErrors(): int
    {
        return $this->errors;
    }

    /**
     * @param int $errors
     */
    public function setErrors(int $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return float
     */
    public function getPassesCompleted(): float
    {
        return $this->passesCompleted;
    }

    /**
     * @param float $passesCompleted
     */
    public function setPassesCompleted(float $passesCompleted): void
    {
        $this->passesCompleted = $passesCompleted;
    }

    /**
     * @return float
     */
    public function getCrosses(): float
    {
        return $this->crosses;
    }

    /**
     * @param float $crosses
     */
    public function setCrosses(float $crosses): void
    {
        $this->crosses = $crosses;
    }

    /**
     * @return float
     */
    public function getDribbles(): float
    {
        return $this->dribbles;
    }

    /**
     * @param float $dribbles
     */
    public function setDribbles(float $dribbles): void
    {
        $this->dribbles = $dribbles;
    }

    /**
     * @return int
     */
    public function getChances(): int
    {
        return $this->chances;
    }

    /**
     * @param int $chances
     */
    public function setChances(int $chances): void
    {
        $this->chances = $chances;
    }

    /**
     * @return float
     */
    public function getTouches(): float
    {
        return $this->touches;
    }

    /**
     * @param float $touches
     */
    public function setTouches(float $touches): void
    {
        $this->touches = $touches;
    }

    /**
     * @return int
     */
    public function getShootAccuracy(): int
    {
        return $this->shootAccuracy;
    }

    /**
     * @param int $shootAccuracy
     */
    public function setShootAccuracy(int $shootAccuracy): void
    {
        $this->shootAccuracy = $shootAccuracy;
    }

    /**
     * @return float
     */
    public function getSaves(): float
    {
        return $this->saves;
    }

    /**
     * @param float $saves
     */
    public function setSaves(float $saves): void
    {
        $this->saves = $saves;
    }

    /**
     * @return int
     */
    public function getCleanSheets(): int
    {
        return $this->clean_sheets;
    }

    /**
     * @param int $clean_sheets
     */
    public function setCleanSheets(int $clean_sheets): void
    {
        $this->clean_sheets = $clean_sheets;
    }

    /**
     * @return float
     */
    public function getGoalsConceded(): float
    {
        return $this->goalsConceded;
    }

    /**
     * @param float $goalsConceded
     */
    public function setGoalsConceded(float $goalsConceded): void
    {
        $this->goalsConceded = $goalsConceded;
    }

    /**
     * @return int
     */
    public function getPenaltySaves(): int
    {
        return $this->penaltySaves;
    }

    /**
     * @param int $penaltySaves
     */
    public function setPenaltySaves(int $penaltySaves): void
    {
        $this->penaltySaves = $penaltySaves;
    }

    /**
     * @return Player
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Statistics
     */
    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
