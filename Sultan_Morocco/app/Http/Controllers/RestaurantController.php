<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private array $RESTAURANTS = [
        [
            'name' => 'Le Jardin',
            'city' => 'Marrakech',
            'cuisine' => 'Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.8, 'count' => 2340],
            'geo' => ['latitude' => 31.6315, 'longitude' => -7.9872],
            'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d3413612-Reviews-Le_Jardin-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Lamb Tagine', 'Bastilla', 'Harira Soup'],
            'labels' => ['Outdoor seating', 'Vegetarian friendly'],
        ],
        [
            'name' => 'Nomad',
            'city' => 'Marrakech',
            'cuisine' => 'Contemporary Moroccan',
            'price_level' => '€€',
            'review_summary' => ['rating' => 4.7, 'count' => 3180],
            'geo' => ['latitude' => 31.6300, 'longitude' => -7.9852],
            'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d6476617-Reviews-Nomad-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Spiced Calamari', 'Rooftop Mezze', 'Saffron Risotto'],
            'labels' => ['Rooftop views', 'Trendy'],
        ],
        [
            'name' => 'Dar Yacout',
            'city' => 'Marrakech',
            'cuisine' => 'Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.6, 'count' => 1870],
            'geo' => ['latitude' => 31.6334, 'longitude' => -7.9902],
            'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d317585-Reviews-Dar_Yacout-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Royal Couscous', 'Pigeon Pastilla', 'Lamb Mechoui'],
            'labels' => ['Romantic', 'Traditional ambiance'],
        ],
        [
            'name' => 'La Maison Arabe Restaurant',
            'city' => 'Marrakech',
            'cuisine' => 'Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.9, 'count' => 2670],
            'geo' => ['latitude' => 31.6302, 'longitude' => -7.9962],
            'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d317608-Reviews-La_Maison_Arabe_Restaurant-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Chicken Bastilla', 'Beef Tagine', 'Orange Flower Pastries'],
            'labels' => ['Fine dining', 'Live music', 'Elegant'],
        ],
        [
            'name' => 'Cafe Clock',
            'city' => 'Fes',
            'cuisine' => 'Moroccan',
            'price_level' => '€',
            'review_summary' => ['rating' => 4.5, 'count' => 4210],
            'geo' => ['latitude' => 34.0639, 'longitude' => -4.9762],
            'image' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293753-d1390130-Reviews-Cafe_Clock-Fes_Fes_Meknes.html',
            'specialties' => ['Camel Burger', 'Mint Tea', 'Briouats'],
            'labels' => ['Budget friendly', 'Cultural events'],
        ],
        [
            'name' => 'The Ruined Garden',
            'city' => 'Fes',
            'cuisine' => 'Mediterranean',
            'price_level' => '€€',
            'review_summary' => ['rating' => 4.7, 'count' => 1540],
            'geo' => ['latitude' => 34.0610, 'longitude' => -4.9738],
            'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293753-d6611521-Reviews-The_Ruined_Garden-Fes_Fes_Meknes.html',
            'specialties' => ['Grilled Lamb', 'Mezze Platter', 'Lemon Herb Chicken'],
            'labels' => ['Garden terrace', 'Vegetarian friendly'],
        ],
        [
            'name' => "Rick's Cafe",
            'city' => 'Casablanca',
            'cuisine' => 'French / International',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.4, 'count' => 3920],
            'geo' => ['latitude' => 33.5996, 'longitude' => -7.6186],
            'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293755-d1379891-Reviews-Rick_s_Cafe-Casablanca_Grand_Casablanca.html',
            'specialties' => ['Beef Tenderloin', 'French Onion Soup', 'Crème Brûlée'],
            'labels' => ['Iconic venue', 'Live jazz', 'Dress code'],
        ],
        [
            'name' => 'La Sqala',
            'city' => 'Casablanca',
            'cuisine' => 'Moroccan',
            'price_level' => '€€',
            'review_summary' => ['rating' => 4.5, 'count' => 2860],
            'geo' => ['latitude' => 33.6074, 'longitude' => -7.6239],
            'image' => 'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293755-d1379812-Reviews-La_Sqala-Casablanca_Grand_Casablanca.html',
            'specialties' => ['Lamb Couscous', 'Pastilla au Lait', 'Mixed Tagine'],
            'labels' => ['Historic fortress', 'Garden courtyard'],
        ],
        [
            'name' => 'Le Dhow',
            'city' => 'Rabat',
            'cuisine' => 'Mediterranean',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.6, 'count' => 1430],
            'geo' => ['latitude' => 34.0209, 'longitude' => -6.8324],
            'image' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293752-d1379980-Reviews-Le_Dhow-Rabat_Rabat_Sale_Kenitra.html',
            'specialties' => ['Grilled Sea Bass', 'Lobster Bisque', 'Seafood Paella'],
            'labels' => ['Boat restaurant', 'Waterfront views'],
        ],
        [
            'name' => 'Dinarjat',
            'city' => 'Rabat',
            'cuisine' => 'Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.7, 'count' => 1280],
            'geo' => ['latitude' => 34.0183, 'longitude' => -6.8299],
            'image' => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293752-d806498-Reviews-Dinarjat-Rabat_Rabat_Sale_Kenitra.html',
            'specialties' => ['Bastilla Imperial', 'Mechoui Lamb', 'Seffa Medfouna'],
            'labels' => ['Historic palace', 'Romantic', 'Traditional music'],
        ],
        [
            'name' => 'Restaurant Populaire Sejour',
            'city' => 'Chefchaouen',
            'cuisine' => 'Moroccan',
            'price_level' => '€',
            'review_summary' => ['rating' => 4.4, 'count' => 980],
            'geo' => ['latitude' => 35.1685, 'longitude' => -5.2687],
            'image' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g298349-d2195613-Reviews-Restaurant_Populaire_Sejour-Chefchaouen_Tanger_Tetouan_Al_Hoceima.html',
            'specialties' => ['Goat Tagine', 'Kefta Skewers', 'Harira'],
            'labels' => ['Local favorite', 'Budget friendly'],
        ],
        [
            'name' => 'Lala Mesouda',
            'city' => 'Chefchaouen',
            'cuisine' => 'Moroccan',
            'price_level' => '€',
            'review_summary' => ['rating' => 4.6, 'count' => 720],
            'geo' => ['latitude' => 35.1692, 'longitude' => -5.2694],
            'image' => 'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g298349-d10167985-Reviews-Lala_Mesouda-Chefchaouen_Tanger_Tetouan_Al_Hoceima.html',
            'specialties' => ['Mountain Herb Salad', 'Lamb Mrouzia', 'Honey Pastries'],
            'labels' => ['Home cooking', 'Terrace views'],
        ],
        [
            'name' => 'Al Fassia',
            'city' => 'Marrakech',
            'cuisine' => 'Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.7, 'count' => 2150],
            'geo' => ['latitude' => 31.6247, 'longitude' => -8.0141],
            'image' => 'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d317600-Reviews-Al_Fassia-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Chicken Rfissa', 'Lamb with Prunes', 'Seven Vegetable Couscous'],
            'labels' => ['Women-run', 'Authentic Fassi cuisine'],
        ],
        [
            'name' => 'Comptoir Darna',
            'city' => 'Marrakech',
            'cuisine' => 'French Moroccan',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.5, 'count' => 2980],
            'geo' => ['latitude' => 31.6377, 'longitude' => -8.0070],
            'image' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293734-d317605-Reviews-Comptoir_Darna-Marrakech_Marrakech_Safi.html',
            'specialties' => ['Duck Confit with Chermoula', 'Lamb Shank Tajine', 'Crème Caramel à la Rose'],
            'labels' => ['Belly dancing shows', 'Lively atmosphere'],
        ],
        [
            'name' => 'La Bagatelle',
            'city' => 'Casablanca',
            'cuisine' => 'French',
            'price_level' => '€€€',
            'review_summary' => ['rating' => 4.5, 'count' => 1640],
            'geo' => ['latitude' => 33.5892, 'longitude' => -7.6218],
            'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80',
            'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g293755-d317890-Reviews-La_Bagatelle-Casablanca_Grand_Casablanca.html',
            'specialties' => ['Foie Gras Poêlé', 'Sole Meunière', 'Tarte Tatin'],
            'labels' => ['Classic French', 'Business dining', 'Elegant'],
        ],
    ];

    public function index()
    {
        $restaurants = $this->RESTAURANTS;
        $cities = array_values(array_unique(array_column($restaurants, 'city')));
        sort($cities);
        $total = count($restaurants);

        return view('restaurants.index', compact('restaurants', 'cities', 'total'));
    }

    public function list(Request $request)
    {
        $all = $this->RESTAURANTS;

        // Filter by city
        $city = $request->query('city', '');
        if ($city && $city !== 'all') {
            $all = array_values(array_filter($all, fn($r) => strcasecmp($r['city'], $city) === 0));
        }

        // Sort
        $sort = $request->query('sort', 'rating');
        usort($all, function ($a, $b) use ($sort) {
            if ($sort === 'price_asc') {
                return strlen($a['price_level']) <=> strlen($b['price_level']);
            }
            if ($sort === 'price_desc') {
                return strlen($b['price_level']) <=> strlen($a['price_level']);
            }
            // Default: sort by rating desc, then count desc
            if ($a['review_summary']['rating'] !== $b['review_summary']['rating']) {
                return $b['review_summary']['rating'] <=> $a['review_summary']['rating'];
            }
            return $b['review_summary']['count'] <=> $a['review_summary']['count'];
        });

        return response()->json([
            'error' => null,
            'result' => [
                'total_count' => count($all),
                'list' => array_values($all),
            ],
        ]);
    }
}
