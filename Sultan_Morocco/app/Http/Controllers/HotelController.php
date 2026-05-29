<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Real Morocco hotel data (originally from Xotelo API — now static fallback)
    private array $HOTELS = [
        [
            "name" => "Riad Andallaspa",
            "key" => "g293730-d12219158",
            "accommodation_type" => "Small Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d12219158-Reviews-Riad_Andallaspa-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 5.0, "count" => 1341],
            "price_ranges" => ["minimum" => 131, "maximum" => 296],
            "geo" => ["latitude" => 31.626806, "longitude" => -7.981988],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/97/15/6a/getlstd-property-photo.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Movenpick Hotel Mansour Eddahbi Marrakech",
            "key" => "g293730-d302479",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d302479-Reviews-Movenpick_Hotel_Mansour_Eddahbi_Marrakech-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.6, "count" => 5326],
            "price_ranges" => ["minimum" => 249, "maximum" => 642],
            "geo" => ["latitude" => 31.62429, "longitude" => -8.014819],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0d/9e/49/70/spa-suite-swimming-pool.jpg",
            "merchandising_labels" => [],
        ],
        [
            "name" => "La Maison Arabe",
            "key" => "g293730-d303075",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d303075-Reviews-La_Maison_Arabe-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.9, "count" => 3970],
            "price_ranges" => ["minimum" => 166, "maximum" => 1162],
            "geo" => ["latitude" => 31.630224, "longitude" => -7.996193],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/31/54/9a/b9/patio.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Riad Dar Anika",
            "key" => "g293730-d609383",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d609383-Reviews-Riad_Dar_Anika-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.9, "count" => 2310],
            "price_ranges" => ["minimum" => 170, "maximum" => 493],
            "geo" => ["latitude" => 31.62036, "longitude" => -7.985888],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0a/54/c7/79/riad-dar-anika.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Riad Karmela",
            "key" => "g293730-d625586",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d625586-Reviews-Riad_Karmela-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.7, "count" => 2091],
            "price_ranges" => ["minimum" => 123, "maximum" => 300],
            "geo" => ["latitude" => 31.630133, "longitude" => -7.98436],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2c/29/66/80/797083-exterior.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Kenzi Rose Garden",
            "key" => "g293730-d304468",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d304468-Reviews-Kenzi_Rose_Garden-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.4, "count" => 1152],
            "price_ranges" => ["minimum" => 129, "maximum" => 493],
            "geo" => ["latitude" => 31.62243, "longitude" => -8.006564],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/a3/e7/e2/kenzi-rose-garden.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Les Jardins de la Koutoubia",
            "key" => "g293730-d316717",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d316717-Reviews-Les_Jardins_de_la_Koutoubia-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.5, "count" => 2451],
            "price_ranges" => ["minimum" => 260, "maximum" => 943],
            "geo" => ["latitude" => 31.626064, "longitude" => -7.991732],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/9c/85/e3/les-jardins-de-la-koutoubia.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Riad Kheirredine",
            "key" => "g293730-d1873436",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d1873436-Reviews-Riad_Kheirredine-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 5.0, "count" => 3942],
            "price_ranges" => ["minimum" => 180, "maximum" => 795],
            "geo" => ["latitude" => 31.637413, "longitude" => -7.993002],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/09/b8/17/32/riad-kheirredine.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Hotel Argana",
            "key" => "g293730-d557096",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293731-d557096-Reviews-Hotel_Argana-Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.0, "count" => 4205],
            "price_ranges" => ["minimum" => 118, "maximum" => 283],
            "geo" => ["latitude" => 30.413342, "longitude" => -9.59801],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/b1/91/27/hotel-argana.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Hyatt Regency Taghazout",
            "key" => "g293730-d23329414",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g1554848-d23329414-Reviews-Hyatt_Regency_Taghazout-Taghazout_Souss_Massa.html",
            "review_summary" => ["rating" => 4.7, "count" => 1292],
            "price_ranges" => ["minimum" => 237, "maximum" => 467],
            "geo" => ["latitude" => 30.532223, "longitude" => -9.694059],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/26/2a/ca/6b/hyatt-regency-taghazout.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Fairmont Royal Palm Marrakech",
            "key" => "g293730-d5598827",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d5598827-Reviews-Fairmont_Royal_Palm_Marrakech-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.7, "count" => 2313],
            "price_ranges" => ["minimum" => 434, "maximum" => 1792],
            "geo" => ["latitude" => 31.513218, "longitude" => -8.052152],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/61/91/9e/facade.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Ksar Anika Boutique Hotel",
            "key" => "g293730-d1718231",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d1718231-Reviews-Ksar_Anika_Boutique_Hotel-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.9, "count" => 319],
            "price_ranges" => ["minimum" => 129, "maximum" => 390],
            "geo" => ["latitude" => 31.62079, "longitude" => -7.980777],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/23/90/1d/b7/outdoor-courtyard-pool.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Hotel Riu Palace Tikida Agadir",
            "key" => "g293730-d2649171",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293731-d2649171-Reviews-Hotel_Riu_Palace_Tikida_Agadir-Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.4, "count" => 7558],
            "price_ranges" => ["minimum" => 318, "maximum" => 626],
            "geo" => ["latitude" => 30.40809, "longitude" => -9.59907],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2f/2d/7c/46/aerial-pools-view.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Pickalbatros Aqua Fun Club",
            "key" => "g293730-d2177899",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d2177899-Reviews-Pickalbatros_Aqua_Fun_Club-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.4, "count" => 7443],
            "price_ranges" => ["minimum" => 185, "maximum" => 439],
            "geo" => ["latitude" => 31.481327, "longitude" => -7.897701],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/75/c0/02/aqua-park.jpg",
            "merchandising_labels" => ["All inclusive"],
        ],
        [
            "name" => "The Central House Marrakech Medina",
            "key" => "g293730-d12641938",
            "accommodation_type" => "Hostel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d12641938-Reviews-The_Central_House_Marrakech_Medina-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.7, "count" => 543],
            "price_ranges" => ["minimum" => 68, "maximum" => 264],
            "geo" => ["latitude" => 31.633327, "longitude" => -7.987936],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/17/b9/69/20/rodamon-riad-marrakech.jpg",
            "merchandising_labels" => [],
        ],
        [
            "name" => "Riad Houdou",
            "key" => "g293730-d621179",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d621179-Reviews-Riad_Houdou-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.9, "count" => 2011],
            "price_ranges" => ["minimum" => 119, "maximum" => 248],
            "geo" => ["latitude" => 31.631851, "longitude" => -7.981882],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/d6/92/35/riad-houdou.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Barceló Anfa Casablanca",
            "key" => "g293730-d15515018",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293732-d15515018-Reviews-Barcelo_Anfa_Casablanca-Casablanca_Casablanca_Settat.html",
            "review_summary" => ["rating" => 4.6, "count" => 1056],
            "price_ranges" => ["minimum" => 142, "maximum" => 222],
            "geo" => ["latitude" => 33.594666, "longitude" => -7.628729],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/9e/be/fa/lobby.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Palais Riad Lamrani",
            "key" => "g293730-d7046818",
            "accommodation_type" => "Guest house",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d7046818-Reviews-Palais_Riad_Lamrani-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.9, "count" => 226],
            "price_ranges" => ["minimum" => 201, "maximum" => 500],
            "geo" => ["latitude" => 31.629566, "longitude" => -7.990307],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/27/00/18/a0/palais-riad-lamrani.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "La Mamounia Marrakech",
            "key" => "g293730-d301256",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d301256-Reviews-La_Mamounia_Marrakech-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.3, "count" => 4352],
            "price_ranges" => ["minimum" => 573, "maximum" => 3475],
            "geo" => ["latitude" => 31.621523, "longitude" => -7.997491],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2b/fe/c4/81/hotel-entrance.jpg",
            "merchandising_labels" => ["All inclusive"],
        ],
        [
            "name" => "Pickalbatros Palais Des Roses",
            "key" => "g293730-d33253636",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293731-d33253636-Reviews-Pickalbatros_Palais_Des_Roses-Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.7, "count" => 907],
            "price_ranges" => ["minimum" => 269, "maximum" => 534],
            "geo" => ["latitude" => 30.395067, "longitude" => -9.596552],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/30/57/1c/5d/overview.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Hilton Garden Inn Tanger City Center",
            "key" => "g293730-d8672446",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293737-d8672446-Reviews-Hilton_Garden_Inn_Tanger_City_Center-Tangier_Tanger_Tetouan_Al_Hoceima.html",
            "review_summary" => ["rating" => 4.4, "count" => 987],
            "price_ranges" => ["minimum" => 102, "maximum" => 181],
            "geo" => ["latitude" => 35.773945, "longitude" => -5.787506],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/09/98/39/7b/hilton-garden-inn-tanger.jpg",
            "merchandising_labels" => [],
        ],
        [
            "name" => "Hotel Riu Tikida Dunas",
            "key" => "g293730-d600207",
            "accommodation_type" => "Resort (All-Inclusive)",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293731-d600207-Reviews-Hotel_Riu_Tikida_Dunas-Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.3, "count" => 7055],
            "price_ranges" => ["minimum" => 235, "maximum" => 389],
            "geo" => ["latitude" => 30.398443, "longitude" => -9.597654],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/14/98/0b/dd/pool-area.jpg",
            "merchandising_labels" => ["All inclusive"],
        ],
        [
            "name" => "Iberostar Waves Founty Beach",
            "key" => "g293730-d549638",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293731-d549638-Reviews-Iberostar_Waves_Founty_Beach-Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.6, "count" => 4277],
            "price_ranges" => ["minimum" => 263, "maximum" => 472],
            "geo" => ["latitude" => 30.397055, "longitude" => -9.596923],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/29/76/7f/c7/iberostar-founty-beach.jpg",
            "merchandising_labels" => ["All inclusive"],
        ],
        [
            "name" => "Kenzi Club Agdal Medina",
            "key" => "g293730-d1941087",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d1941087-Reviews-Kenzi_Club_Agdal_Medina-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.4, "count" => 10800],
            "price_ranges" => ["minimum" => 217, "maximum" => 390],
            "geo" => ["latitude" => 31.57954, "longitude" => -7.983402],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/79/a1/d3/kenzi-club-agdal-medina.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "TUI BLUE Medina Gardens",
            "key" => "g293730-d6621142",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d6621142-Reviews-TUI_BLUE_Medina_Gardens-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.6, "count" => 2506],
            "price_ranges" => ["minimum" => 227, "maximum" => 385],
            "geo" => ["latitude" => 31.627748, "longitude" => -7.995484],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/17/b2/53/tui-blue-medina-gardens.jpg",
            "merchandising_labels" => ["All inclusive"],
        ],
        [
            "name" => "Pickalbatros White Beach Taghazout",
            "key" => "g293730-d21377950",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g1452345-d21377950-Reviews-Pickalbatros_White_Beach_Taghazout-Tamraght_Agadir_Souss_Massa.html",
            "review_summary" => ["rating" => 4.6, "count" => 3693],
            "price_ranges" => ["minimum" => 311, "maximum" => 406],
            "geo" => ["latitude" => 30.545134, "longitude" => -9.709875],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/26/cc/de/d6/white-beach-resort-taghazout.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Barcelo Palmeraie Oasis Resort",
            "key" => "g293730-d16541118",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d16541118-Reviews-Barcelo_Palmeraie_Oasis_Resort-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.4, "count" => 2440],
            "price_ranges" => ["minimum" => 156, "maximum" => 340],
            "geo" => ["latitude" => 31.66131, "longitude" => -7.933358],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/16/70/a0/07/barcelo-palmeraie.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Riad Melhoun & Spa",
            "key" => "g293730-d3188775",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d3188775-Reviews-Riad_Melhoun_Spa-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 5.0, "count" => 1262],
            "price_ranges" => ["minimum" => 210, "maximum" => 1131],
            "geo" => ["latitude" => 31.622114, "longitude" => -7.983171],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/31/e8/8c/bc/caption.jpg",
            "merchandising_labels" => ["Breakfast included"],
        ],
        [
            "name" => "Be Live Collection Marrakech Adults Only",
            "key" => "g293730-d12199882",
            "accommodation_type" => "Hotel",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g293734-d12199882-Reviews-Be_Live_Collection_Marrakech_Adults_Only-Marrakech_Marrakech_Safi.html",
            "review_summary" => ["rating" => 4.6, "count" => 5585],
            "price_ranges" => ["minimum" => 251, "maximum" => 485],
            "geo" => ["latitude" => 31.651258, "longitude" => -7.921565],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/12/98/d0/c2/be-live-collection-marrakech.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
        [
            "name" => "Mazagan Beach & Golf Resort",
            "key" => "g293730-d1532223",
            "accommodation_type" => "Resort",
            "url" =>
                "https://www.tripadvisor.com/Hotel_Review-g298348-d1532223-Reviews-Mazagan_Beach_Golf_Resort-El_Jadida_Casablanca_Settat.html",
            "review_summary" => ["rating" => 4.3, "count" => 2568],
            "price_ranges" => ["minimum" => 216, "maximum" => 444],
            "geo" => ["latitude" => 33.28158, "longitude" => -8.383841],
            "image" =>
                "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/30/f7/36/0d/resort-overview.jpg",
            "merchandising_labels" => ["All inclusive", "Breakfast included"],
        ],
    ];

    public function index()
    {
        return view("hotels.index");
    }

    public function list(Request $request)
    {
        $offset = max(0, (int) $request->query("offset", 0));
        $limit = min(100, max(1, (int) $request->query("limit", 30)));
        $sort = $request->query("sort", "best_value");

        $all = $this->HOTELS;

        // Apply sort
        usort($all, function ($a, $b) use ($sort) {
            if ($sort === "popularity") {
                return $b["review_summary"]["count"] <=>
                    $a["review_summary"]["count"];
            }
            // best_value: highest rating first, then most reviews
            if (
                $a["review_summary"]["rating"] !==
                $b["review_summary"]["rating"]
            ) {
                return $b["review_summary"]["rating"] <=>
                    $a["review_summary"]["rating"];
            }
            return $b["review_summary"]["count"] <=>
                $a["review_summary"]["count"];
        });

        $total = count($all);
        $paged = array_slice($all, $offset, $limit);

        return response()->json([
            "error" => null,
            "result" => [
                "total_count" => $total,
                "limit" => $limit,
                "offset" => $offset,
                "list" => array_values($paged),
            ],
        ]);
    }
}
