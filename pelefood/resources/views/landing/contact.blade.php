@extends('layouts.app')

@section('title', 'Contact - PeleFood')

@section('content')
<!-- Hero Section Contact -->
<div class="relative min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-gradient-to-br from-orange-300 to-red-300 rounded-full opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20">
        <div class="text-center space-y-16">
            <!-- Badge de statut -->
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500/20 to-yellow-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
                    Contactez-nous
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="space-y-10 animate-fade-in-left">
                <h1 class="text-6xl lg:text-7xl font-black text-white leading-tight">
                    <span class="block">Parlons de votre</span>
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">projet</span>
                </h1>

                <p class="text-slate-100 max-w-4xl mx-auto leading-relaxed text-xl">
                    Notre équipe est là pour vous accompagner dans la digitalisation de votre restaurant.
                    <span class="font-semibold text-orange-300">Contactez-nous pour une démonstration personnalisée.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Section Formulaire de Contact -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Formulaire -->
            <div class="animate-fade-in-left">
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100">
                    <div class="mb-8">
                        <h2 class="text-3xl font-black text-gray-900 mb-4">
                            <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                                Envoyez-nous un message
                            </span>
                        </h2>
                        <p class="text-gray-600">Remplissez le formulaire ci-dessous et nous vous répondrons dans les 24h</p>
                    </div>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                                <input type="text" id="first_name" name="first_name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                       placeholder="Votre prénom">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                                <input type="text" id="last_name" name="last_name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                       placeholder="Votre nom">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                   placeholder="votre@email.com">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                   placeholder="+221 XX XXX XX XX">
                        </div>
                        
                        <div>
                            <label for="restaurant_name" class="block text-sm font-semibold text-gray-700 mb-2">Nom du restaurant</label>
                            <input type="text" id="restaurant_name" name="restaurant_name" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                   placeholder="Le nom de votre restaurant">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Sujet</label>
                            <select id="subject" name="subject" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300">
                                <option value="">Sélectionnez un sujet</option>
                                <option value="demo">Demande de démonstration</option>
                                <option value="pricing">Question sur les tarifs</option>
                                <option value="support">Support technique</option>
                                <option value="partnership">Partenariat</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300"
                                      placeholder="Décrivez votre projet ou votre question..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Informations de contact -->
            <div class="animate-fade-in-right">
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 mb-6">
                            <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                                Nos Coordonnées
                            </span>
                        </h2>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans votre projet.
                        </p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start space-x-4 p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">contact@pelefood.com</p>
                                <p class="text-sm text-gray-500">Réponse sous 24h</p>
                            </div>
                        </div>
                        
                        <!-- Téléphone -->
                        <div class="flex items-start space-x-4 p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Téléphone</h3>
                                <p class="text-gray-600">+221 33 XXX XX XX</p>
                                <p class="text-sm text-gray-500">Lun-Ven 9h-18h</p>
                            </div>
                        </div>
                        
                        <!-- Adresse -->
                        <div class="flex items-start space-x-4 p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-slate-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Adresse</h3>
                                <p class="text-gray-600">Dakar, Sénégal</p>
                                <p class="text-sm text-gray-500">Zone des Almadies</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Réseaux sociaux -->
                    <div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gradient-to-br from-teal-500 to-green-500 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gradient-to-br from-blue-500 to-slate-500 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section FAQ -->
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Questions Fréquentes
                </span>
            </h2>
            <p class="text-xl text-gray-600">Trouvez rapidement les réponses à vos questions</p>
        </div>
        
        <div class="space-y-8">
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Comment puis-je obtenir une démonstration ?</h3>
                <p class="text-gray-600">Remplissez le formulaire de contact ci-dessus en sélectionnant "Demande de démonstration" comme sujet. Notre équipe vous contactera dans les 24h pour planifier une démonstration personnalisée.</p>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Quel est le délai de mise en place ?</h3>
                <p class="text-gray-600">La mise en place de votre restaurant sur PeleFood prend généralement 2-3 jours ouvrables. Nous vous accompagnons tout au long du processus pour vous assurer une transition en douceur.</p>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Proposez-vous une formation ?</h3>
                <p class="text-gray-600">Oui, nous offrons une formation complète à tous nos clients, incluant des sessions en ligne et une documentation détaillée. Pour les plans Premium, nous proposons également une formation personnalisée sur site.</p>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Quel support technique offrez-vous ?</h3>
                <p class="text-gray-600">Nous offrons un support technique par email, chat en direct et téléphone selon votre plan. Notre équipe est disponible 24h/24 pour les plans Pro et Premium.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-40 h-40 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-3xl"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="animate-fade-in-up">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Prêt à commencer ?
            </div>
            
            <h2 class="text-6xl font-black text-white mb-8 leading-tight">
                <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Commencez votre essai gratuit
                </span>
                <span class="block text-4xl font-light text-orange-200 mt-2">dès maintenant</span>
            </h2>
            
            <p class="text-xl text-slate-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                14 jours d'essai gratuit, sans engagement, sans carte de crédit
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" class="group relative bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/25">
                    <span class="relative z-10 flex items-center">
                        Commencer l'essai gratuit
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </a>
                
                <a href="#contact-form" class="group border-2 border-orange-400/50 text-orange-300 hover:border-yellow-400 hover:text-yellow-300 px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 hover:shadow-lg backdrop-blur-sm bg-white/5">
                    <span class="flex items-center">
                        Demander une démo
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection