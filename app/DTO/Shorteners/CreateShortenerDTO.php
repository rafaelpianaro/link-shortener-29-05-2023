<?php

namespace App\DTO\Shorteners;

use App\Http\Requests\StoreUpdateShortener;

class CreateShortenerDTO
{
    public function __construct(
        public string $identifier,
        public string $title,
        public string $url
    ) {}
    
    // recebendo a \request com um objeto da própria classe
    public static function makeFromRequest(StoreUpdateShortener $request): self
    {
        return new self(
            $request->identifier,
            $request->title,
            $request->url,
        );
    }
}