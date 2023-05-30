<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AccessDetails;
use App\Models\Shortener;
use Illuminate\Http\Request;

class ShortenerController extends Controller
{
    public function handle(Request $request, $identifier)
    {
        $shortener = Shortener::where('identifier', '=', $identifier)->first();
        if (!$shortener) {
            return redirect('/');
        } else {
            // $data = AccessDetails::where('shortener_identifier', $identifier)->first();
            $data = new AccessDetails();
            $data['ip'] = $request->ip();
            $data['user_agent'] = $request->server('HTTP_USER_AGENT');
            $data['shortener_identifier'] = $identifier;
            $data->fill($data->toArray());
		    $data->save();

            Shortener::where('identifier', $identifier)->where(fn($q) => $q->getModel()->timestamps = false)->increment('access');

            return redirect($shortener['url']);
        }
    }
}
