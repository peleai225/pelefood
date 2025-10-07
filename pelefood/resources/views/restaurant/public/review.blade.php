<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donner un avis - Commande {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        .rating-star {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .rating-star:hover {
            transform: scale(1.2);
        }
        
        .rating-star.active {
            color: #fbbf24;
        }
        
        .rating-star.inactive {
            color: #d1d5db;
        }
        
        .review-card {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .review-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .rating-category {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('order.tracking', $order->order_number) }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au suivi
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-xl font-bold text-gray-900">Donner un avis</h1>
                    <p class="text-sm text-gray-500">Commande {{ $order->order_number }}</p>
                </div>
                <div class="w-24"></div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Informations de la commande -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 review-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Détails de votre commande</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Restaurant:</span>
                            <span class="font-semibold">{{ $order->restaurant->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-bold text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Articles commandés:</h3>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->quantity }}x {{ $item->product->name }}</span>
                            <span class="font-medium">{{ number_format($item->price * $item->quantity) }} FCFA</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire d'avis -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 review-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Votre avis sur cette commande</h2>
            
            @if($existingReview)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-blue-700">Vous avez déjà donné un avis pour cette commande. Vous pouvez le modifier ci-dessous.</span>
                    </div>
                </div>
            @endif
            
            <form action="{{ route('order.review.store', $order->order_number) }}" method="POST" id="review-form">
                @csrf
                
                <!-- Note globale -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Note globale</label>
                    <div class="flex justify-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                class="rating-star text-4xl {{ $existingReview && $existingReview->rating >= $i ? 'active' : 'inactive' }}"
                                data-rating="{{ $i }}"
                                onclick="setRating({{ $i }})">
                            <i class="fas fa-star"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ $existingReview ? $existingReview->rating : 0 }}" required>
                    <p class="text-center text-gray-500 mt-2" id="rating-text">
                        {{ $existingReview ? 'Note actuelle: ' . $existingReview->rating . '/5' : 'Cliquez sur les étoiles pour noter' }}
                    </p>
                </div>
                
                <!-- Notes détaillées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Qualité de la nourriture -->
                    <div class="rating-category rounded-lg p-4 text-white">
                        <h3 class="font-semibold mb-3">Qualité de la nourriture</h3>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="rating-star text-xl {{ $existingReview && $existingReview->food_quality >= $i ? 'active' : 'inactive' }}"
                                    data-category="food_quality"
                                    data-rating="{{ $i }}"
                                    onclick="setCategoryRating('food_quality', {{ $i }})">
                                <i class="fas fa-star"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="food_quality" id="food_quality-input" value="{{ $existingReview ? $existingReview->food_quality : 0 }}" required>
                    </div>
                    
                    <!-- Qualité du service -->
                    <div class="rating-category rounded-lg p-4 text-white">
                        <h3 class="font-semibold mb-3">Qualité du service</h3>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="rating-star text-xl {{ $existingReview && $existingReview->service_quality >= $i ? 'active' : 'inactive' }}"
                                    data-category="service_quality"
                                    data-rating="{{ $i }}"
                                    onclick="setCategoryRating('service_quality', {{ $i }})">
                                <i class="fas fa-star"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="service_quality" id="service_quality-input" value="{{ $existingReview ? $existingReview->service_quality : 0 }}" required>
                    </div>
                    
                    <!-- Rapidité de livraison -->
                    <div class="rating-category rounded-lg p-4 text-white">
                        <h3 class="font-semibold mb-3">Rapidité de livraison</h3>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="rating-star text-xl {{ $existingReview && $existingReview->delivery_speed >= $i ? 'active' : 'inactive' }}"
                                    data-category="delivery_speed"
                                    data-rating="{{ $i }}"
                                    onclick="setCategoryRating('delivery_speed', {{ $i }})">
                                <i class="fas fa-star"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="delivery_speed" id="delivery_speed-input" value="{{ $existingReview ? $existingReview->delivery_speed : 0 }}" required>
                    </div>
                    
                    <!-- Rapport qualité-prix -->
                    <div class="rating-category rounded-lg p-4 text-white">
                        <h3 class="font-semibold mb-3">Rapport qualité-prix</h3>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="rating-star text-xl {{ $existingReview && $existingReview->value_for_money >= $i ? 'active' : 'inactive' }}"
                                    data-category="value_for_money"
                                    data-rating="{{ $i }}"
                                    onclick="setCategoryRating('value_for_money', {{ $i }})">
                                <i class="fas fa-star"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="value_for_money" id="value_for_money-input" value="{{ $existingReview ? $existingReview->value_for_money : 0 }}" required>
                    </div>
                </div>
                
                <!-- Commentaire -->
                <div class="mb-8">
                    <label for="comment" class="block text-lg font-semibold text-gray-900 mb-3">Votre commentaire</label>
                    <textarea name="comment" 
                              id="comment" 
                              rows="5" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Partagez votre expérience avec ce restaurant..."
                              required>{{ $existingReview ? $existingReview->comment : '' }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">Minimum 10 caractères, maximum 500 caractères</p>
                </div>
                
                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-yellow-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-yellow-700 transition-colors text-lg">
                        <i class="fas fa-star mr-2"></i>
                        {{ $existingReview ? 'Modifier mon avis' : 'Soumettre mon avis' }}
                    </button>
                    
                    <a href="{{ route('order.tracking', $order->order_number) }}" 
                       class="flex-1 bg-gray-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-700 transition-colors text-lg text-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Avis existants du restaurant -->
        <div class="bg-white rounded-lg shadow-lg p-6 review-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Avis des autres clients</h2>
            
            <div class="space-y-4">
                @foreach($order->restaurant->reviews()->latest()->take(5)->get() as $review)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="font-semibold text-gray-900">{{ $review->rating }}/5</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
                    
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-user mr-1"></i>{{ $review->customer_name }}</span>
                        <span><i class="fas fa-utensils mr-1"></i>{{ $review->food_quality }}/5</span>
                        <span><i class="fas fa-concierge-bell mr-1"></i>{{ $review->service_quality }}/5</span>
                        <span><i class="fas fa-truck mr-1"></i>{{ $review->delivery_speed }}/5</span>
                        <span><i class="fas fa-coins mr-1"></i>{{ $review->value_for_money }}/5</span>
                    </div>
                </div>
                @endforeach
                
                @if($order->restaurant->reviews()->count() === 0)
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-comments text-4xl mb-4"></i>
                    <p>Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
                </div>
                @endif
            </div>
            
            @if($order->restaurant->reviews()->count() > 5)
            <div class="text-center mt-6">
                <a href="{{ route('restaurant.reviews', $order->restaurant->slug) }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir tous les avis ({{ $order->restaurant->reviews()->count() }})
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Variables globales
        let currentRating = {{ $existingReview ? $existingReview->rating : 0 }};
        let categoryRatings = {
            food_quality: {{ $existingReview ? $existingReview->food_quality : 0 }},
            service_quality: {{ $existingReview ? $existingReview->service_quality : 0 }},
            delivery_speed: {{ $existingReview ? $existingReview->delivery_speed : 0 }},
            value_for_money: {{ $existingReview ? $existingReview->value_for_money : 0 }}
        };
        
        // Définir la note globale
        function setRating(rating) {
            currentRating = rating;
            document.getElementById('rating-input').value = rating;
            
            // Mettre à jour l'affichage des étoiles
            const stars = document.querySelectorAll('[data-rating]');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('inactive');
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                    star.classList.add('inactive');
                }
            });
            
            // Mettre à jour le texte
            const ratingText = document.getElementById('rating-text');
            ratingText.textContent = `Note: ${rating}/5`;
        }
        
        // Définir la note d'une catégorie
        function setCategoryRating(category, rating) {
            categoryRatings[category] = rating;
            document.getElementById(`${category}-input`).value = rating;
            
            // Mettre à jour l'affichage des étoiles de cette catégorie
            const stars = document.querySelectorAll(`[data-category="${category}"]`);
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('inactive');
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                    star.classList.add('inactive');
                }
            });
        }
        
        // Validation du formulaire
        document.getElementById('review-form').addEventListener('submit', function(e) {
            if (currentRating === 0) {
                e.preventDefault();
                alert('Veuillez donner une note globale à votre commande.');
                return false;
            }
            
            // Vérifier que toutes les catégories ont une note
            for (let category in categoryRatings) {
                if (categoryRatings[category] === 0) {
                    e.preventDefault();
                    alert('Veuillez noter toutes les catégories.');
                    return false;
                }
            }
            
            // Vérifier le commentaire
            const comment = document.getElementById('comment').value.trim();
            if (comment.length < 10) {
                e.preventDefault();
                alert('Votre commentaire doit contenir au moins 10 caractères.');
                return false;
            }
        });
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Si pas de note globale, afficher le message par défaut
            if (currentRating === 0) {
                document.getElementById('rating-text').textContent = 'Cliquez sur les étoiles pour noter';
            }
        });
    </script>
</body>
</html> 