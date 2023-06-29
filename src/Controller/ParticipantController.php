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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

        return $this->render('participant/new.html.twig', [
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
                         UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $findUser = $userRepository->findByParticipantId($id);
        $user = $findUser[0];

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupére les valeurs des inputs du formulaire
            $username = $request->request->get("username");
            $email = $request->request->get("email");
            $password = $request->request->get("password");

            try {
                $existingUser = $userRepository->findOneByUsername($username);

                if ($existingUser && $existingUser !== $user) {
                    throw new \Exception("Ce nom d'utilisateur est déjà pris.");
                }

                $user->setUsername($username);
                $user->setEmail($email);

                // Pour hasher le mot de passe lors de l'affectation
                $user->setPassword($userPasswordHasher->hashPassword(
                    $user,
                    $password
                ));

                $participantRepository->save($participant, true);
                $userRepository->save($user, true);

                return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);

            } catch (\Exception $e) {



                $errorMessage = 'Une erreur s\'est produite lors de la mise à jour de l\'utilisateur : ' . $e->getMessage();

                $this->addFlash('error', $errorMessage);
            }
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
}