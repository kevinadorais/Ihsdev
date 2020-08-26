<?php

namespace App\Controller;

use App\Entity\Technos;
use App\Entity\DevSkills;
use App\Entity\Projects;
use App\Entity\ProjectImgs;
use App\Form\TechnosType;
use App\Form\DevSkillsType;
use App\Form\ProjectsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/webskills")
*/
class WebSkillsController extends AbstractController
{
    /**
     * @Route("/", name="webskills_index")
     */
    public function index()
    {
        # Ouverture de la base de données, récuperation des données et stockage dans une variable.
        $em = $this->getDoctrine()->getManager(); 
        $technos = $em->getRepository(Technos::class)->findAll();
        $devSkills = $em->getRepository(DevSkills::class)->findAll();
        $projects = $em->getRepository(Projects::class)->findAll();

        return $this->render('webSkills/index.html.twig', [
            'technos' => $technos,
            'devSkills' => $devSkills,
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/techno/new", name="techno_new", methods={"GET","POST"})
     */
    public function technoNew(Request $request): Response
    {
        $technos = new Technos();
        $form = $this->createForm(TechnosType::class, $technos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technos);
            $entityManager->flush();

            return $this->redirectToRoute('webskills_index');
        }

        return $this->render('technos/new.html.twig', [
            'technos' => $technos,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/techno/delete/{id}", name="techno_delete")
     */
    public function technoDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Technos::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('webskills_index');
    }

    /**
     * @Route("/skill/new", name="devskill_new", methods={"GET","POST"})
     */
    public function skillNew(Request $request): Response
    {
        $skills = new DevSkills();
        $form = $this->createForm(DevSkillsType::class, $skills);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skills);
            $entityManager->flush();

            return $this->redirectToRoute('webskills_index');
        }

        return $this->render('devSkills/new.html.twig', [
            'skills' => $skills,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/skill/delete/{id}", name="skill_delete")
     */
    public function skillDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(DevSkills::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('webskills_index');
    }

    /**
     * @Route("/project/new", name="project_new", methods={"GET","POST"})
     */
    public function projectNew(Request $request): Response
    {
        $projects = new Projects();
        $form = $this->createForm(ProjectsType::class, $projects);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recupère les images
            $images = $form->get('images')->getData();

            //Pour chaque images on génère un nom, on copie le fichier dans le dossier concerné et on les enregistre dans la database
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('projectsimgs_directory'),
                    $fichier
                );
                $img = new ProjectImgs;
                $img->setName($fichier);
                $projects->addProjectImg($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projects);
            $entityManager->flush();

            return $this->redirectToRoute('webskills_index');
        }

        return $this->render('projects/new.html.twig', [
            'projects' => $projects,
            'form' => $form->createView(),
        ]);
    }
}
