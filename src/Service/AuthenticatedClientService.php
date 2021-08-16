<?php

namespace App\Service;

use App\Entity\Client;
use App\Model\KwCollectionModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Security;

class AuthenticatedClientService
{
    private ?Client  $client = null;

    // Avoid calling getUser() in the constructor: auth may not
    // be complete yet. Instead, store the entire Security object.
    public function __construct(private Security $security)
    {
    }

    /**
     * @throws \Exception
     */
    public function getClient(): Client
    {
        $client = $this->client ?? $this->security->getUser();
        if (null === $client) {
            // todo: implement logic.
            throw new \Exception('Client is not authenticated!');
        }
        if (!($client instanceof Client)) {
            // todo: implement logic.
            throw new \Exception('Authenticated user is not a client!');
        }

        return $client;
    }

    public function getActiveProjects(): Collection
    {
        try {
            $client = $this->getClient();
        } catch (\Exception $e) {
            // todo: implement logic.
            throw $e;
        }

        return $client->getProjects();
    }
}
