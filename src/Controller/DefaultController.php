<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as Encoder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\BoardCategory;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'default')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        for ($i = 0;$i<100;$i++) {
            $BoardCategory = new BoardCategory();
            $BoardCategory->setName('BoardCategory_' . $i);
    
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($BoardCategory);
        }

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        die("done");
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("api/me", methods={"GET"})
     */
    public function me(Encoder $jwtEncoder,Request $request): Response
    {
        $data = $jwtEncoder->decode(substr($request->headers->get('Authorization'),7));
        return $this->json($data);
    }
}
