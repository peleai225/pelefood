@extends('layouts.app')

@section('title', 'FAQ - PeleFood')
@section('description', 'Trouvez rapidement des réponses à vos questions sur PeleFood')

@section('content')
<!-- Hero Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-white to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">
            Questions <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">Fréquentes</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Trouvez rapidement des réponses à toutes vos questions sur PeleFood. Notre équipe est là pour vous accompagner.
        </p>
    </div>
</section>

<!-- Section FAQ -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Catégorie : Général -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Questions Générales</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Qu'est-ce que PeleFood ?</h3>
                    <p class="text-gray-600">
                        PeleFood est une plateforme SaaS complète conçue pour digitaliser les restaurants. 
                        Elle permet de gérer les commandes, les menus, les paiements et les clients en ligne, 
                        spécialement adaptée aux besoins du marché africain.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">PeleFood fonctionne-t-il en Afrique de l'Ouest ?</h3>
                    <p class="text-gray-600">
                        Oui ! PeleFood est spécialement conçu pour l'Afrique de l'Ouest avec support des paiements locaux 
                        (Orange Money, MTN Mobile Money, Moov Money), langues locales et infrastructure locale.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quels types de restaurants peuvent utiliser PeleFood ?</h3>
                    <p class="text-gray-600">
                        PeleFood s'adapte à tous les types de restaurants : fast-food, restaurants traditionnels, 
                        pizzerias, cafés, food trucks, et même les chaînes de restaurants.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Catégorie : Fonctionnalités -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Fonctionnalités</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quelles sont les principales fonctionnalités ?</h3>
                    <p class="text-gray-600">
                        PeleFood inclut : gestion des commandes en temps réel, création et gestion des menus, 
                        paiements en ligne sécurisés, analytics avancés, gestion des clients, et un site web personnalisé 
                        pour chaque restaurant.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Puis-je personnaliser l'interface ?</h3>
                    <p class="text-gray-600">
                        Oui, chaque restaurant peut personnaliser son interface avec ses couleurs, son logo, 
                        ses photos et son identité visuelle. Vous gardez votre image de marque.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">La plateforme est-elle multilingue ?</h3>
                    <p class="text-gray-600">
                        Oui, PeleFood est disponible en français, anglais et plusieurs langues locales africaines. 
                        L'interface s'adapte automatiquement selon la langue de vos clients.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Catégorie : Paiements -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Paiements et Sécurité</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quels moyens de paiement sont acceptés ?</h3>
                    <p class="text-gray-600">
                        Nous acceptons les cartes bancaires (Visa, Mastercard), les solutions de mobile money 
                        (Orange Money, MTN, Moov), et le paiement à la livraison en espèces.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Les paiements sont-ils sécurisés ?</h3>
                    <p class="text-gray-600">
                        Absolument ! Nous utilisons une infrastructure de paiement de niveau bancaire avec 
                        chiffrement SSL, conformité PCI DSS et protection contre la fraude.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quand recevrai-je mes paiements ?</h3>
                    <p class="text-gray-600">
                        Les paiements sont traités en temps réel et transférés sur votre compte bancaire 
                        sous 2-3 jours ouvrables selon votre banque.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Catégorie : Mise en place -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Mise en Place et Support</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Combien de temps pour la mise en place ?</h3>
                    <p class="text-gray-600">
                        La mise en place prend généralement 24-48h. Notre équipe vous accompagne à chaque étape 
                        pour un déploiement rapide et efficace.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Proposez-vous une formation ?</h3>
                    <p class="text-gray-600">
                        Oui, nous proposons une formation gratuite pour tous nos clients. Nos experts vous forment 
                        à l'utilisation de la plateforme et restent disponibles pour vous accompagner.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quel support proposez-vous ?</h3>
                    <p class="text-gray-600">
                        Nous proposons un support multilingue disponible 24/7 par email, chat et téléphone. 
                        Support prioritaire pour les plans Pro et Enterprise.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Catégorie : Tarifs -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Tarifs et Abonnements</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Y a-t-il des frais cachés ?</h3>
                    <p class="text-gray-600">
                        Non, nos tarifs sont transparents. Le prix affiché est le prix final. 
                        Aucun frais d'installation, de résiliation ou de maintenance caché.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Puis-je tester avant d'acheter ?</h3>
                    <p class="text-gray-600">
                        Absolument ! Nous proposons un essai gratuit de 14 jours sans engagement. 
                        Testez toutes les fonctionnalités avant de vous décider.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Puis-je changer de plan à tout moment ?</h3>
                    <p class="text-gray-600">
                        Oui, vous pouvez passer d'un plan à l'autre à tout moment. 
                        Les changements prennent effet immédiatement et sont proratisés.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Proposez-vous des tarifs annuels ?</h3>
                    <p class="text-gray-600">
                        Oui, nous proposons des réductions de 20% pour les engagements annuels sur tous nos plans. 
                        Une option économique pour les restaurants qui s'engagent sur le long terme.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Catégorie : Technique -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Aspects Techniques</h2>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quels sont les prérequis techniques ?</h3>
                    <p class="text-gray-600">
                        Aucun prérequis technique ! PeleFood fonctionne sur tous les navigateurs web et appareils. 
                        Vous avez juste besoin d'une connexion internet.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Mes données sont-elles sauvegardées ?</h3>
                    <p class="text-gray-600">
                        Oui, vos données sont sauvegardées automatiquement et sécurisées. 
                        Nous utilisons une infrastructure cloud robuste avec sauvegarde multiple.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">PeleFood fonctionne-t-il hors ligne ?</h3>
                    <p class="text-gray-600">
                        PeleFood nécessite une connexion internet pour la synchronisation en temps réel. 
                        Cependant, certaines fonctionnalités de base peuvent fonctionner en mode dégradé.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Contact -->
<section class="py-20 bg-gradient-to-br from-slate-50 to-orange-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-6">Vous n'avez pas trouvé votre réponse ?</h2>
        <p class="text-xl text-gray-600 mb-8">
            Notre équipe d'experts est là pour vous aider. Contactez-nous pour toute question spécifique.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                Nous contacter
            </a>
            <a href="tel:+2252722497484" class="border-2 border-orange-500 text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-500 hover:text-white transition-all duration-300">
                Appeler maintenant
            </a>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-4">Ou consultez nos ressources :</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Documentation</a>
                <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Vidéos tutorielles</a>
                <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Centre d'aide</a>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="py-20 bg-gradient-to-r from-orange-600 to-red-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-white mb-6">Prêt à commencer avec PeleFood ?</h2>
        <p class="text-xl text-orange-100 mb-8">Rejoignez des centaines de restaurants qui ont déjà digitalisé leur activité</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300">
                Commencer gratuitement
            </a>
            <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-orange-600 transition-all duration-300">
                Demander une démo
            </a>
        </div>
    </div>
</section>
@endsection 