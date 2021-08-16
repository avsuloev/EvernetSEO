<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    public function __construct(
        HttpKernelInterface $httpKernel,
        HttpUtils $httpUtils,
        array $options = [],
    ) {
        parent::__construct($httpKernel, $httpUtils, $options);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return $this->httpUtils->createRedirectResponse($request, 'login_link_failure');
    }
}
