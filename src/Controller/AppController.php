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
            switch ($data['position'])
            {
                case 1:
                    $criteria = ['age', 'height', 'saves', 'penaltySaves', 'goalsConceded', 'cleanSheets', 'errors'];
                    $weights = [$data['age'], $data['height'], $data['saves'], $data['penaltySaves'],
                        $data['goalsConceded'], $data['cleanSheets'], $data['errors']];
                    break;
                case 2:
                    $criteria = ['age', 'height', 'speed', 'goals', 'dualsWon', 'clearances', 'errors', 'passes'];
                    $weights = [$data['age'], $data['height'], $data['speed'], $data['goals'],
                        $data['dualsWon'], $data['clearances'], $data['errors'], $data['passes']];
                    break;
                case 3:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'clearances', 'errors', 'passes', 'crosses'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'],
                        $data['dualsWon'], $data['clearances'], $data['errors'], $data['passes'], $data['crosses']];
                    break;
                case 4:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'clearances', 'passes', 'crosses', 'touches', 'chances'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'], $data['dualsWon'],
                        $data['clearances'], $data['passes'], $data['crosses'], $data['touches'], $data['chances']];
                    break;
                case 5:
                    $criteria = ['age', 'speed', 'goals', 'assists', 'dualsWon', 'dribbles', 'passes', 'crosses', 'touches', 'chances'];
                    $weights = [$data['age'], $data['speed'], $data['goals'], $data['assists'], $data['dualsWon'],
                        $data['dribbles'], $data['passes'], $data['crosses'], $data['touches'], $data['chances']];
                    break;
                case 6:
                    $criteria = ['age', 'height', 'speed', 'goals', 'assists', 'dualsWon', 'passes', 'shoots', 'touches', 'chances'];
                    $weights = [$data['age'], $data['height'], $data['speed'], $data['goals'], $data['assists'],
                        $data['dualsWon'], $data['passes'], $data['shoots'], $data['touches'], $data['chances']];
                    break;
            }
            $sumWeights = array_sum($weights);
            foreach ($weights as $key => $weight)
            {
                $weights[$key] = $weight/$sumWeights;
            }
            $scores = $this->TOPSIS($filteredPlayers, $criteria, $weights);

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
    private function TOPSIS($players, $criteria, $weights): array
    {
        $matrix = [[[]]];

        foreach ($criteria as $x => $criterion)
        {
            foreach ($players as $y => $player)
            {
                $stats = $player->getStatistics();

                switch ($criterion)
                {
                    case 'age':
                        $value = $player->getAge();
                        $matrix[$x][$y] = $this->TFN($value, [[33,41], [29,32], [25,28], [21,24], [15,20]]);
                        break;
                    case 'height':
                        $value = $player->getHeight();
                        $matrix[$x][$y] = $this->TFN($value, [[150,165], [166,174], [175,180], [181,187], [188,210]]);
                        break;
                    case 'speed':
                        $value = $player->getTopSpeed();
                        $matrix[$x][$y] = $this->TFN($value, [[29.00,30.00], [30.01,32.00], [32.01,33.50], [33.51,35.00], [35.01,38.00]]);
                        break;
                    case 'goals':
                        $value = $stats[0]->getGoals();
                        $matrix[$x][$y] = $this->TFN($value, [[0,3], [4,6], [7,12], [13,20], [21,50]]);
                        break;
                    case 'assists':
                        $value = $stats[0]->getAssists();
                        $matrix[$x][$y] = $this->TFN($value, [[0,3], [4,6], [7,12], [13,18], [19,50]]);
                        break;
                    case 'passes':
                        $value = $stats[0]->getPassesCompleted();
                        $matrix[$x][$y] = $this->TFN($value, [[0,60], [61,70], [71,79], [80,89], [90,100]]);
                        break;
                    case 'dribbles':
                        $value = $stats[0]->getDribbles();
                        $matrix[$x][$y] = $this->TFN($value, [[0.00,0.49], [0.50,1.20], [1.21,1.99], [2.00,2.99], [3.01,5.00]]);
                        break;
                    case 'crosses':
                        $value = $stats[0]->getCrosses();
                        $matrix[$x][$y] = $this->TFN($value, [[0.00,0.49], [0.50,1.90], [1.91,3.49], [3.50,4.99], [5.00,12.00]]);
                        break;
                    case 'shoots':
                        $value = $stats[0]->getShootAccuracy();
                        $matrix[$x][$y] = $this->TFN($value, [[0,15], [16,29], [30,45], [46,57], [58,100]]);
                        break;
                    case 'chances':
                        $value = $stats[0]->getChances();
                        $matrix[$x][$y] = $this->TFN($value, [[0,2], [3,5], [6,12], [13,18], [19,40]]);
                        break;
                    case 'touches':
                        $value = $stats[0]->getTouches();
                        $matrix[$x][$y] = $this->TFN($value, [[0,29], [30,44], [45,70], [71,80], [81,140]]);
                        break;
                    case 'clearances':
                        $value = $stats[0]->getClearances();
                        $matrix[$x][$y] = $this->TFN($value, [[0.00,0.49], [0.50,0.99], [1.00,2.20], [2.21,3.00], [3.01,9.00]]);
                        break;
                    case 'dualsWon':
                        $value = $stats[0]->getDualsWon();
                        $matrix[$x][$y] = $this->TFN($value, [[0,40], [41,45], [46,57], [58,64], [65,100]]);
                        break;
                    case 'errors':
                        $value = $stats[0]->getErrors();
                        $matrix[$x][$y] = $this->TFN($value, [[4,8], [3,3], [2,2], [1,1], [0,0]]);
                        break;
                    case 'saves':
                        $value = $stats[0]->getSaves();
                        $matrix[$x][$y] = $this->TFN($value, [[0.00,2.00], [2.01,2.49], [2.50,3.00], [3.01,3.60], [3.61,5.00]]);
                        break;
                    case 'goalsConceded':
                        $value = $stats[0]->getGoalsConceded();
                        $matrix[$x][$y] = $this->TFN($value, [[2.20,3.50], [2.00,2.19], [1.61,1.99], [1.21,1.60], [0.00,1.20]]);
                        break;
                    case 'cleanSheets':
                        $value = $stats[0]->getCleanSheets();
                        $matrix[$x][$y] = $this->TFN($value, [[0,2], [3,5], [6,10], [11,13], [14,20]]);
                        break;
                    case 'penaltySaves':
                        $value = $stats[0]->getPenaltySaves();
                        $matrix[$x][$y] = $this->TFN($value, [[0,0], [1,1], [2,3], [4,5], [6,10]]);
                        break;
                }
            }
        }

        foreach ($matrix as $x => $row)
            foreach ($row as $y => $col)
                foreach ($col as $z => $value)
                    $matrix[$x][$y][$z] *= $weights[$x];

        $PIS = [[]];
        $NIS = [[]];
        $a1 = [];
        $a2 = [];
        $a3 = [];

        foreach ($matrix as $x => $row)
        {
            foreach ($row as $y => $col)
            {
                $a1[$x][$y] = $col[0];
                $a2[$x][$y] = $col[1];
                $a3[$x][$y] = $col[2];
            }
        }

        foreach ($a1 as $x => $row) {
            $PIS[$x][0] = max($row);
            $NIS[$x][0] = min($row);
        }

        foreach ($a2 as $x => $row) {
            $PIS[$x][1] = max($row);
            $NIS[$x][1] = min($row);
        }

        foreach ($a3 as $x => $row) {
            $PIS[$x][2] = max($row);
            $NIS[$x][2] = min($row);
        }

        $distanceFromPIS = array_fill(0, count($players), 0);
        $distanceFromNIS = array_fill(0, count($players), 0);


        foreach ($matrix as $x => $row)
        {
            foreach ($row as $y => $col)
            {
                $distanceFromPIS[$y] +=  pow(($matrix[$x][$y][0] - $PIS[$x][0]), 2)
                    + pow(($matrix[$x][$y][1] - $PIS[$x][1]), 2) + pow(($matrix[$x][$y][2] - $PIS[$x][2]), 2);
                $distanceFromNIS[$y] +=  pow(($matrix[$x][$y][0] - $NIS[$x][0]), 2)
                    + pow(($matrix[$x][$y][1] - $NIS[$x][1]), 2) + pow(($matrix[$x][$y][2] - $NIS[$x][2]), 2);
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

    private function TFN($value, $rangeOfValues): array
    {
        $TFN = [];

        if ($value >= $rangeOfValues[0][0] && $value <= $rangeOfValues[0][1]) {
            $TFN = [0, 0.1, 0.3];
        } elseif ($value >= $rangeOfValues[1][0] && $value <= $rangeOfValues[1][1]) {
            $TFN = [0.2, 0.3, 0.5];
        } elseif ($value >= $rangeOfValues[2][0] && $value <= $rangeOfValues[2][1]) {
            $TFN = [0.4, 0.5, 0.6];
        } elseif ($value >= $rangeOfValues[3][0] && $value <= $rangeOfValues[3][1]) {
            $TFN = [0.5, 0.7, 0.8];
        } elseif ($value >= $rangeOfValues[4][0] && $value <= $rangeOfValues[4][1]) {
            $TFN = [0.7, 0.9, 1];
        }

        return $TFN;
    }
}
