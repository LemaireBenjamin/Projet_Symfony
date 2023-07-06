<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Site;
use App\Form\ActivityFilterType;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CityRepository;
use App\Repository\ParticipantRepository;
use App\Repository\PlaceRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;



#[Route('/activity')]
class ActivityController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_activity_index', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function index(Request $request,ActivityRepository $activityRepository, Security $security): Response
    {
        $activities = $activityRepository->findAll();
        $participantId = $security->getUser()->getParticipant()->getId();
        $oneMonthAgo = new \DateTime('-1 month');

        $sites = $this->entityManager->getRepository(Site::class)->findAll();
        $form = $this->createForm(ActivityFilterType::class, null, [
            'sites' => $sites,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Effectuer la recherche des activités en fonction des critères
            $activities = $activityRepository->findByFilters(
                $data['site'],
                $data['name'],
                $data['startDate'],
                $data['endDate'],
                $data['isOrganizer'],
                $data['isParticipant'],
                $data['isNotParticipant'],
                $data['isPast'],
                $participantId
            );

            $filteredActivities = [];
            foreach ($activities as $activity) {
                $activityRepository->updateStatusToEnCoursIfToday($activity);
                if($activity->getStartDate() >= $oneMonthAgo) {
                    $filteredActivities[] = $activity;
                }
            }
            $activities = $filteredActivities;

        }
        return $this->render('activity/index.html.twig', [
            'activities' => $activities,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_activity_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function new(
        Request $request,
        CityRepository $cityRepository,
        PlaceRepository $placeRepository,
        ParticipantRepository $participantRepository,
        StatusRepository $statusRepository,
        ActivityRepository $activityRepository,
        SessionInterface $session): Response
    {
        $activity = new Activity();

        $participant = $participantRepository->findParticipantByUserId($this->getUser()->getId());
        $cities = $cityRepository->findAll();
        $site = $participant[0]->getSite();

        $activity->setSite($site);
        $flashMessages = [];
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $status = $statusRepository->find(1);
            $activityData = $request->get('activity');
            $placeId = $activityData['placeId'];
            $place = $placeRepository->find($placeId);

            $activity->setPlace($place);
            $activity->setOrganizer($participant[0]);
            $activity->setStatus($status);

            $activityRepository->save($activity, true);

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/get-place-street/{placeId}', name: 'get_place_street', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function getPlaceStreet(PlaceRepository $placeRepository, $placeId): Response
    {
        $place = $placeRepository->find($placeId);
        $placeStreet = $place ? $place->getPlaceStreet() : '';

        return new Response($placeStreet);
    }

    #[Route('/get-zipcode/{cityId}', name: 'get_zipcode', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function getZipCode(Request $request, CityRepository $cityRepository, $cityId): Response
    {
        $city = $cityRepository->find($cityId);
        $zipCode = $city ? $city->getZipCode() : '';

        return new Response($zipCode);
    }


   #[Route('/{id}', name: 'app_activity_show', methods: ['GET','POST'])]
   #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
   public function show(
       Request $request,
       ActivityRepository $activityRepository,
       ParticipantRepository $participantRepository,
       $id): Response
    {

        $activity = $activityRepository->find($id);
        $user = $this->getUser();

        if ($activity->getParticipants()->contains($user)) {
            throw new \Exception('L\'utilisateur est déjà inscrit à cette activité.');
        }

        if ($activity->getParticipants()->count() >= $activity->getMaxInscriptions()) {
            throw new \Exception('Le nombre maximum d\'inscriptions à cette activité a été atteint.');
        }

        if ($request->isMethod('POST')) {

            $participant = $participantRepository->findParticipantByUserId($user->getId());

            $activity->addParticipant($participant[0]);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_activity_show', ['id' => $activity->getId()]);
        }

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activity_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
    public function edit(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
    {

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $activityRepository->save($activity, true);

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_activity_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
    public function delete(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $activityRepository->remove($activity, true);
        }
        return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/unsubscribe/{id}',name:'app_activity_unsubscribe',methods:['POST','GET'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function toUnsubscribe(Request $request,
                                  ActivityRepository $activityRepository,
                                  ParticipantRepository $participantRepository,
                                  $id
    ): Response
    {
        $activity = $activityRepository->find($id);
        $user = $this->getUser();


        if ($request->isMethod('POST')) {

            $participant = $participantRepository->findParticipantByUserId($user->getId());

            $activity->removeParticipant($participant[0]);

            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/cancel', name: 'app_activity_cancel', methods: ['GET','POST'])]
    #[IsGranted("ROLE_USER", message: "Page non trouvée", statusCode: 404)]
    public function cancel( Request $request,
                            ActivityRepository $activityRepository,
                            StatusRepository $statusRepository,
                            $id
    ): Response
    {
        $activity = $activityRepository->find($id);

        $user = $activity->getOrganizer()->getUser();

        $currentUser = $this->getUser();

        if($currentUser->getUserIdentifier() != $user->getUserIdentifier()){
            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($request->isMethod('POST')) {

            $motif = $request->request->get("motif");
            $status = $statusRepository->find(6);

            $activity->setDescription($motif);
            $activity->setStatus($status);

            $activityRepository->save($activity, true);

            return $this->redirectToRoute('app_activity_show', ['id' => $activity->getId()]);
        }
        return $this->render('activity/cancel_activity.html.twig', [
            'activity' => $activity,
        ]);
    }

}