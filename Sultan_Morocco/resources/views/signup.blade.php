<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Sultan Morocco</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .bg-custom-gray { background-color: #F8F6F4; }
        .bg-input { background-color: #F4F4F5; }
        .text-green-dark { color: #16643B; }
        .bg-green-primary { background-color: #21A05D; }
        .icon-color { color: #A0A0A0; }
        .bg-decorative { fill: #EBE5E0; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.02); }
        }
        @keyframes float-alt {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.01); }
        }
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-float-alt { animation: float-alt 10s ease-in-out infinite alternate; }

        .slide-up {
            opacity: 0;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-600 { animation-delay: 600ms; }
        
        /* Subtle input focus pulse */
        input:focus {
            box-shadow: 0 0 0 4px rgba(33, 160, 93, 0.15);
        }
    </style>
</head>
<body class="bg-custom-gray text-[#1B1B18] min-h-screen flex flex-col items-center justify-center relative overflow-hidden py-10">
    <!-- Decorative Background Shapes (Silhouettes) -->
    <svg class="absolute top-10 left-[-5%] w-96 h-96 opacity-60 z-0 bg-decorative pointer-events-none animate-float" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M 50 10 C 60 10, 65 30, 80 40 L 80 90 L 20 90 L 20 40 C 35 30, 40 10, 50 10 Z" />
        <path d="M 10 50 C 15 50, 18 60, 25 65 L 25 90 L 5 90 L 5 65 C 12 60, 15 50, 10 50 Z" />
        <path d="M 90 50 C 85 50, 82 60, 75 65 L 75 90 L 95 90 L 95 65 C 88 60, 85 50, 90 50 Z" />
    </svg>

    <svg class="absolute bottom-[20%] right-[-5%] w-[500px] h-[400px] opacity-60 z-0 bg-decorative pointer-events-none animate-float-alt" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M 15 30 L 25 30 L 25 40 L 35 40 L 35 30 L 45 30 L 45 40 L 55 40 L 55 30 L 65 30 L 65 40 L 75 40 L 75 30 L 85 30 L 85 90 L 15 90 Z" />
        <rect x="25" y="60" width="10" height="15" />
        <rect x="65" y="60" width="10" height="15" />
        <path d="M 40 90 L 40 75 C 40 70, 60 70, 60 75 L 60 90 Z" fill="#F8F6F4" />
    </svg>

    <!-- Main Card -->
    <main class="relative z-10 w-full max-w-[460px] bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.06)] px-10 pt-12 pb-10 slide-up">
        <div class="text-center mb-8 slide-up delay-100">
            <h1 class="font-serif italic text-[26px] text-green-dark mb-3 tracking-wide hover:scale-105 transition-transform duration-500 cursor-default">Sultan Morocco</h1>
            <h2 class="text-2xl font-bold mb-2">Create Your Account</h2>
            <p class="text-gray-500 text-[13px] leading-relaxed max-w-[280px] mx-auto">Join Sultan Morocco and start exploring the hidden gems of the kingdom.</p>
        </div>

        <form action="{{ route('signup') }}" method="POST">
            @csrf
            <div class="mb-5 relative slide-up delay-200">
                <label for="name" class="block text-[10px] uppercase tracking-wider text-gray-700 font-bold mb-2 ml-4">Full Name</label>
                <div class="relative group">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full h-[52px] bg-input rounded-full px-5 pr-12 text-sm outline-none transition-all duration-300 font-medium text-gray-700 hover:bg-gray-200/50 placeholder-gray-400 @error('name') border-red-500 ring-2 ring-red-500/50 @enderror" placeholder="Jamal Al-Fassi" required>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-colors group-hover:text-gray-500">
                        <!-- User SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-2 ml-4 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 relative slide-up delay-300">
                <label for="email" class="block text-[10px] uppercase tracking-wider text-gray-700 font-bold mb-2 ml-4">Email Address</label>
                <div class="relative group">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full h-[52px] bg-input rounded-full px-5 pr-12 text-sm outline-none transition-all duration-300 font-medium text-gray-700 hover:bg-gray-200/50 placeholder-gray-400 @error('email') border-red-500 ring-2 ring-red-500/50 @enderror" placeholder="jamal@atlas.com" required>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-colors group-hover:text-gray-500">
                        <!-- Envelope / Mail SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-2 ml-4 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mb-6 slide-up delay-400">
                <div class="flex-1 relative">
                    <label for="password" class="block text-[10px] uppercase tracking-wider text-gray-700 font-bold mb-2 ml-4">Password</label>
                    <div class="relative group">
                        <input type="password" id="password" name="password" class="w-full h-[52px] bg-input rounded-full px-5 pr-10 text-sm outline-none tracking-widest transition-all duration-300 font-bold text-gray-700 hover:bg-gray-200/50 placeholder-gray-400 @error('password') border-red-500 ring-2 ring-red-500/50 @enderror" placeholder="••••••••" required>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-colors group-hover:text-gray-500">
                            <!-- Lock SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2 ml-4 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex-1 relative">
                    <label for="confirm_password" class="block text-[10px] uppercase tracking-wider text-gray-700 font-bold mb-2 ml-4">Confirm Password</label>
                    <div class="relative group">
                        <input type="password" id="confirm_password" name="confirm_password" class="w-full h-[52px] bg-input rounded-full px-5 pr-10 text-sm outline-none tracking-widest transition-all duration-300 font-bold text-gray-700 hover:bg-gray-200/50 placeholder-gray-400" placeholder="••••••••" required>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-colors group-hover:text-gray-500">
                            <!-- Shield Check SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6 ml-2 flex items-start gap-2 slide-up delay-500">
                <input type="checkbox" id="terms" class="mt-[2px] w-[14px] h-[14px] text-green-primary border-gray-300 rounded focus:ring-green-primary cursor-pointer transition-transform hover:scale-110">
                <label for="terms" class="text-[12px] text-gray-600">
                    I agree to the <a href="#" class="text-green-dark font-semibold hover:text-emerald-500 transition-colors hover:underline">Terms of Service</a> and <a href="#" class="text-green-dark font-semibold hover:text-emerald-500 transition-colors hover:underline">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="w-full h-[52px] bg-green-primary hover:bg-green-600 active:bg-green-700 text-white font-semibold rounded-full shadow-[0_4px_14px_rgba(33,160,93,0.3)] hover:shadow-[0_8px_24px_rgba(33,160,93,0.4)] hover:-translate-y-[2px] active:translate-y-0 transition-all duration-300 flex justify-center items-center gap-2 slide-up delay-500 group">
                Signup
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 transition-transform group-hover:translate-x-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </form>

        <div class="mt-8 flex items-center justify-center relative slide-up delay-600">
            <hr class="w-full border-gray-100">
            <span class="absolute px-4 bg-white text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Or sign up with</span>
        </div>

        <div class="mt-8 flex gap-4 slide-up delay-600">
            <button class="flex-1 flex items-center justify-center gap-2 h-[48px] bg-input hover:bg-gray-200 active:bg-gray-300 rounded-[28px] text-sm font-semibold text-gray-700 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <!-- Google Icon -->
                <svg viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                    <path d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5,16.25 5,12C5,7.9 8.2,4.73 12.2,4.73C15.29,4.73 17.1,6.7 17.1,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" fill="#4285F4"/>
                    <path d="M12.19,19.27C15.19,19.27 18.36,17.64 18.69,13.83L15.42,11.36C15.42,11.36 14.61,14.07 12.19,14.07C9.36,14.07 7.21,11.83 6.6,9.83L3.89,11.96C4.94,14.06 7.42,19.27 12.19,19.27Z" fill="#34A853"/>
                    <path d="M6.6,9.83C6.3,8.96 6.3,8.08 6.6,7.21L3.89,5.08C3.89,5.08 2.89,7.18 2.89,9.45C2.89,10.66 3.19,11.96 3.89,11.96L6.6,9.83Z" fill="#FBBC05"/>
                    <path d="M12.2,4.73C14.15,4.73 15.68,5.55 17.1,6.7L19,4.72C17.58,3.31 15.42,2 12.1,2C7.42,2 4.94,5.2 3.89,7.2L6.6,9.33C7.21,7.33 9.36,4.73 12.2,4.73Z" fill="#EA4335"/>
                    </g>
                </svg>
                Google
            </button>
            <button class="flex-1 flex items-center justify-center gap-2 h-[48px] bg-input hover:bg-gray-200 active:bg-gray-300 rounded-[28px] text-sm font-semibold text-gray-700 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <!-- Facebook Icon -->
                <svg viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </button>
        </div>
        
    </main>
    
    <div class="bg-[#F8F6F4] -mt-8 pt-12 pb-6 px-10 rounded-b-[3rem] w-full max-w-[460px] text-center shadow-[0_10px_30px_rgba(0,0,0,0.03)] relative z-0 slide-up delay-600">
        <p class="text-sm text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="text-green-dark font-bold hover:underline">Login</a>
        </p>
    </div>

    <!-- Footer Links -->
    <div class="mt-6 flex flex-col items-center gap-6 z-10 w-full">
        <footer class="flex gap-6 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#A0A09A]">
            <a href="#" class="hover:text-green-dark transition-colors">Privacy</a>
            <span>•</span>
            <a href="#" class="hover:text-green-dark transition-colors">Terms</a>
            <span>•</span>
            <a href="#" class="hover:text-green-dark transition-colors">Contact</a>
        </footer>
        
        <p class="text-[9px] uppercase tracking-wider text-gray-400 font-semibold opacity-70">
            © 2024 Sultan Morocco. The Digital Curator.
        </p>
    </div>
</body>
</html>
