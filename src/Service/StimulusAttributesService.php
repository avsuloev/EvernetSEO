<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;

/**
 * TODO: find a better solution of service initialization
 *  with $controllerName injected via services.yaml.
 */
class StimulusAttributesService
{
    public function __construct(private string $controllerName)
    {
    }

    #[ArrayShape(['data-action' => 'string'])]
    public function genActionAttr(string $name, string $action): array
    {
        return ['data-action' => "$action->$this->controllerName#$name"];
    }

    public function genTargetAttr(string $name): array
    {
        return ["data-$this->controllerName-target" => $name];
    }

    #[ArrayShape(['data-controller' => 'string'])]
    public function genCtrlAttr(string $name): array
    {
        return ['data-controller' => $this->controllerName];
    }
}
