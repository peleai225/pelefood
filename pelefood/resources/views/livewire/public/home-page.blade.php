<div>
    <!-- Hero Section -->
    <section class="relative min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-red-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="text-center space-y-12">
                <!-- Main Headline -->
                <div class="space-y-8">
                    <h1 class="text-6xl lg:text-8xl font-bold text-white leading-tight animate-fade-in">
                        Accélérez votre croissance avec <span class="text-gradient animate-glow">PeleFood</span>
                    </h1>
                    
                    <p class="text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                        Accédez à des milliers de restaurants en Afrique et transformez votre établissement en plateforme digitale moderne.
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="pt-8 animate-scale-in" style="animation-delay: 0.5s;">
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center btn-primary gradient-animated text-white px-12 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-orange-500/25">
                            <span class="flex items-center relative z-10">
                                Commencer maintenant
                                <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 pt-16">
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-globe text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['restaurants']) }}+</div>
                        <div class="text-gray-400 font-medium">Restaurants</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-coins text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['users']) }}+</div>
                        <div class="text-gray-400 font-medium">Utilisateurs</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-credit-card text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['orders']) }}+</div>
                        <div class="text-gray-400 font-medium">Commandes</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-bar text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['revenue'] / 1000000) }}M+</div>
                        <div class="text-gray-400 font-medium">FCFA de CA</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom CTA Card -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-8 max-w-2xl mx-auto shadow-2xl">
                <div class="flex items-center justify-center space-x-4 text-white">
                    <i class="fas fa-lightbulb text-3xl"></i>
                    <span class="text-xl font-semibold">Intégrer une solution de GESTION RESTAURANT COMPLÈTE.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-6xl font-bold text-gray-900 mb-8">
                    Simplicité. Flexibilité. <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">Sécurité.</span>
                </h2>
            </div>
            
            <!-- Feature Cards -->
            <div class="space-y-24">
                @foreach(array_chunk($features, 2) as $chunk)
                    @foreach($chunk as $index => $feature)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center {{ $index % 2 == 1 ? 'lg:grid-flow-col-dense' : '' }}">
                            <div class="{{ $index % 2 == 1 ? 'lg:col-start-2' : '' }}">
                                <h3 class="text-4xl font-bold text-gray-900 mb-6">{{ $feature['title'] }}</h3>
                                <p class="text-xl text-gray-600 mb-8 leading-relaxed">{{ $feature['description'] }}</p>
                                
                                <div class="flex space-x-4">
                                    <a href="{{ route('register') }}" 
                                       class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-xl font-semibold hover:scale-105 transition-transform">
                                        Commencer maintenant
                                    </a>
                                    <a href="{{ route('features') }}" 
                                       class="text-gray-600 hover:text-orange-500 font-semibold flex items-center">
                                        En savoir plus
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="{{ $index % 2 == 1 ? 'lg:col-start-1' : '' }}">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl p-8 h-96 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-24 h-24 bg-gradient-to-r {{ $feature['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-6">
                                            <i class="{{ $feature['icon'] }} text-4xl text-white"></i>
                                        </div>
                                        <h4 class="text-2xl font-bold text-gray-900 mb-4">Interface Moderne</h4>
                                        <p class="text-gray-600">Gestion intuitive et efficace</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-semibold text-gray-600">Ils nous font confiance</h3>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center opacity-60">
                <!-- Logo placeholders -->
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 1</span>
                </div>
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 2</span>
                </div>
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 3</span>
                </div>
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 4</span>
                </div>
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 5</span>
                </div>
                <div class="bg-gray-200 h-16 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-semibold">LOGO 6</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Growth Section -->
    <section class="py-24 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-6xl font-bold text-white mb-8">
                    Réinventer la restauration, <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">propulser votre croissance.</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 mb-16">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">10+</div>
                    <div class="text-gray-400">pays</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">5+</div>
                    <div class="text-gray-400">devises</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['restaurants']) }}+</div>
                    <div class="text-gray-400">marchands</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">20+</div>
                    <div class="text-gray-400">moyens de paiements</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['revenue'] / 1000000000) }}M+</div>
                    <div class="text-gray-400">milliards de FCFA par mois</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['orders']) }}+</div>
                    <div class="text-gray-400">transactions sécurisées par mois</div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-orange-500 to-red-500 text-white px-12 py-5 rounded-xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    Commencer maintenant
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Ils parlent de nous</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
                        <div class="flex items-center mb-6">
                            <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                                <p class="text-gray-600 text-sm">{{ $testimonial['restaurant'] }}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">"{{ $testimonial['content'] }}"</p>
                        <div class="flex">
                            @for ($i = 0; $i < $testimonial['rating']; $i++)
                                <i class="fas fa-star text-orange-400"></i>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-5xl font-bold text-gray-900 mb-6">Prêt à vous lancer ?</h2>
            <p class="text-xl text-gray-600 mb-8">
                Créer un compte en quelques minutes et commencer à gérer votre restaurant
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center bg-gradient-to-r from-orange-500 to-red-500 text-white px-12 py-5 rounded-xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl">
                Commencer maintenant
            </a>
        </div>
    </section>
</div>