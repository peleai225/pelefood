<div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-gradient-to-br from-gray-900 via-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-6xl font-bold text-white mb-6">
                Plans <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">simples</span> et transparents
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Choisissez le plan qui correspond à votre restaurant. 
                Changez ou annulez à tout moment.
            </p>
        </div>
    </section>

    <!-- Pricing Plans -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach($pricingPlans as $plan)
                    <div class="relative bg-white p-8 rounded-2xl border border-gray-200 {{ $plan['popular'] ? 'border-orange-500 shadow-xl scale-105' : 'hover:shadow-lg' }} transition-all duration-300">
                        @if($plan['popular'])
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                    Le plus populaire
                                </span>
                            </div>
                        @endif
                        
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                            <p class="text-gray-600 mb-6">{{ $plan['description'] }}</p>
                            <div class="flex items-baseline justify-center">
                                <span class="text-5xl font-bold text-gray-900">{{ $plan['price'] }}€</span>
                                <span class="text-gray-600 ml-2">/{{ $plan['period'] }}</span>
                            </div>
                        </div>
                        
                        <ul class="space-y-4 mb-8">
                            @foreach($plan['features'] as $feature)
                                <li class="flex items-center">
                                    <i class="fas fa-check text-orange-500 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        @if($plan['name'] === 'Enterprise')
                            <a href="{{ route('contact') }}" 
                               class="w-full bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-xl font-semibold text-center block transition-colors">
                               Nous contacter
                            </a>
                        @else
                            <a href="{{ route('register') }}" 
                               class="w-full {{ $plan['popular'] ? 'bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600' : 'bg-gray-900 hover:bg-gray-800' }} text-white py-3 rounded-xl font-semibold text-center block transition-colors">
                               {{ $plan['price'] == 0 ? 'Essayer gratuitement' : 'Commencer' }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Additional Info -->
            <div class="text-center mt-16">
                <div class="bg-gray-50 rounded-2xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Essai gratuit de 14 jours
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Testez toutes les fonctionnalités sans engagement. Aucune carte de crédit requise.
                    </p>
                    <div class="flex items-center justify-center space-x-8 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Annulation à tout moment</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Support inclus</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Mises à jour gratuites</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Comparez nos plans
                </h2>
                <p class="text-xl text-gray-600">
                    Tous les détails pour faire le bon choix
                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Fonctionnalités</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Starter</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Professional</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Business</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Produits</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">20</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimités</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimités</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimités</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Commandes/mois</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">50</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimitées</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimitées</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimitées</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Restaurants</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">1</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">1</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">3</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Illimités</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Analytics</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-times text-red-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-check text-orange-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-check text-orange-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-check text-orange-500"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">API</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-times text-red-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-times text-red-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-check text-orange-500"></i>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    <i class="fas fa-check text-orange-500"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Support</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Email</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Prioritaire</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">Dédié</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">24/7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Questions fréquentes
                </h2>
                <p class="text-xl text-gray-600">
                    Tout ce que vous devez savoir sur nos tarifs
                </p>
            </div>
            
            <div class="space-y-6">
                @foreach($faqs as $index => $faq)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="open = !open" 
                                x-data="{ open: false }"
                                class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $faq['question'] }}</h3>
                            <i class="fas fa-chevron-down transition-transform duration-200" 
                               :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="px-6 pb-4 text-gray-600">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gray-900">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-white mb-6">
                Prêt à commencer ?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Choisissez votre plan et transformez votre restaurant dès aujourd'hui
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center bg-gradient-to-r from-orange-500 to-red-500 text-white px-12 py-5 rounded-xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl">
                Commencer maintenant
            </a>
        </div>
    </section>
</div>