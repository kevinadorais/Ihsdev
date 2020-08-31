<?php

namespace App\Controller;

use App\Entity\Technos;
use App\Entity\DevSkills;
use App\Entity\Projects;
use App\Entity\ProjectImgs;
use App\Form\TechnosType;
use App\Form\DevSkillsType;
use App\Form\ProjectsType;
use App\Repository\ProjectImgsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        // Ouverture de la base de données, récuperation des données et stockage dans une variable.
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////TECHNOS///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/techno/new", name="techno_new", methods={"GET","POST"})
     */
    public function technoNew(Request $request): Response
    {
        $technos = new Technos();
        $form = $this->createForm(TechnosType::class, $technos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On recupère le logo
            $logo = $form->get('logo')->getData();

            // On génère un nom, on copie le fichier dans le dossier concerné et on l'enregistre dans la database
            $file = $technos->getAlt() . '.' . $logo[0]->guessExtension();
            $logo[0]->move(
                $this->getParameter('technoslogos_directory'),
                $file
            );
            $technos->setLogo($file);

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
        // Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Technos::class)->find($id);

        // On récupere le nom de l'image
        $imgName = $task->getLogo();

        // On suprime le fichier img du dossier
        unlink($this->getParameter('technoslogos_directory') . '/' . $imgName);

        // Supression des données ans la database.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('webskills_index');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////SKILLS////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

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
        // Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(DevSkills::class)->find($id);

        // Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('webskills_index');
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////PROJECTS///////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

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
            $images = $form->get('projectImgs')->getData();

            //Pour chaque images on génère un nom, on copie le fichier dans le dossier concerné et on les enregistre dans la database
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('projectsimgs_directory'),
                    $fichier
                );
                $img = new ProjectImgs();
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

    /**
     * @Route("/project/edit/{id}", name="project_edit", methods={"GET","POST"})
     */
    public function projectEdit(Request $request, Projects $projects): Response
    {
        $form = $this->createForm(ProjectsType::class, $projects);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recupère les images
            $images = $form->get('projectImgs')->getData();

            //Pour chaque images on génère un nom, on copie le fichier dans le dossier concerné et on les enregistre dans la database
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('projectsimgs_directory'),
                    $fichier
                );
                $img = new ProjectImgs();
                $img->setName($fichier);
                $projects->addProjectImg($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_index');
        }

        return $this->render('projects/edit.html.twig', [
            'projects' => $projects,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("Project/img/delete/{id}", name="projectimg_delete")
     */
    public function projectImgDelete(ProjectImgs $projectImgs, Request $request){
        $data = json_decode($request->getContent(), true);

        // On verifie le Token
        if($this->isCsrfTokenValid('delete'. $projectImgs->getId(), $data['_token'])){

            // On recupère le nom de l'image
            $imgName = $projectImgs->getName();

            // On efface le fichier img
            unlink($this->getParameter('projectsImgs_directory'). '/' . $imgName);

            // Ouverture de la database
            $em = $this->getDoctrine()->getManager();

            // Supression des données.
            $em->remove($projectImgs);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
        else{
            return new JsonResponse(['error' => 'Invalid Token'], 400);
        }
    }

    /**
     * @Route("/project/delete/{id}", name="project_delete")
     */
    public function projectDelete($id)
    {          
        // Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Projects::class)->find($id);
        $task2 = $em->getRepository(ProjectImgs::class)->findByProject($id);

        foreach($task2 as $img){
            // On recupère le nom de l'image
            $imgName = $img->getName();
            // On efface les fichiers image correspondant aux projets
            unlink($this->getParameter('projectsimgs_directory'). '/' . $imgName);
        }

        // Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('webskills_index');
    }
}
