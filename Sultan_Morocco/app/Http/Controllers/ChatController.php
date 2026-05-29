<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /* ── Intent keyword map ─────────────────────────────────────────── */
    private array $INTENTS = [
        'greeting'    => ['hello','hi','hey','bonjour','salut','marhaba','salam','good morning','good evening'],
        'restaurants' => ['restaurant','food','eat','dining','cafe','cuisine','tagine','couscous','meal','lunch','dinner'],
        'hotels'      => ['hotel','stay','accommodation','riad','resort','room','sleep','lodge'],
        'surf'        => ['surf','windsurf','wave','kite','kiteboard','dakhla','essaouira','tarifa'],
        'itinerary'   => ['trip','itinerary','plan','visit','tour','schedule','days','week','route'],
        'weather'     => ['weather','temperature','climate','rain','sunny','season','best time','when to go'],
        'help'        => ['help','what can','assist','capabilities'],
    ];

    /* ── Rule-based responses ───────────────────────────────────────── */
    private array $RULES = [
        'greeting' => [
            'type'    => 'text',
            'reply'   => "Marhaba! 🌟 I'm **Sultan**, your personal guide to Morocco & Spain.\n\nI can help you discover hotels, restaurants, surf spots, or plan your perfect itinerary. What are you looking for?",
            'options' => ['🏄 Best surf spots', '🍽️ Top restaurants', '🏨 Hotels in Morocco', '🗺️ Plan a trip'],
        ],
        'help' => [
            'type'    => 'buttons',
            'reply'   => "Here's everything I can help you with:",
            'options' => ['🏄 Surf & Windsurf', '🍽️ Restaurants', '🏨 Hotels & Riads', '🗺️ Plan itinerary', '🌤️ Best time to visit', '💎 Hidden gems'],
        ],
        'surf' => [
            'type'    => 'cards',
            'reply'   => '🏄 Top surf & windsurf destinations:',
            'items'   => [
                ['name'=>'Dakhla Lagoon',    'location'=>'Dakhla, Morocco',    'rating'=>4.9, 'image'=>'https://images.unsplash.com/photo-1502680390469-be75c86b636f?w=400&auto=format', 'tag'=>'Windsurf'],
                ['name'=>'Essaouira Beach',  'location'=>'Essaouira, Morocco', 'rating'=>4.7, 'image'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&auto=format', 'tag'=>'Surf'],
                ['name'=>'Sidi Kaouki',      'location'=>'Near Essaouira',     'rating'=>4.6, 'image'=>'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&auto=format', 'tag'=>'Kite'],
                ['name'=>'Tarifa Beach',     'location'=>'Tarifa, Spain',      'rating'=>4.8, 'image'=>'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&auto=format', 'tag'=>'Windsurf'],
            ],
            'options' => ['Best season to surf', 'Gear rental info', 'Book surf lessons'],
        ],
        'restaurants' => [
            'type'    => 'cards',
            'reply'   => '🍽️ Must-try restaurants in Morocco:',
            'items'   => [
                ['name'=>'Nomad',        'location'=>'Marrakech Medina', 'rating'=>4.8, 'image'=>'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=400&auto=format', 'tag'=>'Moroccan'],
                ['name'=>'Le Jardin',    'location'=>'Marrakech',        'rating'=>4.7, 'image'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&auto=format', 'tag'=>'Mediterranean'],
                ['name'=>'Nur Restaurant','location'=>'Fes',             'rating'=>4.6, 'image'=>'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&auto=format', 'tag'=>'Fine Dining'],
                ['name'=>"Rick's Café",  'location'=>'Casablanca',       'rating'=>4.5, 'image'=>'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=400&auto=format', 'tag'=>'Classic'],
            ],
            'options' => ['Vegetarian options', 'Best street food', 'Rooftop restaurants'],
        ],
        'hotels' => [
            'type'    => 'cards',
            'reply'   => '🏨 Top-rated stays in Morocco:',
            'items'   => [
                ['name'=>'La Mamounia',           'location'=>'Marrakech',        'rating'=>4.9, 'image'=>'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400&auto=format', 'tag'=>'Luxury'],
                ['name'=>'Riad Yasmine',           'location'=>'Marrakech Medina', 'rating'=>4.8, 'image'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=400&auto=format', 'tag'=>'Riad'],
                ['name'=>'Royal Mansour',          'location'=>'Marrakech',        'rating'=>5.0, 'image'=>'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&auto=format', 'tag'=>'Palace'],
                ['name'=>'Sofitel Fes Palais Jamai','location'=>'Fes',             'rating'=>4.7, 'image'=>'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&auto=format', 'tag'=>'Resort'],
            ],
            'options' => ['Budget riads', 'Luxury resorts', 'Beach hotels'],
        ],
        'itinerary' => [
            'type'  => 'text',
            'reply' => "✈️ **Suggested 5-Day Morocco Itinerary:**\n\n📅 **Day 1** — Arrive Marrakech · Explore Medina & Jemaa el-Fna\n📅 **Day 2** — Atlas Mountains day trip · Berber villages\n📅 **Day 3** — Drive to Essaouira · Surf & fresh seafood\n📅 **Day 4** — Dakhla · World-class windsurfing\n📅 **Day 5** — Casablanca · Hassan II Mosque · Departure\n\nWant me to customise this for your dates?",
            'options' => ['Customise this trip', 'Hotels for this route', 'Best time to visit'],
        ],
        'weather' => [
            'type'  => 'text',
            'reply' => "🌤️ **Best times to visit Morocco:**\n\n🌸 **Spring (Mar–May)** — Perfect weather 20–25°C, great for cities & Atlas\n🏄 **Summer (Jun–Aug)** — Hot inland, ideal winds for Dakhla & Essaouira surf\n🍂 **Autumn (Sep–Nov)** — Best overall: great surf, fewer crowds, mild heat\n❄️ **Winter (Dec–Feb)** — Mild cities, Atlas skiing, magical Sahara sunsets",
            'options' => ['Plan spring trip', 'Summer surf guide', 'Winter in the Sahara'],
        ],
    ];

    /* ── POST /api/chat ─────────────────────────────────────────────── */
    public function chat(Request $request)
    {
        $message = trim($request->input('message', ''));

        if ($message === '') {
            return response()->json(['type'=>'text','reply'=>'Please type a message!']);
        }

        $intent = $this->detectIntent($message);

        /* Rule-based response */
        if ($intent !== 'ai' && isset($this->RULES[$intent])) {
            return response()->json($this->RULES[$intent]);
        }

        /* AI fallback — OpenAI gpt-4o-mini */
        return $this->askOpenAI($message);
    }

    /* ── Intent detection ───────────────────────────────────────────── */
    private function detectIntent(string $message): string
    {
        $msg = strtolower($message);
        foreach ($this->INTENTS as $intent => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($msg, $kw)) return $intent;
            }
        }
        return 'ai';
    }

    /* ── OpenAI call ────────────────────────────────────────────────── */
    private function askOpenAI(string $message)
    {
        $apiKey = config('services.openai.key');

        if (! $apiKey) {
            return response()->json([
                'type'  => 'text',
                'reply' => "I'm Sultan, your Morocco & Spain travel guide! 🌟 I can help with hotels, restaurants, surf spots, and trip planning. Ask me anything!",
                'options' => ['🏄 Surf spots', '🍽️ Restaurants', '🏨 Hotels', '🗺️ Plan a trip'],
            ]);
        }

        $client = Http::withToken($apiKey)->timeout(30);

        if (! app()->isProduction()) {
            $client = $client->withoutVerifying();
        }

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'model'       => 'gpt-4o-mini',
            'messages'    => [
                [
                    'role'    => 'system',
                    'content' => "You are Sultan, a friendly and knowledgeable travel assistant for Morocco and Spain, specialising in tourism, windsurf exploration, luxury riads, restaurants, and hidden gems. Keep answers concise (max 3 short paragraphs), warm, and helpful. Use occasional emoji. Format lists with bullet points. Never mention that you are an AI model.",
                ],
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens'  => 350,
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            return response()->json([
                'type'  => 'text',
                'reply' => "I'm having a little trouble right now. Please try again in a moment! 🙏",
            ]);
        }

        $text = $response->json('choices.0.message.content', 'No response received.');

        return response()->json(['type' => 'text', 'reply' => $text]);
    }
}
