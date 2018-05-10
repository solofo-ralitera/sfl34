<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	 * @Route("/addtodo", name="addtodo")
	 *
	 * @param EntityManager $em
	 * @return JsonResponse
	 */
	public function todoAction(EntityManager $em)
	{
		$todo = new Todo();
		$em->persist($todo);
		$em->flush();

		return new JsonResponse([
			'id' => $todo->getId(),
		]);
	}
}
