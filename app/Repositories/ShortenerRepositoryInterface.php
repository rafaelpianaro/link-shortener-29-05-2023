<?php

namespace App\Repositories;

use App\DTO\Shorteners\{CreateShortenerDTO, UpdateShortenerDTO};
use stdClass;

interface ShortenerRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 1, string $filter = null): PaginationInterface;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateShortenerDTO $dto): stdClass;
    public function update(UpdateShortenerDTO $dto): stdClass|null;
}