<?php

namespace App\Repository;

use App\Entity\Talk;

interface TalkRepository
{
    public function list(): array;

    public function get(string $id): ?Talk;

    public function add(Talk $talk): void;

    public function remove(Talk $talk): void;
}
