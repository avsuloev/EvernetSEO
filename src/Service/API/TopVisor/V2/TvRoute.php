<?php

namespace App\Service\API\TopVisor\V2;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * Annotation class for @TvRoute().
 *
 * @Annotation
 * @NamedArgumentConstructor
 * @Target({"CLASS", "METHOD"})
 *
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class TvRoute
{
    private $path;
    private $localizedPaths = [];
    private string $name;

    /**
     * @param array|string      $data data array managed by the Doctrine Annotations library or the path
     * @param array|string|null $path
     */
    public function __construct(
        $data = [],
        $path = null,
        string $name = null,
    ) {
        if (\is_string($data)) {
            $data = ['path' => $data];
        } elseif (!\is_array($data)) {
            throw new \TypeError(sprintf('"%s": Argument $data is expected to be a string or array, got "%s".', __METHOD__, get_debug_type($data)));
        } elseif ([] !== $data) {
            $localizedPaths = $data;
            $data = ['path' => $localizedPaths];
        }
        if (null !== $path && !\is_string($path) && !\is_array($path)) {
            throw new \TypeError(sprintf('"%s": Argument $path is expected to be a string, array or null, got "%s".', __METHOD__, get_debug_type($path)));
        }

        $data['path'] ??= $path;
        $data['name'] ??= $name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setLocalizedPaths(array $localizedPaths)
    {
        $this->localizedPaths = $localizedPaths;
    }

    public function getLocalizedPaths(): array
    {
        return $this->localizedPaths;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
