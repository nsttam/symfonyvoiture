<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture= $repository->findAll();
        return $this->render('voiture/index.html.twig', [
            'voiture' => $voiture
        ]);
    }

    /**
     * @Route("/voiture/add", name="voiture-add")
     */
    public function addVoiture(Request $request ){
        $form = $this->createForm(VoitureType::class, new Voiture());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('voiture');
        }else {
            return $this->render('voiture/addvoiture.html.twig', [
                'form' => $form->createView(),'errors'=>$form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/detail/{voiture}", name="voiture-detail", requirements={"voiture"="^(?!register).+"})
     */
    public function detail(Voiture $voiture){
        return $this->render('voiture/voituredetail.html.twig', [
            'controller_name' => 'VoitureController',
            'voiture' => $voiture
        ]);

    }










}


