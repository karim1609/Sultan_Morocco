<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelController extends Controller
{
    /**
     * Return the hotels/index view.
     */
    public function index()
    {
        return view('hotels.index');
    }

    /**
     * Proxy GET /api/hotels  →  Xotelo /list
     *
     * Query params forwarded:
     *   offset  (default 0)
     *   limit   (default 30, max 100)
     *   sort    (best_value | popularity | distance)
     */
    public function list(Request $request)
    {
        $validated = $request->validate([
            'offset' => 'integer|min:0',
            'limit' => 'integer|min:1|max:100',
            'sort' => 'in:best_value,popularity,distance',
        ]);

        $baseUrl = rtrim((string) config('services.xotelo.base_url'), '/');
        $locationKey = config('services.xotelo.location_key');

        if ($locationKey === null || $locationKey === '') {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Hotel search is not configured. Set XOTELO_LOCATION_KEY in your .env file.',
                    ],
                    'result' => null,
                ],
                503,
            );
        }

        $client = Http::timeout(15);

        // On local/dev Windows machines PHP's bundled cURL often lacks the
        // CA bundle needed to verify external TLS certs.  We skip verification
        // in non-production environments only — never disable this in production.
        if (! app()->isProduction()) {
            $client = $client->withoutVerifying();
        }

        $response = $client->get($baseUrl.'/list', [
            'location_key' => $locationKey,
            'offset' => $validated['offset'] ?? 0,
            'limit' => $validated['limit'] ?? 30,
            'sort' => $validated['sort'] ?? 'best_value',
        ]);

        if ($response->failed()) {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Failed to reach Xotelo API (HTTP '.
                            $response->status().
                            ')',
                    ],
                    'result' => null,
                ],
                502,
            );
        }

        // Pass the JSON straight through — same shape the front-end already expects
        return response($response->body(), 200)->header(
            'Content-Type',
            'application/json',
        );
    }
}
