<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Place;
use App\Entity\Site;
use App\Entity\Status;
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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/activity')]
class ActivityController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_activity_index', methods: ['GET', 'POST'])]
    public function index(Request $request,ActivityRepository $activityRepository, Security $security): Response
    {
        $activities = $activityRepository->findAll();
//        dd($activities);
        $currentUser = $security->getUser();

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
                $currentUser
            );
        }
        return $this->render('activity/index.html.twig', [
            'activities' => $activities,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_activity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CityRepository $cityRepository, PlaceRepository $placeRepository, ParticipantRepository $participantRepository, StatusRepository $statusRepository, ActivityRepository $activityRepository): Response
    {
        $activity = new Activity();

        $participant = $participantRepository->find($this->getUser()->getId());
        $cities = $cityRepository->findAll();
        $site = $participant->getSite();
        $places = $placeRepository->findAll();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);
//        dd($cities);
        if ($form->isSubmitted() && $form->isValid()) {

            $status = $statusRepository->find(1);
            $activity->setOrganizer($participant);
            $activity->setSite($site);
            $activity->setStatus($status);

            $activityRepository->save($activity, true);

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activity/new.html.twig', [
            'activity' => $activity,
//            'cities' => $cities,
//            'places' => $places,
            'form' => $form,
        ]);
    }

    #[Route('/get-place-street/{placeId}', name: 'get_place_street', methods: ['GET', 'POST'])]
    public function getPlaceStreet(PlaceRepository $placeRepository, $placeId): Response
    {
        $place = $placeRepository->find($placeId);
        $placeStreet = $place ? $place->getPlaceStreet() : '';

        return new Response($placeStreet);
    }




    #[Route('/{id}', name: 'app_activity_show', methods: ['GET'])]
    public function show(Activity $activity, Status $status): Response
    {
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activity_edit', methods: ['GET', 'POST'])]
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
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_delete', methods: ['POST'])]
    public function delete(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $activityRepository->remove($activity, true);
        }
        return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
    }
}
