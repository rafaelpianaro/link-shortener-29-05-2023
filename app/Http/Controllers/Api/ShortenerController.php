<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Shorteners\{CreateShortenerDTO, UpdateShortenerDTO};
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateShortener;
use App\Http\Resources\ShortenerResource;
use App\Models\Shortener;
use App\Services\ShortenerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShortenerController extends Controller
{
    public function __construct(
        protected ShortenerService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shorteners = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::toJson($shorteners);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateShortener $request)
    {
        if (!isset($request->identifier)) {
            $request['identifier'] = self::getUnqiueShortUrl();
        }
        $shortener = $this->service->new(
            CreateShortenerDTO::makeFromRequest($request)
        );
        return new ShortenerResource($shortener);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateShortener $request, string $id)
    {
        $shortener = $this->service->update(
            UpdateShortenerDTO::makeFromRequest($request, $id)
        );

        if (!$shortener) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new ShortenerResource($shortener);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->service->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public static function getUnqiueShortUrl(){
		$shortened = base_convert(rand(1000000, 9999999), 25, 36);
        $record = Shortener::where('identifier', '=', $shortened)->first();
        if($record) {
            self::getUnqiueShortUrl();
        }
        return $shortened;
	}
}
