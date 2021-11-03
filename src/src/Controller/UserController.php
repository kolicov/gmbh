<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="user_edit")
     */
    public function edit(Request $request, int $id): Response
    {
        if (!empty($request->cookies->get('block-me'))) {
            return $this->redirectToRoute('something_is_wrong');
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $currentDate = new \DateTime();
            $user->setUpdatedAt($currentDate);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/add", name="user_add")
     */
    public function add(Request $request): Response
    {
        if (!empty($request->cookies->get('block-me'))) {
            return $this->redirectToRoute('something_is_wrong');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $currentDate = new \DateTime();
            $user->setCreatedAt($currentDate);
            $user->setUpdatedAt($currentDate);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/something-is-wrong", name="something_is_wrong")
     */
    public function somethingIsWrong(Request $request): Response
    {
        $cookieDate = new \DateTime();
        $cookieDate->setTimestamp($request->cookies->get('block-me'));

        $currentDate = new \DateTime();
        $currentDate->setTimestamp(time());

        $interval = $currentDate->diff($cookieDate);

        return $this->render('user/wrong.html.twig',[
            'time' => $interval->format('%i minutes %s seconds'),
        ]);
    }
}
