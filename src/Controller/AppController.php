<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as Encoder;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    #[Route('/board', name: 'app_board')]
    #[Route('/board/{categoryId}', name: 'app_board_category')]
    #[Route('/board/{categoryId}/{topicId}', name: 'app_board_category_topic')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
        ]);
    }

    /**
     * this method extracts user credentials stored as payload within the token
     * 
     * @Route("api/me", methods={"GET"})
     */
    public function getCredentials(Encoder $jwtEncoder,Request $request): Response
    {
        $data = $jwtEncoder->decode(substr($request->headers->get('Authorization'),7));
        return $this->json($data);
    }
}
