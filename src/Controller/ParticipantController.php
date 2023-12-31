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
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/participant')]
class ParticipantController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_participant_index', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_participant_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
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
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function show($id,
                         Participant $participant,
                         UserRepository $userRepository,
                         SiteRepository $siteRepository): Response
    {
        $user = $userRepository->findByParticipantId($id);
        $site = $siteRepository->find($participant->getSite());
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
            'user' => $user[0],
            'site' => $site
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participant_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
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

        $currentUser = $this->getUser();

        if($currentUser->getUserIdentifier() != $user->getUserIdentifier()){
            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupére les valeurs des inputs du formulaire
            $username = $request->request->get("username");
            $email = $request->request->get("email");
            $password = $request->request->get("password");

            try {
                if($password === ""){
                    throw new \Exception("Mot de passe requis");
                }
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
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
    public function delete(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $participantRepository->remove($participant, true);
        }

        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}