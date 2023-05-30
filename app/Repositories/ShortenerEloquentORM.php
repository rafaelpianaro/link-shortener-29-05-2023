<?php

namespace App\Repositories;

use App\DTO\Shorteners\{CreateShortenerDTO, UpdateShortenerDTO};
use App\Models\AccessDetails;
use App\Models\Shortener;
use Illuminate\Support\Facades\DB;
use stdClass;

class ShortenerEloquentORM implements ShortenerRepositoryInterface
{
    public function __construct(
        protected shortener $model
    ) {}

    public function paginate(int $page = 1, int $totalPerPage = 1, string $filter = null): PaginationInterface
    {
        $result =  $this->model
                    ->where(function ($query) use ($filter) {
                        if ($filter) {
                            $query->where('subject', $filter);
                            $query->orWhere('body', 'like', "%{$filter}%");
                        }
                    })
                    ->paginate($totalPerPage, ['*'], 'page', $page);
        // dd(new PaginationPresenter($result));
        // dd((new PaginationPresenter($result))->items());
        return new PaginationPresenter($result);
    }

    public function findOne(string $id): stdClass|null
    {
        $shortener = $this->model->find($id);

        if (!$shortener) {
            return null;
        }

        return (object) $shortener->toArray();
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

    public function new(CreateShortenerDTO $dto): stdClass
    {
        $shortener = $this->model->create((array)$dto);
        $m = $this->model->first();
        $m->access_details()->create((array)$dto);

        return (object) $shortener->toArray();
    }

    public function update(UpdateShortenerDTO $dto): stdClass|null
    {
        if (!$shortener = $this->model->find($dto->identifier)) {
            return null;
        }
        
        $shortener->update((array) $dto);

        return (object) $shortener->toArray();
    }

}