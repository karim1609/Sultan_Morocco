<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Sultan | Modern Moroccan Heritage</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0"
            rel="stylesheet"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background font-body text-on-background selection:bg-secondary-container selection:text-on-secondary-container">
        @if (session('success'))
            <div
                class="fixed left-1/2 top-20 z-[60] max-w-lg -translate-x-1/2 rounded-full border border-outline-variant/50 bg-surface-container-lowest/95 px-5 py-2.5 text-center text-sm font-medium text-primary shadow-lg backdrop-blur-md"
                role="status"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- Top Navigation --}}
        <nav class="fixed top-0 z-50 w-full bg-surface/80 backdrop-blur-md dark:bg-slate-950/80">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4 md:px-8">
                <a href="{{ url('/') }}" class="font-headline text-2xl font-bold text-emerald-900 dark:text-emerald-400">Sultan</a>
                <div class="hidden items-center gap-8 md:flex">
                    <a
                        class="border-b-2 border-amber-500 pb-1 font-body text-sm font-medium uppercase tracking-wider text-emerald-900 dark:text-emerald-400"
                        href="{{ url('/') }}"
                        >Home</a
                    >
                    <a
                        class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
                        href="#destinations"
                        >Explore</a
                    >
                    <a
                        class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
                        href="{{ route('map.index') }}"
                        >Map</a
                    >
                    <a
                        class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
                        href="#categories"
                        >Restaurants</a
                    >
                    <a
                        class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
                        href="{{ route('hotels.index') }}"
                        >Hotels</a
                    >
                    <a
                        class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
                        href="#experiences"
                        >Experiences</a
                    >
                </div>
                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                        <span class="hidden max-w-[10rem] truncate text-xs font-medium text-stone-600 sm:inline dark:text-stone-400">
                            Hi, {{ Auth::user()->name }}
                        </span>
                        <a
                            href="{{ route('profile', Auth::id()) }}"
                            class="hidden rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high sm:inline"
                            >Profile</a
                        >
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-stone-600 transition hover:bg-surface-container-high dark:text-stone-400"
                            >
                                Log out
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high"
                            >Log in</a
                        >
                        <a
                            href="{{ route('signup') }}"
                            class="rounded-full bg-primary px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-on-primary transition hover:opacity-90"
                            >Sign up</a
                        >
                    @endauth
                    <button type="button" class="rounded-full p-2 transition-colors hover:bg-surface-container-high" aria-label="Search">
                        <span class="material-symbols-outlined text-emerald-900 dark:text-emerald-400">search</span>
                    </button>
                    <a
                        href="{{ auth()->check() ? route('profile', auth()->id()) : route('login') }}"
                        class="rounded-full p-2 transition-colors hover:bg-surface-container-high"
                        aria-label="Account"
                    >
                        <span class="material-symbols-outlined text-emerald-900 dark:text-emerald-400">account_circle</span>
                    </a>
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <header class="relative flex h-screen items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img
                    class="h-full w-full object-cover"
                    alt="Sunset over Chefchaouen and mountains"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDiU9LRwyIbXhf7VHdpnSUHtcGGsTjmEhDK9KwzbS28j3TT6gQAyB7ZwxLn16k9mOyFORRlXsmOYTCH95MIzr0uRzy8tfAGaqYP0kTwN1Z5AGtInJ--lyzvc1Z1YUQkkbngXEwNIHgnysVDipalDxW-X6P_2lV4mynJ7mCpYyO8L5VBQ9q-mduGqM7GaSc9lSkkXZqiTosdWiq0Qn14P1RNp6i72gTlODKKsjRBdjP1_jLbbjSHEFa4ieLHSGhk-a1O94qB4919y6c"
                    fetchpriority="high"
                />
                <div class="absolute inset-0 bg-gradient-to-b from-primary/60 via-primary/20 to-background"></div>
            </div>
            <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">
                <h1 class="mb-6 font-headline text-5xl leading-tight text-white md:text-7xl lg:text-8xl">Discover the Magic of Morocco</h1>
                <p class="mx-auto mb-12 max-w-2xl font-body text-lg font-light text-white/90 md:text-xl">
                    Hidden gems, luxury stays, and unforgettable experiences curated for the modern traveler.
                </p>
                <div
                    class="mx-auto flex max-w-5xl flex-col items-center gap-3 rounded-full bg-surface-container-lowest/95 p-3 shadow-2xl backdrop-blur-sm md:flex-row md:p-4"
                >
                    <div class="flex w-full items-center gap-3 border-outline-variant/30 px-6 py-2 md:border-b-0 md:border-r">
                        <span class="material-symbols-outlined text-secondary">location_on</span>
                        <input
                            class="font-body w-full border-none bg-transparent text-on-surface placeholder:text-on-surface-variant/60 focus:ring-0"
                            type="text"
                            placeholder="Where to?"
                        />
                    </div>
                    <div class="flex w-full items-center gap-3 border-outline-variant/30 px-6 py-2 md:border-b-0 md:border-r">
                        <span class="material-symbols-outlined text-secondary">category</span>
                        <select class="font-body w-full cursor-pointer border-none bg-transparent text-on-surface focus:ring-0">
                            <option>All Categories</option>
                            <option>Luxury Riads</option>
                            <option>Desert Camps</option>
                            <option>Fine Dining</option>
                        </select>
                    </div>
                    <div class="flex w-full items-center gap-3 px-6 py-2">
                        <span class="material-symbols-outlined text-secondary">payments</span>
                        <select class="font-body w-full cursor-pointer border-none bg-transparent text-on-surface focus:ring-0">
                            <option>Price Range</option>
                            <option>$ - Budget</option>
                            <option>$$ - Moderate</option>
                            <option>$$$ - Luxury</option>
                        </select>
                    </div>
                    <a
                        href="{{ auth()->check() ? route('profile', auth()->id()) : route('signup') }}"
                        class="font-body w-full rounded-full bg-gradient-to-br from-primary to-primary-container px-10 py-4 text-sm font-bold uppercase tracking-widest text-white transition-transform hover:scale-[0.98] md:w-auto"
                    >
                        Explore Now
                    </a>
                </div>
            </div>
            <div class="absolute bottom-10 left-1/2 flex -translate-x-1/2 animate-bounce flex-col items-center">
                <span class="mb-2 font-body text-xs uppercase tracking-widest text-white/60">Scroll</span>
                <span class="material-symbols-outlined text-white">keyboard_arrow_down</span>
            </div>
        </header>

        <main class="space-y-32 py-32">
            {{-- Featured Destinations --}}
            <section id="destinations" class="mx-auto max-w-7xl px-8">
                <div class="mb-12 flex items-end justify-between">
                    <div>
                        <span class="mb-4 block font-body text-xs font-bold uppercase tracking-[0.2rem] text-secondary">Selected Regions</span>
                        <h2 class="font-headline text-4xl text-on-surface md:text-5xl">Top Destinations</h2>
                    </div>
                    <button
                        type="button"
                        class="hidden border-b-2 border-secondary pb-1 font-body font-bold text-primary transition-colors hover:text-secondary md:block"
                    >
                        View All Regions
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
                    <div
                        class="group relative aspect-[16/10] cursor-pointer overflow-hidden rounded-xl bg-surface-container-low md:col-span-8 md:aspect-auto md:h-[500px]"
                    >
                        <img
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            alt="Courtyard of a Moroccan riad in Marrakech"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9__zftsu2VrpDdniBahUGwzkbBtcuYoO7XOGwGG_rmn0EHRT1h46zyiml7OzXfS2pCRuIXElrAVK071acmCemF2LN6-TUX7mJCf-D7zLVVqOlM5RxweuZcVauiltUvfBEQq9wNr8usHNublcpj3seyNqwdBlrXG4PYLBfYTRFW6UqMyArf-zeyZjXXq4mG4H8SLrlAZ1r3FIZSfKcF_xB3eV6LIaNZ0KW1r0aZ6CH7IWaWq7pQVbK9zJVnZBIWcbmBTUwEdhUUvs"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-10 left-10 text-white">
                            <h3 class="font-headline mb-2 text-4xl">Marrakech</h3>
                            <p class="font-body max-w-md text-white/80">The vibrant heart of Morocco, where ancient tradition meets contemporary luxury.</p>
                        </div>
                    </div>
                    <div class="grid grid-rows-2 gap-8 md:col-span-4">
                        <div class="group relative cursor-pointer overflow-hidden rounded-xl bg-surface-container-low">
                            <img
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="Zellige tiles in Fes"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkKaWsW4XXRStgIZlBuAgXpginMNRAxGFmiY-WskFaiYGc2tFt_PS0BoNdVo3VCVO1gwyJ0yAthtgxjzHnjfPY1CZqOu18iVSGDyKyu-iaiMmIya7zeUbwyhZ_wPu4WfwGC3cuTN7ql_XqscU9lCRMVfDC4C7g-3h42OWlKgsKinCw80Oq8i__9Aah1mS6OYEMwv0KVTK2OfWgJs8Mc21QJ9IdSCf6YW_Vv0SgKjV3ybEx5XSUr4cWx4DV3W-EYbE3llWGcHGPP10"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="font-headline text-2xl">Fes</h3>
                                <p class="text-sm text-white/80">The spiritual and cultural capital.</p>
                            </div>
                        </div>
                        <div class="group relative cursor-pointer overflow-hidden rounded-xl bg-surface-container-low">
                            <img
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="Casablanca architecture"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBX160KMC73qk3x6-JZIJrDEoaRr-dUvyZh9zPZq1nRoPPqiGxY4PmKjeQ-TcOrK3qOuMHyHowJZMUt1paWLI9I7ZkVTEy5Yz-z_OwwCM9Sm49CKERBwfsSyxUUgwlOtkbA1aBQoOdp6ACQ98-ZbtoMraEaEl1buM9SoVrQNGlsG_900Dwj04MJ9butVwXA3rDRtn3DCsC2t1oZnCKTQbvcqrYfBoEF_vdmMpjNdGavgBThEl6oE2TRIxTHEtkqFUcdxpJdxKVh-8g"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="font-headline text-2xl">Casablanca</h3>
                                <p class="text-sm text-white/80">Modern Morocco by the Atlantic coast.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Categories --}}
            <section id="categories" class="bg-surface-container-low py-24">
                <div class="mx-auto max-w-7xl px-8">
                    <div class="mb-16 text-center">
                        <h2 class="font-headline mb-4 text-4xl text-on-surface">Explore by Category</h2>
                        <p class="mx-auto max-w-xl text-on-surface-variant">
                            Everything you need for an immersive Moroccan experience, from boutique hotels to hidden cafes.
                        </p>
                    </div>
                    <div class="no-scrollbar flex snap-x gap-6 overflow-x-auto pb-8">
                        @foreach (
                            [
                                ['icon' => 'restaurant', 'label' => 'Restaurants'],
                                ['icon' => 'hotel', 'label' => 'Hotels'],
                                ['icon' => 'coffee', 'label' => 'Cafés'],
                                ['icon' => 'museum', 'label' => 'Attractions'],
                                ['icon' => 'nightlife', 'label' => 'Nightlife'],
                                ['icon' => 'fitness_center', 'label' => 'Gyms'],
                            ] as $cat
                        )
                            <div
                                class="group flex aspect-square w-48 shrink-0 snap-center cursor-pointer flex-col items-center justify-center gap-4 rounded-xl bg-surface-container-lowest shadow-sm transition-colors hover:bg-secondary-container"
                            >
                                <span class="material-symbols-outlined text-4xl text-primary group-hover:text-on-secondary-container">{{ $cat['icon'] }}</span>
                                <span class="font-body text-sm font-bold uppercase tracking-wider group-hover:text-on-secondary-container">{{ $cat['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Popular places --}}
            <section class="mx-auto max-w-7xl px-8">
                <div class="mb-12 flex items-center gap-4">
                    <h2 class="font-headline text-4xl text-on-surface">Popular Right Now</h2>
                    <span
                        class="flex items-center gap-2 rounded-full bg-tertiary-container px-4 py-1 text-xs font-bold uppercase tracking-widest text-on-tertiary-container"
                    >
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-on-tertiary-container opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-on-tertiary-container"></span>
                        </span>
                        Trending
                    </span>
                </div>
                <div class="no-scrollbar flex gap-8 overflow-x-auto pb-12">
                    @foreach (
                        [
                            [
                                'title' => 'La Mamounia',
                                'loc' => 'Marrakech',
                                'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCJYn0DdCHRMEYLDI6-hWSU8Atx8rfDHeQcMEVOJTGSnUKPc1IIe2HuVBGBW7rhPcpW8i-k_lx0LBp5ZRis0m36cex6HcBBSlGgpfU0poNyojOLpTHOJcBYmrVDlbP08xZfgYsB6tCFJSvnVhTUHaWmUOF51mrk0DlOVMn2voQ6WmjRPDRkz706nvxJtc8Yqg0j5B_Yyf6Nx8W1RjJRuA8g1a3yO3h84Z9OuV1F17MOoCO4-9fUCwFi1JS7QnDQnYgNTRTwTQF-5tA',
                                'alt' => 'Pool at La Mamounia',
                                'rating' => '4.9',
                                'price' => '$$$$',
                            ],
                            [
                                'title' => 'Nomad Restaurant',
                                'loc' => 'Medina Rooftop',
                                'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCc9rHP_A_4HiiNCh9Ut2OkLOIBxbl5krvG-ppUU_vtYGwtefohEOf2QP8cyvIMLXUl_O3-VqC3C6sebaxxXn-EZeIZSk8o4EKOO_vlewWKtY1VGsRkPtgm3aahZTiZCs3r3ZstU-kotC5AgFm6qqk-2X6cQFXPDi3h6cfFVvIqfM98v0VvOGWY-m5ZjIhfAsuCHtAABaoFePNkbcf6uf-rcV3z6cqMr2uCsULGaU-sH9WNyDO0Hbn-DOd2aL7pj0wD43JIXEEiVbQ',
                                'alt' => 'Nomad restaurant interior',
                                'rating' => '4.7',
                                'price' => '$$$',
                            ],
                            [
                                'title' => 'Le Jardin Secret',
                                'loc' => 'Marrakech',
                                'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAgTxrsTaYajlmKpdvYJTJs2kZ_krmUGEmSnI49TT4tjqZ1ecH1Yd9QAwXQcTnGB2LVzkvYx656UeAXY0LzKE0c_RuVGMBceCIOtWM5yOhX-FmmxMiOR1-5RqdoYA6EzJeLNbwN3OpyDwVi_Feqb-fvL0eej6BTnfqhRxtxNF8d7wRYRJeIb2r30D34oaTzVe6hEH_lNeCJRHgrBlSbMpKjXayPnQFmzGMT8BYPGLL59RzoaIbCTWx0EDvhR-UNNgV5Hr8cZFbF8wk',
                                'alt' => 'Moroccan market carpets',
                                'rating' => '4.8',
                                'price' => '$$',
                            ],
                        ] as $place
                    )
                        <div class="group min-w-[350px] overflow-hidden rounded-xl bg-surface-container-lowest transition-all duration-500 hover:shadow-2xl">
                            <div class="relative h-64">
                                <img class="h-full w-full object-cover" src="{{ $place['img'] }}" alt="{{ $place['alt'] }}" loading="lazy" />
                                <button
                                    type="button"
                                    class="absolute right-4 top-4 rounded-full bg-white/20 p-2 text-white backdrop-blur-md transition-colors hover:bg-white hover:text-primary"
                                    aria-label="Save"
                                >
                                    <span class="material-symbols-outlined">favorite</span>
                                </button>
                            </div>
                            <div class="p-8">
                                <div class="mb-4 flex items-start justify-between">
                                    <div>
                                        <h3 class="font-headline mb-1 text-2xl text-on-surface">{{ $place['title'] }}</h3>
                                        <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            {{ $place['loc'] }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="flex items-center gap-1 font-bold text-secondary">
                                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1">star</span>
                                            {{ $place['rating'] }}
                                        </div>
                                        <div class="text-lg font-bold text-emerald-900">{{ $place['price'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Map --}}
            <section id="map" class="mx-auto max-w-7xl px-8">
                <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-12">
                    <div class="lg:col-span-4">
                        <h2 class="font-headline mb-6 text-4xl text-on-surface">Explore on the Map</h2>
                        <p class="mb-8 leading-relaxed text-on-surface-variant">
                            Find luxury stays and fine dining near you. Use our interactive map to discover hidden riads and artisan shops that do not appear in every guidebook.
                        </p>
                        <button
                            type="button"
                            class="flex items-center gap-3 rounded-full bg-primary px-8 py-4 font-body text-sm font-bold uppercase tracking-widest text-on-primary transition-all hover:bg-primary-container"
                        >
                            <span class="material-symbols-outlined">map</span>
                            Open Full Map
                        </button>
                    </div>
                    <div class="group relative h-[500px] overflow-hidden rounded-[3rem] bg-surface-container-highest shadow-lg lg:col-span-8">
                        <div
                            class="absolute inset-0 opacity-70 contrast-125 grayscale transition-all duration-1000 group-hover:opacity-100 group-hover:grayscale-0"
                        >
                            <img
                                class="h-full w-full object-cover"
                                alt="Stylized map texture"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzHcqmL_Ddugq_ePyltiGOhwDcbHa_ULbnEiSXng0polnkOTY70DkeHLqLtkkEmj9GNjDKcV4PxqphpDhcnXvLXjRKrj_mUAWcifjOtupKIAyg3SEBrMQBcibPBzDiJ2gGpISYpXqp0FU4lGVIn1rsUSlCA0UMrw-aEm_SH-bn7frgX3UB_1SJIkAn3wZliiY98posjnyuY_9jViuZqzRMthhM1SMpVEvpnFY4IsNOihZJneASrFdjanTNQWt7cb7L_Y_mxao3qDs"
                                loading="lazy"
                            />
                        </div>
                        <div class="absolute left-1/3 top-1/4 flex animate-pulse items-center justify-center rounded-full bg-primary p-3 text-white shadow-2xl">
                            <span class="material-symbols-outlined">bed</span>
                        </div>
                        <div class="absolute right-1/4 top-1/2 flex animate-bounce items-center justify-center rounded-full bg-secondary p-3 text-white shadow-2xl">
                            <span class="material-symbols-outlined">restaurant</span>
                        </div>
                        <div
                            class="absolute bottom-1/4 left-1/2 flex items-center justify-center rounded-full bg-tertiary-fixed-dim p-3 text-on-tertiary-fixed-variant shadow-2xl"
                        >
                            <span class="material-symbols-outlined">auto_awesome</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Experiences --}}
            <section id="experiences" class="bg-primary-container py-32 text-white">
                <div class="mx-auto max-w-7xl px-8">
                    <div class="mb-20 text-center lg:text-left">
                        <h2 class="font-headline mb-6 text-4xl md:text-5xl">Unique Experiences</h2>
                        <p class="max-w-2xl text-lg font-light text-on-primary-container">
                            Go beyond sightseeing with curated moments designed by local heritage experts.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                        @foreach (
                            [
                                [
                                    'title' => 'Sahara Sunset',
                                    'desc' => 'Luxury glamping under the stars in the heart of the Erg Chebbi dunes.',
                                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDB_Id9gwHAEzKTNWmd1B8Ud2kCMaoKHtI0AwtY3rypUVKewgOynZBnSCjDu6bPGWT44VtQPAR5GV-Ym-sfbyI9GHMWVWEXKWJS7igZBKmC3JgqNdcLYpMw79erfL0cFO1nUaUfiKyfcjTsChPWBppTY-rsYvQA06aiPI11OzYZwNtCCdXvxCMbIMiQSDehesvi0T2RdjSI-jnFmt8XbXlDz9fHBhhSXVoma8abvW0UOL0Ji2eisuTRnc6Pn4yRdyJ_eqNhUdNxVKs',
                                    'alt' => 'Sahara dunes',
                                    'offset' => '',
                                ],
                                [
                                    'title' => 'Master Class',
                                    'desc' => 'Learn the secrets of Moroccan spices with a Michelin-starred chef.',
                                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDvq5BokWPr3OqGVWu2Cd9Yb5Q7oepiVjK8qb-0qZ6JFi3ZGep_qZTAjWmnHfeSLhTzDJ4Jcu-NnqUWu-MRrhgjx37-AYVRJxzYlGPV1-UAkdwJrS0HmFwqwz1-ZaPOF3u5vuzjF1jqCqxPTmyd3esuTY9aELKzt3iClB_m0mn8ZC2l88xJf59Xa3MW6yHj09gyxLAsa1hWDjxKPn5V_obuT8JiujNLbDkpGzHv85PSbDcF_KZfy9JlyVCYexJw13a0LrRPPfOleeo',
                                    'alt' => 'Moroccan tagine',
                                    'offset' => 'lg:mt-16',
                                ],
                                [
                                    'title' => 'Atlantic Surf',
                                    'desc' => 'Ride the waves of Taghazout with private coaching and oceanfront suites.',
                                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDswRYQoWXgXAW6AhjrKZeB_YyW42BJyCJALJckzstKhRmnHAVNSjJ3Vi_gVIbtNuip1pmq63XGzJWjDkR_UwfO9nInyXKPirptUFgzBLhG0ApV8F7bPSqBZeEqDW32yhhIjx59B6liVE17qtOBAx8wpPj-BBK_QhSzUIBbhxOfXnUaiioAJxGypKh_d8udZyB2wRcyy4kYqRQAnJ5V2ntaRP_nK-2i31l0xPSxSQIZ_cq9y0fgfIfkiJ27GiZtnw5xXXN7oAur3AY',
                                    'alt' => 'Atlantic coast',
                                    'offset' => '',
                                ],
                                [
                                    'title' => 'Camel Trek',
                                    'desc' => 'Discover ancient caravan routes through the Atlas Mountains.',
                                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBX9pNpgoZ6fCf4wd_u5h8Y9FKUQSD7FDRubx4gdouxFv280xFOc0dHhP1q_S8aBPQTwAdmyWYy1x_iM-nC8H5q0h70jsA5yQnfgdh6akYTZ6b1tuwS99tS6Ft1Vge6uzB826kELaERYMNQcQP3hZwTLWNqikJkWYI4s_CADvPHTEBBD4umQEQQPvuj7keVazkfAb7iPA1uQ_Rkh1LcCp_Q5b14UzGGSJM1OdfmWp92A6mtjsBC2i0lz8mPtBBnOVph1EATJfqajoo',
                                    'alt' => 'Camels in the desert',
                                    'offset' => 'lg:mt-16',
                                ],
                            ] as $exp
                        )
                            <div class="group flex cursor-pointer flex-col gap-6 {{ $exp['offset'] }}">
                                <div class="aspect-[3/4] overflow-hidden rounded-t-[5rem]">
                                    <img
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        src="{{ $exp['img'] }}"
                                        alt="{{ $exp['alt'] }}"
                                        loading="lazy"
                                    />
                                </div>
                                <div>
                                    <h4 class="font-headline mb-2 text-2xl">{{ $exp['title'] }}</h4>
                                    <p class="text-sm leading-relaxed text-on-primary-container">{{ $exp['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Why Sultan --}}
            <section class="mx-auto max-w-7xl px-8">
                <div class="mb-20 text-center">
                    <span class="mb-4 block font-body text-xs font-bold uppercase tracking-widest text-secondary">The Sultan Promise</span>
                    <h2 class="font-headline text-4xl text-on-surface md:text-5xl">Why Sultan?</h2>
                </div>
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
                    @foreach (
                        [
                            ['icon' => 'verified_user', 'title' => 'Verified Places', 'text' => 'Every riad and restaurant is personally vetted for quality and authenticity.'],
                            ['icon' => 'lightbulb', 'title' => 'Local Insights', 'text' => 'Stories and tips only known to those who call Morocco home.'],
                            ['icon' => 'person_pin', 'title' => 'Personalized', 'text' => 'Recommendations that adapt to your travel style and preferences.'],
                            ['icon' => 'workspace_premium', 'title' => 'Premium', 'text' => 'Seamless luxury from arrival to departure.'],
                        ] as $why
                    )
                        <div class="space-y-6 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-surface-container-low text-secondary">
                                <span class="material-symbols-outlined text-4xl">{{ $why['icon'] }}</span>
                            </div>
                            <h3 class="font-headline text-xl">{{ $why['title'] }}</h3>
                            <p class="text-sm leading-relaxed text-on-surface-variant">{{ $why['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Testimonial --}}
            <section class="mx-auto max-w-5xl px-8">
                <div class="relative overflow-hidden rounded-[4rem] bg-surface-container-low p-12 text-center md:p-20">
                    <span class="material-symbols-outlined absolute -left-4 -top-4 text-on-surface/5" style="font-size: 9rem">format_quote</span>
                    <div class="relative z-10">
                        <h2 class="font-headline mb-12 text-3xl">What Travelers Say</h2>
                        <div class="space-y-8">
                            <p class="font-headline text-xl italic leading-relaxed text-on-surface md:text-2xl">
                                "Sultan transformed our trip from a simple vacation into a deep cultural immersion. The hidden riad they recommended in Fes was the highlight of our entire year."
                            </p>
                            <div class="flex flex-col items-center gap-4">
                                <div class="h-20 w-20 overflow-hidden rounded-full border-4 border-white shadow-xl">
                                    <img
                                        class="h-full w-full object-cover"
                                        alt="Traveler portrait"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPRFfkhnqOAwiYuiq1W0UiKkXneeUPPytMdhfiKPhvE2W_q5MuSu5Ywig5DJwCMNeyF1pNbNCodiSA7PF5FkFqjLtjG2NP7Ihs78F4BisChTwPVjIjamYvjwIlIBNRfxpJfTZ-w2G9omYcfQw8HJhH0GRFUHuG1-TX7Fd3OVYeDl8UnN_csAnf97Nox_eWV4_cB6_8EdSDEpcLXKW4qcqgNzyjoTyxAY8_Kg5bxPIk9gYanqx1l9kgcu4jrQA0TCvB0YFYjA-bTVE"
                                        loading="lazy"
                                    />
                                </div>
                                <div>
                                    <div class="font-bold text-on-surface">Sarah J. Montgomery</div>
                                    <div class="mt-1 font-body text-sm uppercase tracking-widest text-on-surface-variant">Condé Nast Traveler</div>
                                </div>
                                <div class="flex gap-1 text-secondary">
                                    @for ($i = 0; $i < 5; $i++)
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1">star</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA --}}
            <section class="mx-auto max-w-7xl px-8 pb-32">
                <div class="relative overflow-hidden rounded-[3rem] bg-gradient-to-br from-primary via-primary-container to-emerald-800 p-16 text-center md:p-24">
                    <div
                        class="pointer-events-none absolute inset-0 opacity-10"
                        style="background-image: url('https://www.transparenttextures.com/patterns/zellige.png')"
                    ></div>
                    <div class="relative z-10">
                        <h2 class="font-headline mb-8 text-4xl text-white md:text-6xl">Start Your Journey Today</h2>
                        <p class="mx-auto mb-12 max-w-xl text-lg text-white/80">
                            Join travelers discovering the true soul of Morocco with Sultan.
                        </p>
                        <a
                            href="{{ auth()->check() ? route('profile', auth()->id()) : route('signup') }}"
                            class="inline-block rounded-full bg-secondary px-12 py-5 font-body text-sm font-bold uppercase tracking-widest text-on-secondary-fixed transition-transform hover:scale-105"
                        >
                            Get Started
                        </a>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
        <footer class="bg-emerald-950 pb-12 pt-24 text-white dark:bg-black">
            <div class="mx-auto mb-16 grid max-w-7xl grid-cols-1 gap-16 px-8 md:grid-cols-12">
                <div class="md:col-span-4">
                    <div class="mb-6 font-headline text-3xl text-white">Sultan</div>
                    <p class="font-body leading-relaxed text-stone-400">
                        The Modern Heritage Curator. Preserving and presenting the finest aspects of Moroccan lifestyle and luxury travel.
                    </p>
                </div>
                <div class="space-y-6 md:col-span-2">
                    <h4 class="font-body text-sm font-bold uppercase tracking-widest text-amber-500">Links</h4>
                    <nav class="flex flex-col gap-4">
                        <a class="text-stone-400 transition-colors hover:text-white" href="#">About</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#">Contact</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#">Privacy</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#">Terms</a>
                    </nav>
                </div>
                <div class="space-y-6 md:col-span-2">
                    <h4 class="font-body text-sm font-bold uppercase tracking-widest text-amber-500">Discover</h4>
                    <nav class="flex flex-col gap-4">
                        <a class="text-stone-400 transition-colors hover:text-white" href="#destinations">Marrakech</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#destinations">Casablanca</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#experiences">Sahara</a>
                        <a class="text-stone-400 transition-colors hover:text-white" href="#destinations">Chefchaouen</a>
                    </nav>
                </div>
                <div class="space-y-6 md:col-span-4">
                    <h4 class="font-body text-sm font-bold uppercase tracking-widest text-amber-500">Newsletter</h4>
                    <div class="flex gap-2">
                        <input
                            class="w-full rounded-full border border-white/10 bg-white/5 px-6 py-3 text-white placeholder:text-stone-500 focus:border-secondary focus:ring-secondary"
                            type="email"
                            placeholder="Your email address"
                            autocomplete="email"
                        />
                        <button type="button" class="rounded-full bg-secondary p-3 text-on-secondary-fixed transition hover:opacity-90" aria-label="Subscribe">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 border-t border-white/10 px-8 pt-8 text-sm text-stone-500 md:flex-row"
            >
                <span>© {{ date('Y') }} Sultan. The Modern Heritage Curator.</span>
                <div class="flex gap-6">
                    <a class="transition-colors hover:text-amber-500" href="#">Instagram</a>
                    <a class="transition-colors hover:text-amber-500" href="#">Pinterest</a>
                    <a class="transition-colors hover:text-amber-500" href="#">Twitter</a>
                </div>
            </div>
        </footer>
    </body>
</html>
