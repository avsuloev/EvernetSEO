<?php

namespace App\Service;

use App\Entity\Client;
use App\Model\KwCollectionModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Security;

class AuthenticatedClientService
{
    private ?Client  $client = null;

    // Avoid calling getUser() in the constructor: auth may not
    // be complete yet. Instead, store the entire Security object.
    public function __construct(private Security $security)
    {
    }

    public function getClient(): Client
    {
        $client = $this->client ?? $this->security->getUser();
        if (null === $client) {
            // todo: implement logic
            throw new \Exception('Client is not authenticated!');
        }
        if (!($client instanceof Client)) {
            // todo: implement logic
            throw new \Exception('Authenticated user is not a client!');
        }

        return $client;
    }

    public function getAllKeywords(): KwCollectionModel
    {
        $client = $this->getClient();
        $projects = $client->getProjects();
        $kwGroupsByProjects = new ArrayCollection();

        foreach ($projects as $project) {
            $kwGroups = $project->getKeywordGroups();
            foreach ($kwGroups as $kwGroup) {
                if (!$kwGroupsByProjects->contains($kwGroup)) {
                    $kwGroupsByProjects[] = $kwGroup;
                }
            }
        }

        $kwCollection = new KwCollectionModel();
        foreach ($kwGroupsByProjects as $kwGroup) {
            $keywords = $kwGroup->getKeywords();
            foreach ($keywords as $keyword) {
                $kwCollection->addKeyword($keyword);
            }
        }

        return $kwCollection;
    }
}
