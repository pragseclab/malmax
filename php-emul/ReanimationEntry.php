<?php

namespace PHPEmul;


class ReanimationEntry
{
    public string $state_hash;
    public string $current_file;
    public int $current_line;
    public bool $forked;

    public function __construct(string $state_hash, string $current_file, int $current_line, bool $forked=true)
    {
        $this->state_hash = utf8_encode($state_hash);
        $this->current_file = utf8_encode($current_file);
        $this->current_line = $current_line;
        $this->forked = $forked;
    }
}