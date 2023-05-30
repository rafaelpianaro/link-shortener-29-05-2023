<?php

namespace App\DTO\Shorteners;

use App\Http\Requests\StoreUpdateShortener;

class UpdateShortenerDTO
{
    public function __construct(
        public string $identifier,
        public string $title,
        public string $url,
    ) {}

    public static function makeFromRequest(StoreUpdateShortener $request, string $identifier = null): self
    {
        return new self(
            $identifier ?? $request->shortener,
            $request->title,
            $request->url,
        );
    }
}