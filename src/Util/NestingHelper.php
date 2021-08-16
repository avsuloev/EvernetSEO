<?php

namespace App\Util;

class NestingHelper
{
    public function __construct(
        private int $lvl = 0,
        private array $parents = [null],
    ) {
    }

    public function descend($parent): self
    {
        $this->lvl = $this->lvl + 1;
        $this->parents[$this->lvl] = $parent;

        return $this;
    }

    public function ascend(): self
    {
        $this->parents = \array_diff_key($this->parents, [($this->lvl) => 'placeholder_val']);
        $this->lvl = $this->lvl - 1;
        if (0 >= $this->lvl) {
            $this->lvl = 0;
            $this->parents = [null];
        }

        return $this;
    }

    public function lvl(): int
    {
        return $this->lvl;
    }

    public function parent()
    {
        return $this->parents[$this->lvl];
    }
}
