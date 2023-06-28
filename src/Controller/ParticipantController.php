<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Activity;
use App\Entity\Site;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/participant')]
class ParticipantController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_participant_index', methods: ['GET'])]
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParticipantRepository $participantRepository): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->save($participant, true);

            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participant_show', methods: ['GET'])]
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participant_edit', methods: ['GET', 'POST'])]
    public function edit(
                         $id,
                         Request $request,
                         Participant $participant,
                         ParticipantRepository $participantRepository,
                         UserRepository $userRepository,
                         SiteRepository $siteRepository): Response
    {

        $findUser = $userRepository->findByParticipantId($id);
        $user = $findUser[0];
//        $site = $participant->getSite();
dump($user);


        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->save($participant, true);

            $username = $request->request->get("username");
            $email = $request->request->get("email");
            $password = $request->request->get("password");
            dump($username);
            dump($email);
            dump($password);

            $user->setUsername($username);
            $user->setEmail($email);
//            dd($user);
            $userRepository->save($user,true);
//            dd("kill");
            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participant_delete', methods: ['POST'])]
    public function delete(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $participantRepository->remove($participant, true);
        }

        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }

    //view all participant
//    #[Route('/viewAllParticipant', methods: ['GET', 'POST'])]
//    public function viewAll(ParticipantRepository $participantRepository){
//        $participant= $participantRepository->findAll();
//        return $this->render('participant/participantAll.html.twig',
//        ['participant'=>$participant]);

//    }

}
