<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as Encoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as PasswordEncoder;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
class AppController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    #[Route('/Board', name: 'app_board')]
    #[Route('/Board/{categoryId}', name: 'app_board_category')]
    #[Route('/Board/{categoryId}/{topicId}', name: 'app_board_category_topic')]
    #[Route('/Board/{categoryId}/{topicId}/edit', name: 'app_board_category_topic_edit')]
    #[Route('/Board/{categoryId}/{topicId}/{postId}/edit', name: 'app_board_category_topic_post_edit')]
    #[Route('/User/{username}', name: 'app_user_profile')]
    #[Route('/Auth/Login', name: 'app_auth_login')]
    #[Route('/Auth/Logout', name: 'app_auth_logut')]
    #[Route('/Auth/Register', name: 'app_auth_register')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
        ]);
    }

    /**
     * this method extracts encodes the password
     * 
     * @Route("api/signup", methods={"POST","PUT"})
     */
    public function signup(UserRepository $users, PasswordEncoder $encoder,Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if ($users->findOneBy(['username' => $data["username"]])) {
            $response = new JsonResponse();
            $response->setStatusCode(403);
            return $response;
        }
        $user = new User();
        $user->setUsername($data["username"]);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($encoder->encodePassword($user, $data["password"]));
        $user->setApi("/api/users/" . $data["username"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['response' => true]);
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
