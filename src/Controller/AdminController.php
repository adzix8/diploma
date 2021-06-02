<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerPositions;
use App\Entity\Position;
use App\Entity\Statistics;
use App\Form\CSVFileType;
use App\Form\PlayerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    public function addPlayers(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CSVFileType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('file')->getData();
            if (($handle = fopen($file->getPathname(), "r")) !== false)
            {
                $counter = 0;
                while (($data = fgetcsv($handle)) !== false)
                {
                    if ($counter > 0)
                    {
                        $player = new Player();
                        $statistics = new Statistics();
                        $player->setName($data[0]);
                        $player->setAge(intval($data[2]));
                        $player->setHeight(rand(160, 195));
                        $player->setTopSpeed(floatval($this->float_rand(32, 36)));
                        $statistics->setPlayer($player);
                        $statistics->setGoals(intval($data[3]));
                        $statistics->setAssists(intval($data[4]));
                        $statistics->setDualsWon(intval($data[5]));
                        $statistics->setClearances(floatval($data[6]));
                        $statistics->setErrors(intval($data[7]));
                        $statistics->setTouches(floatval($data[8]));
                        $statistics->setPassesCompleted(floatval($data[9]));
                        $statistics->setChances(intval($data[10]));
                        $statistics->setDribbles(floatval($data[11]));
                        $statistics->setCrosses(floatval($data[12]));
                        $statistics->setCleanSheets(intval($data[13]));
                        $statistics->setSaves(floatval($data[14]));
                        $statistics->setGoalsConceded(floatval($data[15]));
                        $statistics->setPenaltySaves(intval($data[16]));
                        $statistics->setShootAccuracy(intval($data[17]));

                        $em->persist($player);
                        $em->persist($statistics);

                        $positions = $this->getDoctrine()->getRepository(Position::class)->findAll();
                        $playerPositions = explode(' ', $data[1]);
                        foreach ($playerPositions as $playerPosition)
                        {
                            if(in_array($playerPosition, ['GK']))
                            {
                                $this->setPositionPlayer($player, $positions[0]);
                            }
                            elseif(in_array($playerPosition, ['D', 'D(C)', 'D(CL)', 'D(CR)']))
                            {
                                $this->setPositionPlayer($player, $positions[1]);
                            }
                            elseif(in_array($playerPosition, ['D(L)', 'D(R)', 'D(LC)', 'D(RC)', 'D(LR)']))
                            {
                                $this->setPositionPlayer($player, $positions[2]);
                            }
                            elseif(in_array($playerPosition, ['M', 'M(C)', 'M(L)', 'M(R)', 'DM(C)', 'DM(R)', 'DM(L)', 'AM(C)']))
                            {
                                $this->setPositionPlayer($player, $positions[3]);
                            }
                            elseif(in_array($playerPosition, ['W', 'W(L)', 'W(R)', 'AM', 'AM(L)', 'AM(LR)', 'AM(LC)', 'AM(RC)']))
                            {
                                $this->setPositionPlayer($player, $positions[4]);
                            }
                            elseif(in_array($playerPosition, ['F', 'F(C)', 'S', 'S(C)', 'ST(C)']))
                            {
                                $this->setPositionPlayer($player, $positions[5]);
                            }
                        }
                    }
                    $counter += 1;
                }
                fclose($handle);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Pomyślnie dodano piłkarzy do bazy danych.'
                );
            }
        }

        return $this->render('admin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function editList(): Response
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();

        return $this->render('admin/editList.html.twig', [
            'players' => $players,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Player $player
     * @return Response
     */
    public function editPlayer(Request $request,EntityManagerInterface $em, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class);
        $statistics = $player->getStatistics()[0];
//        $positions = $player->getPositions();
//        $pos = [];
//        foreach ($positions as $position)
//        {
//            $pos = $position->getPosition()->getName();
//        }

        $form->get('name')->setData($player->getName());
        $form->get('age')->setData($player->getAge());
        $form->get('height')->setData($player->getHeight());
        $form->get('topSpeed')->setData(number_format($player->getTopSpeed(), 2));
//        $form->get('positions')->setData($pos);
        $form->get('goals')->setData($statistics->getGoals());
        $form->get('assists')->setData($statistics->getAssists());
        $form->get('dualsWon')->setData($statistics->getDualsWon());
        $form->get('clearances')->setData($statistics->getClearances());
        $form->get('errors')->setData($statistics->getErrors());
        $form->get('touches')->setData($statistics->getTouches());
        $form->get('passesCompleted')->setData($statistics->getPassesCompleted());
        $form->get('chances')->setData($statistics->getChances());
        $form->get('dribbles')->setData($statistics->getDribbles());
        $form->get('crosses')->setData($statistics->getCrosses());
        $form->get('cleanSheets')->setData($statistics->getCleanSheets());
        $form->get('saves')->setData($statistics->getSaves());
        $form->get('goalsConceded')->setData($statistics->getGoalsConceded());
        $form->get('penaltySaves')->setData($statistics->getPenaltySaves());
        $form->get('shootAccuracy')->setData($statistics->getShootAccuracy());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $player->setName($form->get('name')->getData());
            $player->setAge($form->get('age')->getData());
            $player->setHeight($form->get('height')->getData());
            $player->setTopSpeed(floatval($form->get('topSpeed')->getData()));
//            $positions = $player->getPositions();
//            foreach ($positions as $position)
//            {
//                $position->setPlayer($player);
//                $position->setPosition($position);
//            }
            $statistics->setPlayer($player);
            $statistics->setGoals(intval($form->get('goals')->getData()));
            $statistics->setAssists(intval($form->get('assists')->getData()));
            $statistics->setDualsWon(intval($form->get('dualsWon')->getData()));
            $statistics->setClearances(floatval($form->get('clearances')->getData()));
            $statistics->setErrors(intval($form->get('errors')->getData()));
            $statistics->setTouches(floatval($form->get('touches')->getData()));
            $statistics->setPassesCompleted(floatval($form->get('passesCompleted')->getData()));
            $statistics->setChances(intval($form->get('chances')->getData()));
            $statistics->setDribbles(floatval($form->get('dribbles')->getData()));
            $statistics->setCrosses(floatval($form->get('crosses')->getData()));
            $statistics->setCleanSheets(intval($form->get('cleanSheets')->getData()));
            $statistics->setSaves(floatval($form->get('saves')->getData()));
            $statistics->setGoalsConceded(floatval($form->get('goalsConceded')->getData()));
            $statistics->setPenaltySaves(intval($form->get('penaltySaves')->getData()));
            $statistics->setShootAccuracy(intval($form->get('shootAccuracy')->getData()));

            $em->persist($player);
            $em->persist($statistics);
            $em->flush();

            $this->addFlash(
                'success',
                'Pomyślnie zaktualizowano zawodnika.'
            );
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'player' => $player,
        ]);
    }

    /**
     * @return Response
     */
    public function deleteList(): Response
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();

        return $this->render('admin/deleteList.html.twig', [
            'players' => $players,
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Player $player
     * @return Response
     */
    public function deletePlayer(EntityManagerInterface $em, Player $player): Response
    {
        $em->remove($player);
        $em->flush();

        $this->addFlash(
            'success',
            'Pomyślnie usunięto piłkarza.'
        );

        return $this->redirectToRoute('delete_list');
    }

    private function setPositionPlayer(Player $player, Position $position): void
    {
        $positions = new PlayerPositions();
        $positions->setPlayer($player);
        $positions->setPosition($position);
        $em = $this->getDoctrine()->getManager();
        $em->persist($positions);
    }

    /**
     * Generate Float Random Number
     *
     * @param float $Min Minimal value
     * @param float $Max Maximal value
     * @param int $round The optional number of decimal digits to round to. default 0 means not round
     * @return float Random float value
     */
    private function float_rand($Min, $Max, $round=0){
        //validate input
        if ($Min>$Max) { $min=$Max; $max=$Min; }
        else { $min=$Min; $max=$Max; }
        $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        if($round>0)
            $randomfloat = round($randomfloat,$round);

        return $randomfloat;
    }
}
