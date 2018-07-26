<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Service\Hello;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
	 * @Route("/addtodo", name="addtodo")
	 *
	 * @param EntityManagerInterface $em
	 * @return JsonResponse
	 */
	public function todoAction(EntityManagerInterface $em): JsonResponse
	{
		$todo = new Todo();
		$em->persist($todo);
		$em->flush();

		return new JsonResponse([
			'id' => $todo->getId(),
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
}
