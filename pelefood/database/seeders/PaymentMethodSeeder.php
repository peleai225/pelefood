<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Models\Restaurant;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // Vérifier si des méthodes de paiement existent déjà
            $existingMethods = PaymentMethod::where('restaurant_id', $restaurant->id)->count();
            if ($existingMethods > 0) {
                continue; // Passer au restaurant suivant
            }

            // Méthode par défaut - Espèces
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Paiement en espèces',
                'type' => 'cash',
                'provider' => 'cash',
                'credentials' => [],
                'is_active' => true,
                'is_default' => true,
                'transaction_fee' => 0,
                'fixed_fee' => 0,
                'settings' => [],
                'description' => 'Paiement en espèces à la livraison ou sur place',
            ]);

            // Orange Money (inactif par défaut)
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Orange Money',
                'type' => 'mobile_money',
                'provider' => 'orange',
                'credentials' => [
                    'api_key' => '',
                    'merchant_id' => '',
                    'phone_number' => '',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 1.5,
                'fixed_fee' => 50,
                'settings' => [
                    'environment' => 'sandbox',
                    'auto_confirm' => true,
                ],
                'description' => 'Paiement via Orange Money',
            ]);

            // MTN Mobile Money (inactif par défaut)
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'MTN Mobile Money',
                'type' => 'mobile_money',
                'provider' => 'mtn',
                'credentials' => [
                    'api_key' => '',
                    'merchant_id' => '',
                    'phone_number' => '',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 1.5,
                'fixed_fee' => 50,
                'settings' => [
                    'environment' => 'sandbox',
                    'auto_confirm' => true,
                ],
                'description' => 'Paiement via MTN Mobile Money',
            ]);

            // Moov Money (inactif par défaut)
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Moov Money',
                'type' => 'mobile_money',
                'provider' => 'moov',
                'credentials' => [
                    'api_key' => '',
                    'merchant_id' => '',
                    'phone_number' => '',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 1.5,
                'fixed_fee' => 50,
                'settings' => [
                    'environment' => 'sandbox',
                    'auto_confirm' => true,
                ],
                'description' => 'Paiement via Moov Money',
            ]);

            // Carte bancaire (Stripe) - inactif par défaut
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Carte bancaire',
                'type' => 'card',
                'provider' => 'stripe',
                'credentials' => [
                    'publishable_key' => '',
                    'secret_key' => '',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 2.9,
                'fixed_fee' => 30,
                'settings' => [
                    'environment' => 'sandbox',
                    'currency' => 'xof',
                ],
                'description' => 'Paiement par carte bancaire (Visa, Mastercard)',
            ]);

            // PayPal - inactif par défaut
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'PayPal',
                'type' => 'card',
                'provider' => 'paypal',
                'credentials' => [
                    'client_id' => '',
                    'client_secret' => '',
                    'mode' => 'sandbox',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 3.5,
                'fixed_fee' => 35,
                'settings' => [
                    'environment' => 'sandbox',
                    'currency' => 'usd',
                ],
                'description' => 'Paiement via PayPal',
            ]);

            // Virement bancaire - inactif par défaut
            PaymentMethod::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Virement bancaire',
                'type' => 'bank_transfer',
                'provider' => 'bank_transfer',
                'credentials' => [
                    'bank_name' => '',
                    'account_number' => '',
                    'account_holder' => '',
                    'swift_code' => '',
                ],
                'is_active' => false,
                'is_default' => false,
                'transaction_fee' => 0,
                'fixed_fee' => 0,
                'settings' => [
                    'auto_confirm' => false,
                    'manual_verification' => true,
                ],
                'description' => 'Paiement par virement bancaire',
            ]);
        }
    }
}
