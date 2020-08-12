<?php

namespace App\Controller;

use App\Entity\Qualification;
use App\Entity\Job;
use App\Repository\QualificationRepository;
use App\Repository\JobRepository;
use App\Form\QualificationType;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/projourney")
*/
class ProJourneyController extends AbstractController
{
    /**
     * @Route("/", name="projourney_index")
     */
    public function index()
    {
        # Ouverture de la base de données, récuperation des données et stockage dans une variable.
        $em = $this->getDoctrine()->getManager(); 
        $qualifications = $em->getRepository(Qualification::class)->sortByPosition();
        $jobs = $em->getRepository(Job::class)->sortByPosition();

        return $this->render('projourney/index.html.twig', [
            'qualifications' => $qualifications ,
            'jobs' => $jobs ,
        ]);
    }

    /**
     * @Route("/qualif/new", name="qualif_new", methods={"GET","POST"})
     */
    public function qualifNew(Request $request): Response
    {

        $qualification = new Qualification();
        $form = $this->createForm(QualificationType::class, $qualification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($qualification);
            $entityManager->flush();

            return $this->redirectToRoute('projourney_index');
        }

        return $this->render('qualification/new.html.twig', [
            'qualification' => $qualification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/qualif/edit/{id}", name="qualif_edit", methods={"GET","POST"})
     */
    public function qualifEdit(Request $request, Qualification $qualification)
    {
        $form = $this->createForm(QualificationType::class, $qualification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projourney_index');
        }

        return $this->render('qualification/edit.html.twig', [
            'qualification' => $qualification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/qualif/{id}", name="qualif_delete")
     */
    public function qualifDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Qualification::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('projourney_index');
    }

    /**
     * @Route("/job/new", name="job_new", methods={"GET","POST"})
     */
    public function jobNew(Request $request): Response
    {

        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('projourney_index');
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/job/edit/{id}", name="job_edit", methods={"GET","POST"})
     */
    public function jobEdit(Request $request, Job $job)
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projourney_index');
        }

        return $this->render('job/edit.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/job/{id}", name="job_delete")
     */
    public function jobDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Job::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('projourney_index');
    }
}
