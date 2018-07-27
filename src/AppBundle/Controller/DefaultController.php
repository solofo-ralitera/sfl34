<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;
use AppBundle\Service\Hello;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/hello", name="hello")
     *
     * @param Hello $hello
     * @return Response
     */
    public function helloAction(Hello $hello): Response
    {
        $res = $hello->sayHello();
        return new Response($res);
    }

    /**
     * @Route("/todolist", name="todolist")
     *
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function todoAction(EntityManagerInterface $em): Response
    {
        return $this->render('@App/todolist.html.twig', array(
            'todos' => $em->getRepository('AppBundle:Todo')->findAll(),
        ));
    }

    /**
     * @Route("/formtodo", name="formtodo")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formtodoAction(Request $request, EntityManagerInterface $em): Response
    {
        $todo = new Todo();
        $form = $this->createForm(
            TodoType::class,
            $todo
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todo = $form->getData();

            $em->persist($todo);
            $em->flush();

            return $this->redirectToRoute('todolist');
        }

        return $this->render('@App/formtodo.html.twig', array(
            'form' => $form->createView(),
        ));
    }

	/**
	 * @Route("/addtodo", name="addtodo")
	 *
	 * @param EntityManagerInterface $em
	 * @return JsonResponse
	 */
	public function addtodoAction(EntityManagerInterface $em): JsonResponse
	{
		$todo = new Todo();
		$em->persist($todo);
		$em->flush();

		return new JsonResponse([
			'id' => $todo->getId(),
		]);
	}
}
