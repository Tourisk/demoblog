<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExoController extends AbstractController
{
//---------------------------------------------------------------------------------------------------------------------------------------
    #[Route('/exo', name: 'app_exo')]
    public function index(VoitureRepository $repo): Response
    {
        $voitures=$repo->findAll(); //findAll() pour récupérer tous les articles en BDD
        return $this->render('exo/index.html.twig', [
            'voitures' => $voitures //envoie les articles au template
        ]);
    }
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/exo/liste', name: 'liste_voitures')]
public function voiture(VoitureRepository $repo): Response
//$id correspondant au {id} dans l'URL
{
    $voiture=$repo->findAll();
    //find() permet de récupérer l'article en fonction de son id
    return $this->render('exo/liste.html.twig', [
        'voitures'=> $voiture
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/exo/voitures/{id}', name: 'voiture')]
public function show($id, VoitureRepository $repo): Response
{
    $voiture=$repo->find($id);
    return $this->render('exo/voitures.html.twig', [
        'voiture'=> $voiture
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/exo/new', name: 'exo_create')]
#[Route('/exo/edit/{id}', name: 'exo_edit')]
public function form(Request $globals, EntityManagerInterface $manager, Voiture $voiture = null): Response
{
    if( $voiture == null) {
        $voiture=new Voiture;
    }
    $form=$this->createForm(VoitureType::class, $voiture);

    $form->handleRequest($globals);

      if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($voiture);
        $manager->flush();
        return $this->redirectToRoute('liste_voitures', [
            'id'=> $voiture->getId()
        ]);
    }
    return $this->renderForm('exo/form.html.twig', [
        'form'=> $form,
        'editMode'=> $voiture->getId() !== null
    ]);
}
//---------------------------------------------------------------------------------------------------------------------------------------
#[Route('/exo/delete/{id}', name: 'voiture_delete')]
public function delete (Voiture $voiture, EntityManagerInterface $manager)
{
    $manager->remove($voiture);
    $manager->flush();

    return $this->redirectToRoute('liste_voitures');
}

//#[Route('/exo/delete/{id}', name: 'voiture_delete')]
//public function delete ($id, EntityManagerInterface $manager, VoitureRepository $repo)
//{
//    $voiture=$repo->find($id);
//
//    $manager->remove($voiture);
//    $manager->flush();
//
//    return $this->redirectToRoute('liste_voitures');
//}
//---------------------------------------------------------------------------------------------------------------------------------------

}
