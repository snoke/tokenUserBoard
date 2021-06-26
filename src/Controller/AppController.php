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
use App\Repository\ChatMessageRepository as Messages;
use Symfony\Component\HttpFoundation\JsonResponse;
class AppController extends AbstractController
{
    private $jwtEncoder;

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
    #[Route('/Chat', name: 'app_chat')]
    #[Route('/Chat/{username}', name: 'app_chat_user')]
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
    public function __construct(Encoder $jwtEncoder) {
        $this->jwtEncoder=$jwtEncoder;
    }
    /**
     * 
     * @Route("api/getChatMessages/{chatPartner}", methods={"GET"})
     */
    public function getChatMessages(Request $request,UserRepository $users,Messages $messages,$chatPartner): Response
    {
        $credentials = $this->jwtEncoder->decode(substr($request->headers->get('Authorization'),7));
        $user = $users->findOneBy(['id' => $credentials['id']]);
        $partner = $users->findOneBy(['username' => $chatPartner]);
        
        return $this->json(array_reverse($messages->findBy([
            'recipient' => [
                $user,
                $partner
            ],
            'author' => [
                $user,
                $partner
            ]
        ],['id'=>'DESC'],10)));
    }

    /**
     * this method extracts user credentials stored as payload within the token
     * 
     * @Route("api/me", methods={"GET"})
     */
    public function getCredentials(Request $request): Response
    {
        $data = $this->jwtEncoder->decode(substr($request->headers->get('Authorization'),7));
        return $this->json($data);
    }

}
