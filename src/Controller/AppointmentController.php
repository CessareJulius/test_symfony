<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    /**
     * @Route("/appointments", methods="GET", name="appointment")
     */
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        $appointments = $appointmentRepository->findAll();
        return $this->json([
            'data' => $appointments,
        ]);
    }

    /**
     * @Route("/appointments", methods="POST", name="appointments_store")
     */
    public function store(Request $request, EntityManager $em)
    {
        $appointment = new Appointment();
        $appointment->setDate(new \DateTime($request->get('date')));
        $appointment->setReason($request->get('reason'));
        $appointment->setObservation($request->get('observation'));
        $appointment->setStatus($request->get('status'));

        $em->persist($appointment);
        $em->flush();
    }

    /**
     * @Route("/appointments/{id}", methods="PUT|PATCH", name="appointments_update")
     */
    public function update(Request $request, Appointment $appointment, EntityManager $em)
    {
        $appointment->setStatus($request->get('status'));

        $em->persist($appointment);
        $em->flush();
    }
}
