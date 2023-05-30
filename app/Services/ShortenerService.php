<?php

namespace App\Services;

use App\DTO\Shorteners\{CreateShortenerDTO, UpdateShortenerDTO};
use App\Repositories\PaginationInterface;
use App\Repositories\ShortenerRepositoryInterface;
use stdClass;

class ShortenerService
{
    public function __construct(
        protected ShortenerRepositoryInterface $repository,
    ) {}

    public function paginate(
        int $page = 1, 
        int $totalPerPage = 2, 
        string $filter = null,
    ): PaginationInterface {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateShortenerDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateShortenerDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string|int $id): void
    {
        $this->repository->delete($id);
    }
}