<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/patients", methods="GET", name="patients_index")
     */
    public function index(PatientRepository $patientRepository): Response
    {
        $patients = $patientRepository->findAll();
        return $this->json([
            'data' => $patients,
        ]);
    }

    /**
     * @Route("/patients", methods="POST", name="patients_store")
     */
    public function store(Request $request, EntityManager $em)
    {
        $patient = new Patient();
        $patient->setName($request->get('name'));
        $patient->setLastname($request->get('lastname'));
        $patient->setAge($request->get('age'));
        $patient->setGender($request->get('gender'));
        $patient->setBirthdate(new  \DateTime($request->get('birthdate')));

        $em->persist($patient);
        $em->flush();
    }
}
