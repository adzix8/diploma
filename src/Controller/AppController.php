<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Position;
use App\Form\SearchPlayerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SearchPlayerType::class);
        $form->handleRequest($request);
        $filteredPlayers = null;

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $playerPosition = $entityManager->getRepository(Position::class)->find($data['position']);
            $players = $entityManager->getRepository(Player::class)->findAll();

            if ($players !== null)
            {
                $filteredPlayers = array_filter($players, function ($element) use ($playerPosition) {
                    $positions = $element->getPositions();
                    foreach ($positions as $position) {
                        if ($position->getPosition()->getName()  == $playerPosition->getName()) {
                            return true;
                        }
                        return false;
                    }
                    return false;
                });
            }
            $filteredPlayers = array_values($filteredPlayers);
            $criteria = [];
            $weights = [];
            $types = [];
            switch ($data['position'])
            {
                case 1:
                    $criteria = ['age', 'height', 'saves', 'penaltySaves', 'goalsConceded', 'cleanSheets', 'errors'];
                    $weights = [$data['age'], $data['height'], $data['saves'], $data['penaltySaves'],
                        $data['goalsConceded'], $data['cleanSheets'], $data['errors']];
                    $types = [-1, 1, 1, 1, -1, 1, -1];
                    break;
                case 2:
                    $criteria = ['age', 'height', 'speed', 'goals', 'dualsWon', 'clearances', 'errors', 'passes'];
                    $weights = [$data['age'], $data['height'], $data['speed'], $data['goals'],
                        $data['dualsWon'], $data['clearances'], $data['errors'], $data['passes']];
                    $types = [-1, 1, 1, 1, 1, 1, -1, 1];
                    break;
                case 3:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'clearances', 'errors', 'passes', 'crosses'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'],
                        $data['dualsWon'], $data['clearances'], $data['errors'], $data['passes'], $data['crosses']];
                    $types = [-1, 1, 1, 1, 1, 1, -1, 1, 1];
                    break;
                case 4:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'clearances', 'passes', 'crosses', 'touches', 'chances'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'], $data['dualsWon'],
                        $data['clearances'], $data['passes'], $data['crosses'], $data['touches'], $data['chances']];
                    $types = [-1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                    break;
                case 5:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'dribbles', 'passes', 'crosses', 'touches', 'chances'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'], $data['dualsWon'],
                        $data['dribbles'], $data['passes'], $data['crosses'], $data['touches'], $data['chances']];
                    $types = [-1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                    break;
                case 6:
                    $criteria = ['age', 'height', 'speed', 'goals', 'assists', 'dualsWon', 'passes', 'shoots', 'touches', 'chances'];
                    $weights = [$data['age'], $data['height'], $data['speed'], $data['goals'], $data['assists'],
                        $data['dualsWon'], $data['passes'], $data['shoots'], $data['touches'], $data['chances']];
                    $types = [-1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                    break;
            }
            $sumWeights = array_sum($weights);
            foreach ($weights as $key => $weight)
            {
                $weights[$key] = $weight/$sumWeights;
            }
            $scores = $this->TOPSIS($filteredPlayers, $criteria, $weights, $types);

            foreach ($filteredPlayers as $index => $player)
            {
                $player->setScore($scores[$index]);
            }

            usort($filteredPlayers, function($a, $b)
            {
                return $b->getScore() > $a->getScore();
            });
        }

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'form' => $form->createView(),
            'players' => $filteredPlayers,
        ]);
    }

    /**
     * @param Player $player
     * @return Response
     */
    public function showPlayer(Player $player): Response
    {
        return $this->render('app/show.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * TOPSIS method to calculate the ranking of the best variants.
     * @param $players
     * @param $criteria
     * @param $weights
     * @param $types
     * @return array
     */
    private function TOPSIS($players, $criteria, $weights, $types): array
    {
        $matrix = [[]];

        foreach ($criteria as $x => $criterion)
        {
            foreach ($players as $y => $player)
            {
                $stats = $player->getStatistics();
                $length = count($stats);
                $value = 0;
                foreach ($stats as $stat)
                {
                    switch ($criterion)
                    {
                        case 'age':
                            $value += $player->getAge();
                            break;
                        case 'height':
                            $value += $player->getHeight();
                            break;
                        case 'speed':
                            $value += $player->getTopSpeed();
                            break;
                        case 'goals':
                            $value += $stat->getGoals();
                            break;
                        case 'assists':
                            $value += $stat->getAssists();
                            break;
                        case 'passes':
                            $value += $stat->getPassesCompleted();
                            break;
                        case 'dribbles':
                            $value += $stat->getDribbles();
                            break;
                        case 'crosses':
                            $value += $stat->getCrosses();
                            break;
                        case 'shoots':
                            $value += $stat->getShootAccuracy();
                            break;
                        case 'chances':
                            $value += $stat->getChances();
                            break;
                        case 'touches':
                            $value += $stat->getTouches();
                            break;
                        case 'clearances':
                            $value += $stat->getClearances();
                            break;
                        case 'dualsWon':
                            $value += $stat->getDualsWon();
                            break;
                        case 'errors':
                            $value += $stat->getErrors();
                            break;
                        case 'saves':
                            $value += $stat->getSaves();
                            break;
                        case 'goalsConceded':
                            $value += $stat->getGoalsConceded();
                            break;
                        case 'cleanSheets':
                            $value += $stat->getCleanSheets();
                            break;
                        case 'penaltySaves':
                            $value += $stat->getPenaltySaves();
                            break;
                    }
                }
                $matrix[$x][$y] = $value/$length;
            }
        }

        foreach ($matrix as $x => $row)
        {
            foreach ($row as $y => $col)
            {
                if ($types[$x] === 1)
                {
                    $matrix[$x][$y] = ($matrix[$x][$y] - min($row)) / (max($row) - min($row)); // profit criteria if types 1
                }
                else
                {
                    $matrix[$x][$y] = (max($row) - $matrix[$x][$y]) / (max($row) - min($row)); // cost criteria if types -1
                }
            }
        }

        foreach ($matrix as $x => $row)
        {
            foreach ($row as $y => $col)
            {
                $matrix[$x][$y] *= $weights[$x];
            }
        }

        $PIS = [];
        $NIS = [];

        foreach ($matrix as $x => $row)
        {
            $PIS[$x] = max($row);
            $NIS[$x] = min($row);
        }

        $distanceFromPIS = array_fill(0, count($players), 0);
        $distanceFromNIS = array_fill(0, count($players), 0);


        foreach ($matrix as $x => $row)
        {
            foreach ($row as $y => $col)
            {
                $distanceFromPIS[$y] +=  pow(($matrix[$x][$y] - $PIS[$x]), 2);
                $distanceFromNIS[$y] +=  pow(($matrix[$x][$y] - $NIS[$x]), 2);
            }
        }

        foreach ($distanceFromPIS as $index => $value)
        {
            $distanceFromPIS[$index] = sqrt($value);
        }

        foreach ($distanceFromNIS as $index => $value)
        {
            $distanceFromNIS[$index] = sqrt($value);
        }

        $scores = [];

        foreach ($distanceFromPIS as $index => $value)
        {
            $scores[$index] = $distanceFromNIS[$index] / ($distanceFromNIS[$index] + $distanceFromPIS[$index]);
        }

        return $scores;
    }
}
