<?php
// Page de test simple pour simuler une commande réussie
session_start();

// Simuler des données de commande en session
session([
    'order_id' => 123,
    'order_number' => 'ORD-20250130-TEST123',
    'cart_items' => [
        [
            'id' => 1,
            'name' => 'Pizza Margherita',
            'quantity' => 2,
            'price' => 3000,
            'options' => ['Taille' => 'Grande'],
            'specialInstructions' => 'Sans fromage'
        ]
    ],
    'subtotal' => 6000,
    'delivery_fee' => 500,
    'total' => 6500,
    'delivery_type' => 'delivery',
    'payment_method' => 'cash',
    'special_instructions' => 'Livraison rapide',
    'table_number' => null,
    'number_of_guests' => null
]);

echo "<h1>Test de session</h1>";
echo "<p>Données de session créées :</p>";
echo "<ul>";
echo "<li>order_id: " . session('order_id') . "</li>";
echo "<li>order_number: " . session('order_number') . "</li>";
echo "<li>total: " . session('total') . "</li>";
echo "</ul>";

echo "<p><a href='http://127.0.0.1:8000/restaurant/wonder/checkout/success' style='background: orange; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Tester la page de confirmation</a></p>";

echo "<p><a href='http://127.0.0.1:8000/public/test_success_complete.html' style='background: blue; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Tester la page HTML complète</a></p>";
?> 