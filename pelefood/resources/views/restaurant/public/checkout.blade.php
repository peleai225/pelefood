<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Commande - {{ $restaurant->name ?? 'Restaurant PeleFood' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .restaurant-theme {
            --primary-color: {{ $restaurant->theme_colors['primary'] ?? '#f97316' }};
            --secondary-color: {{ $restaurant->theme_colors['secondary'] ?? '#ea580c' }};
            --accent-color: {{ $restaurant->theme_colors['accent'] ?? '#c2410c' }};
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .text-primary {
            color: var(--primary-color);
        }
        
        .border-primary {
            border-color: var(--primary-color);
        }
        
        .bg-primary-light {
            background-color: color-mix(in srgb, var(--primary-color) 10%, transparent);
        }
    </style>
</head>
<body class="restaurant-theme bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="/restaurant/{{ $restaurant->slug ?? 'pelefood' }}" class="text-primary hover:text-secondary transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Finaliser votre commande</h1>
                        <p class="text-sm text-gray-500">{{ $restaurant->name ?? 'Restaurant PeleFood' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $restaurant->preparation_time ?? 30 }} min
                    </span>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulaire de commande -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Type de commande -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-shopping-bag text-primary mr-2"></i>
                        Type de commande
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="order-type-option cursor-pointer">
                            <input type="radio" name="order_type" value="on_site" class="sr-only" checked>
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                <i class="fas fa-utensils text-3xl text-gray-400 mb-3"></i>
                                <h3 class="font-semibold text-gray-900">Sur place</h3>
                                <p class="text-sm text-gray-500">Manger au restaurant</p>
                            </div>
                        </label>
                        
                        <label class="order-type-option cursor-pointer">
                            <input type="radio" name="order_type" value="delivery" class="sr-only">
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                <i class="fas fa-truck text-3xl text-gray-400 mb-3"></i>
                                <h3 class="font-semibold text-gray-900">Livraison</h3>
                                <p class="text-sm text-gray-500">Livré à votre adresse</p>
                            </div>
                        </label>
                        
                        <label class="order-type-option cursor-pointer">
                            <input type="radio" name="order_type" value="takeaway" class="sr-only">
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                <i class="fas fa-shopping-bag text-3xl text-gray-400 mb-3"></i>
                                <h3 class="font-semibold text-gray-900">À emporter</h3>
                                <p class="text-sm text-gray-500">Récupérer au restaurant</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Informations personnelles -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user text-primary mr-2"></i>
                        Informations personnelles
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                            <input type="text" id="first_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Votre prénom">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                            <input type="text" id="last_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Votre nom">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input type="tel" id="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="+225 07 12 34 56 78">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="votre@email.com">
                        </div>
                    </div>
                </div>

                <!-- Adresse de livraison (conditionnelle) -->
                <div id="delivery-address" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                        Adresse de livraison
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse complète *</label>
                            <input type="text" id="address" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="123 Avenue des Champs">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                                <input type="text" id="city" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Votre ville">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                <input type="text" id="postal_code" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Code postal">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                                <input type="text" id="country" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Votre pays">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instructions de livraison</label>
                            <textarea id="delivery_instructions" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Instructions spéciales pour le livreur..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Options de livraison -->
                <div id="delivery-options" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-truck text-primary mr-2"></i>
                        Options de livraison
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="delivery_option" value="standard" class="text-primary focus:ring-primary" checked>
                                <div>
                                    <h4 class="font-medium text-gray-900">Livraison standard</h4>
                                    <p class="text-sm text-gray-500">{{ $restaurant->preparation_time ?? 30 }} - {{ ($restaurant->preparation_time ?? 30) + 15 }} minutes</p>
                                </div>
                            </div>
                            <span class="font-semibold text-primary">{{ number_format($restaurant->delivery_fee ?? 500) }} FCFA</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="delivery_option" value="express" class="text-primary focus:ring-primary">
                                <div>
                                    <h4 class="font-medium text-gray-900">Livraison express</h4>
                                    <p class="text-sm text-gray-500">15 - 25 minutes</p>
                                </div>
                            </div>
                            <span class="font-semibold text-primary">{{ number_format(($restaurant->delivery_fee ?? 500) + 300) }} FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Méthodes de paiement -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        Méthode de paiement
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="cash" class="text-primary focus:ring-primary" checked>
                                <div>
                                    <h4 class="font-medium text-gray-900">Espèces</h4>
                                    <p class="text-sm text-gray-500">Paiement à la réception</p>
                                </div>
                            </div>
                            <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="mobile_money" class="text-primary focus:ring-primary">
                                <div>
                                    <h4 class="font-medium text-gray-900">Mobile Money</h4>
                                    <p class="text-sm text-gray-500">Moov, MTN, Orange</p>
                                </div>
                            </div>
                            <i class="fas fa-mobile-alt text-blue-500 text-xl"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="card" class="text-primary focus:ring-primary">
                                <div>
                                    <h4 class="font-medium text-gray-900">Carte bancaire</h4>
                                    <p class="text-sm text-gray-500">Visa, Mastercard</p>
                                </div>
                            </div>
                            <i class="fas fa-credit-card text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Instructions spéciales -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-edit text-primary mr-2"></i>
                        Instructions spéciales
                    </h2>
                    
                    <textarea id="special_instructions" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Instructions spéciales pour votre commande (allergies, préférences, etc.)"></textarea>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-receipt text-primary mr-2"></i>
                        Résumé de votre commande
                    </h2>
                    
                    <!-- Articles du panier -->
                    <div id="order-items" class="space-y-3 mb-6">
                        <!-- Les articles seront ajoutés dynamiquement -->
                    </div>
                    
                    <!-- Sous-total -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Sous-total</span>
                            <span id="subtotal">0 FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Frais de livraison</span>
                            <span id="delivery-fee">0 FCFA</span>
                        </div>
                        <div id="discount-row" class="flex justify-between text-sm text-green-600 hidden">
                            <span>Réduction</span>
                            <span id="discount-amount">0 FCFA</span>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span id="total">0 FCFA</span>
                        </div>
                    </div>
                    
                    <!-- Code promo -->
                    <div class="mb-6">
                        <div class="flex space-x-2">
                            <input type="text" id="promo-code" placeholder="Code promo" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                            <button onclick="applyPromoCode()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                Appliquer
                            </button>
                        </div>
                    </div>
                    
                    <!-- Bouton de commande -->
                    <button onclick="placeOrder()" class="w-full btn-primary py-4 rounded-lg text-lg font-semibold hover:shadow-lg transition-all">
                        <i class="fas fa-lock mr-2"></i>
                        Confirmer la commande
                    </button>
                    
                    <!-- Informations de sécurité -->
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Paiement sécurisé et données protégées
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Commande confirmée !</h3>
                <p class="text-gray-600 mb-6">Votre commande a été reçue et est en cours de préparation.</p>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600">Numéro de commande</p>
                    <p class="text-lg font-bold text-primary" id="order-number">#12345</p>
                </div>
                <button onclick="closeConfirmation()" class="btn-primary px-6 py-3 rounded-lg font-medium w-full">
                    Retour au restaurant
                </button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let cart = [];
        let currentRestaurantSlug = '{{ $restaurant->slug ?? "pelefood" }}';
        let deliveryFee = {{ $restaurant->delivery_fee ?? 500 }};
        let appliedPromo = null;
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            setupOrderTypeHandlers();
            updateOrderSummary();
        });
        
        // Charger le panier depuis localStorage
        function loadCart() {
            const savedCart = localStorage.getItem('restaurant_cart');
            const savedSlug = localStorage.getItem('restaurant_slug');
            
            if (savedCart && savedSlug === currentRestaurantSlug) {
                cart = JSON.parse(savedCart);
                displayOrderItems();
            } else {
                // Rediriger vers le restaurant si pas de panier
                window.location.href = `/restaurant/${currentRestaurantSlug}`;
            }
        }
        
        // Gestion du type de commande
        function setupOrderTypeHandlers() {
            const orderTypeInputs = document.querySelectorAll('input[name="order_type"]');
            const deliveryAddress = document.getElementById('delivery-address');
            const deliveryOptions = document.getElementById('delivery-options');
            
            orderTypeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'delivery') {
                        deliveryAddress.classList.remove('hidden');
                        deliveryOptions.classList.remove('hidden');
                        updateDeliveryFee();
                    } else {
                        deliveryAddress.classList.add('hidden');
                        deliveryOptions.classList.add('hidden');
                        deliveryFee = 0;
                        updateOrderSummary();
                    }
                });
            });
        }
        
        // Afficher les articles de la commande
        function displayOrderItems() {
            const orderItems = document.getElementById('order-items');
            orderItems.innerHTML = '';
            
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
                itemElement.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-light rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">${item.name}</h4>
                            <p class="text-sm text-gray-500">${item.quantity} x ${item.price.toLocaleString()} FCFA</p>
                        </div>
                    </div>
                    <span class="font-semibold text-gray-900">${(item.price * item.quantity).toLocaleString()} FCFA</span>
                `;
                orderItems.appendChild(itemElement);
            });
        }
        
        // Mettre à jour les frais de livraison
        function updateDeliveryFee() {
            const selectedOption = document.querySelector('input[name="delivery_option"]:checked');
            if (selectedOption && selectedOption.value === 'express') {
                deliveryFee = {{ $restaurant->delivery_fee ?? 500 }} + 300;
            } else {
                deliveryFee = {{ $restaurant->delivery_fee ?? 500 }};
            }
            updateOrderSummary();
        }
        
        // Mettre à jour le résumé de la commande
        function updateOrderSummary() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discount = appliedPromo ? (subtotal * 0.1) : 0; // 10% de réduction pour l'exemple
            
            document.getElementById('subtotal').textContent = `${subtotal.toLocaleString()} FCFA`;
            document.getElementById('delivery-fee').textContent = `${deliveryFee.toLocaleString()} FCFA`;
            
            if (appliedPromo) {
                document.getElementById('discount-row').classList.remove('hidden');
                document.getElementById('discount-amount').textContent = `-${discount.toLocaleString()} FCFA`;
            } else {
                document.getElementById('discount-row').classList.add('hidden');
            }
            
            const total = subtotal + deliveryFee - discount;
            document.getElementById('total').textContent = `${total.toLocaleString()} FCFA`;
        }
        
        // Appliquer un code promo
        function applyPromoCode() {
            const promoCode = document.getElementById('promo-code').value.trim();
            
            if (promoCode === 'PELEFOOD10') {
                appliedPromo = promoCode;
                updateOrderSummary();
                showNotification('Code promo appliqué ! 10% de réduction', 'success');
                document.getElementById('promo-code').value = '';
            } else {
                showNotification('Code promo invalide', 'error');
            }
        }
        
        // Passer la commande
        function placeOrder() {
            // Validation des champs obligatoires
            const requiredFields = ['first_name', 'last_name', 'phone'];
            const orderType = document.querySelector('input[name="order_type"]:checked').value;
            
            if (orderType === 'delivery') {
                requiredFields.push('address', 'city', 'country');
            }
            
            let isValid = true;
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                showNotification('Veuillez remplir tous les champs obligatoires', 'error');
                return;
            }
            
            // Préparer les données de la commande
            const orderData = {
                customer_name: document.getElementById('first_name').value.trim() + ' ' + document.getElementById('last_name').value.trim(),
                customer_phone: document.getElementById('phone').value.trim(),
                customer_email: document.getElementById('email').value.trim() || null,
                order_type: orderType,
                delivery_address: orderType === 'delivery' ? 
                    `${document.getElementById('address').value.trim()}, ${document.getElementById('city').value.trim()}, ${document.getElementById('country').value.trim()}` : null,
                special_instructions: document.getElementById('special_instructions').value.trim() || null,
                cart_items: cart.map(item => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity
                })),
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            
            // Désactiver le bouton pendant l'envoi
            const submitBtn = document.querySelector('button[onclick="placeOrder()"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement...';
            
            // Envoyer la commande au serveur
            fetch(`/restaurant/${currentRestaurantSlug}/order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Vider le panier
                    localStorage.removeItem('restaurant_cart');
                    localStorage.removeItem('restaurant_slug');
                    
                    // Rediriger vers la page de confirmation
                    window.location.href = data.redirect_url;
                } else {
                    throw new Error(data.message || 'Erreur lors de la commande');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Erreur lors de la commande. Veuillez réessayer.', 'error');
                
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }
        
        // Fermer la confirmation
        function closeConfirmation() {
            window.location.href = `/restaurant/${currentRestaurantSlug}`;
        }
        
        // Gestion des options de livraison
        document.querySelectorAll('input[name="delivery_option"]').forEach(input => {
            input.addEventListener('change', updateDeliveryFee);
        });
        
        // Gestion des options de commande
        document.querySelectorAll('.order-type-option input').forEach(input => {
            input.addEventListener('change', function() {
                // Mettre à jour l'apparence des options
                document.querySelectorAll('.order-type-option div').forEach(div => {
                    div.classList.remove('border-primary', 'bg-primary-light');
                    div.classList.add('border-gray-200');
                });
                
                if (this.checked) {
                    this.closest('.order-type-option').querySelector('div').classList.add('border-primary', 'bg-primary-light');
                }
            });
        });
        
        // Notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>
</html> 