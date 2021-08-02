<?php

namespace App\Controller;

use App\Notifier\ClientLoginLinkNotification;
use App\Repository\ClientRepository;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private SweetAlertFactory $flasher,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/{_locale<%app.supported_locales%>}/admin/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be executed! (it will be intercepted by the logout key on your firewall)
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/{_locale<%app.supported_locales%>}/login-check', name: 'login_check')]
    public function check(Request $request)
    {
        // throw new \LogicException('This code should never be reached');

        return $this->render('security/process_login_link.html.twig', [
            'expires' => $request->query->get('expires'),
            'user' => $request->query->get('user'),
            'hash' => $request->query->get('hash'),
        ]);
    }

    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('request_login_link', ['_locale' => 'ru']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/login-link-failure', name: 'login_link_failure')]
    public function loginLinkFailure(): Response
    {
        $localizedMsg = $this->translator->trans('This link is expired or incorrect');
        $this->flasher->addError($localizedMsg);

        return $this->forward(__CLASS__.'::requestLoginLink');
    }

    #[Route('/{_locale<%app.supported_locales%>}', name: 'request_login_link')]
    public function requestLoginLink(
        NotifierInterface $notifier,
        LoginLinkHandlerInterface $loginLinkHandler,
        ClientRepository $clientRepository,
        Request $request,
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $client = $clientRepository->findOneBy(['email' => $email]);

            if (null === $client) {
                $localizedMsg = $this->translator->trans('This email is not allowed');
                $this->flasher->addError($localizedMsg);

                return $this->redirectToRoute('request_login_link');
            }

            if (false === $client->getHasKwAccess()) {
                $localizedMsg = $this->translator->trans('Access is not granted by administrator');
                $this->flasher->addError($localizedMsg);

                return $this->redirectToRoute('request_login_link');
            }

            $clientName = $client->getName();
            $loginLinkDetails = $loginLinkHandler->createLoginLink($client);
            // create a notification based on the login link details
            $notification = new ClientLoginLinkNotification(
                $loginLinkDetails,
                $clientName,
                'Link to Connect', // email subject
            );
            // create a recipient for this client
            $recipient = new Recipient($email);

            // send the notification to the client
            $notifier->send($notification, $recipient);
            $loginLink = $loginLinkDetails->getUrl();

            // render a "Login link is sent!" page
            return $this->render('security/login_link_sent.html.twig', [
                'client_email' => $email,
                // 'login_link' => $loginLink,
            ]);
        }

        // if it's not submitted, render the "login" form
        return $this->render('security/login_link_form.html.twig');
    }
}
