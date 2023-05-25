<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



    /**
     * @Route("/adduser", name="adduser")
     */
    public function adduser(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Utilisateur();
        $user->setNom('user');
        $user->setAdressemail('adressemail');
        $user->setRole('role');
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());


    }

    /**
     * @Route("/showuser", name="showuser")
     */
    
    public function showuser(): Response
    {
        $user = $this->getDoctrine()
        ->getRepository(Utilisateur::class)
        ->findAll();

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '
            );
        }

        return new Response('Check out this great user: '.$user->getNom());
    }




    /**
     * @Route("/updateuser/{id}", name="updateuser")
     */


    public function updateuser($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setNom('new user name!');
        $entityManager->flush();

        return $this->redirectToRoute('user', [
            'id' => $user->getId()
        ]);
    }


    public function deleteuser($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

}