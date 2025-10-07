<div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-gradient-to-br from-gray-900 via-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-6xl font-bold text-white mb-6">
                Fonctionnalités <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">complètes</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Découvrez toutes les fonctionnalités qui font de PeleFood la solution idéale 
                pour gérer votre restaurant efficacement.
            </p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-6xl font-bold text-gray-900 mb-8">
                    Simplicité. Flexibilité. <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">Sécurité.</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une plateforme pensée pour les restaurateurs, par des restaurateurs
                </p>
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
                                    <a href="{{ route('contact') }}" 
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

    <!-- Why Choose PeleFood -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Pourquoi choisir PeleFood ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une plateforme pensée pour les restaurateurs, par des restaurateurs
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-rocket text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mise en route rapide</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Configurez votre restaurant en 5 minutes et commencez à recevoir des commandes instantanément. 
                        Aucune compétence technique requise.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sécurité garantie</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Infrastructure cloud sécurisée avec chiffrement SSL, sauvegardes automatiques 
                        et conformité aux standards de sécurité internationaux.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Support expert</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Équipe de support dédiée disponible 24/7 pour vous accompagner dans votre 
                        transformation digitale et optimiser vos résultats.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Des résultats concrets
                </h2>
                <p class="text-xl text-gray-600">
                    Nos clients voient des améliorations immédiates
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-500 mb-2">250%</div>
                    <div class="text-gray-600 font-medium">Augmentation moyenne des ventes</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-500 mb-2">85%</div>
                    <div class="text-gray-600 font-medium">Réduction des erreurs de commande</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-green-500 mb-2">5min</div>
                    <div class="text-gray-600 font-medium">Temps de configuration moyen</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-purple-500 mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Disponibilité de la plateforme</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Integration Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Intégrations puissantes
                </h2>
                <p class="text-xl text-gray-600">
                    Connectez PeleFood à vos outils existants
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-stripe text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Stripe</h3>
                    <p class="text-sm text-gray-600">Paiements en ligne</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-whatsapp text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">WhatsApp</h3>
                    <p class="text-sm text-gray-600">Notifications clients</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-google text-2xl text-red-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Google Analytics</h3>
                    <p class="text-sm text-gray-600">Analytics avancés</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Mobile Money</h3>
                    <p class="text-sm text-gray-600">Paiements mobiles</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-orange-500 to-red-500">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-white mb-6">
                Prêt à découvrir PeleFood ?
            </h2>
            <p class="text-xl text-orange-100 mb-8">
                Commencez votre essai gratuit et transformez votre restaurant dès aujourd'hui
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-colors">
                   Commencer gratuitement
                </a>
                <a href="{{ route('contact') }}" 
                   class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-orange-600 transition-colors">
                   Demander une démo
                </a>
            </div>
        </div>
    </section>
</div>