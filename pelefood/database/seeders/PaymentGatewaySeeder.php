<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Wave',
                'provider' => 'wave',
                'description' => 'Solution de paiement mobile populaire en Côte d\'Ivoire',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'api_key' => 'test_wave_api_key_123456',
                    'business_token' => 'test_business_token_123456',
                    'environment' => 'sandbox',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.5,
                    'fees_fixed' => 50,
                    'supported_currencies' => ['XOF'],
                    'supported_countries' => ['CI', 'SN', 'ML', 'BF'],
                    'min_amount' => 100,
                    'max_amount' => 500000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/wave',
                'webhook_secret' => 'whsec_wave_test_secret_123456',
            ],
            [
                'name' => 'Paystack',
                'provider' => 'paystack',
                'description' => 'Plateforme de paiement leader en Afrique de l\'Ouest',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'secret_key' => 'sk_test_paystack_secret_key_123456',
                    'public_key' => 'pk_test_paystack_public_key_123456',
                    'environment' => 'test',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.5,
                    'fees_fixed' => 100,
                    'supported_currencies' => ['NGN', 'GHS', 'ZAR', 'USD'],
                    'supported_countries' => ['NG', 'GH', 'ZA', 'KE', 'CI'],
                    'min_amount' => 100,
                    'max_amount' => 1000000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/paystack',
                'webhook_secret' => 'whsec_paystack_test_secret_123456',
            ],
            [
                'name' => 'Flutterwave',
                'provider' => 'flutterwave',
                'description' => 'Solution de paiement panafricaine',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'secret_key' => 'FLWSECK_TEST_flutterwave_secret_key_123456',
                    'public_key' => 'FLWPUBK_TEST_flutterwave_public_key_123456',
                    'environment' => 'test',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.4,
                    'fees_fixed' => 50,
                    'supported_currencies' => ['XOF', 'NGN', 'GHS', 'KES', 'ZAR', 'USD', 'EUR'],
                    'supported_countries' => ['CI', 'NG', 'GH', 'KE', 'ZA', 'EG', 'TZ'],
                    'min_amount' => 100,
                    'max_amount' => 2000000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/flutterwave',
                'webhook_secret' => 'whsec_flutterwave_test_secret_123456',
            ],
            [
                'name' => 'Orange Money',
                'provider' => 'orange_money',
                'description' => 'Service de paiement mobile d\'Orange',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'merchant_id' => 'test_orange_merchant_id_123456',
                    'api_key' => 'test_orange_api_key_123456',
                    'environment' => 'sandbox',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.0,
                    'fees_fixed' => 25,
                    'supported_currencies' => ['XOF'],
                    'supported_countries' => ['CI', 'BF', 'ML', 'SN'],
                    'min_amount' => 100,
                    'max_amount' => 500000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/orange',
                'webhook_secret' => 'whsec_orange_test_secret_123456',
            ],
            [
                'name' => 'MTN Mobile Money',
                'provider' => 'mtn_momo',
                'description' => 'Service de paiement mobile de MTN',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'subscription_key' => 'test_mtn_subscription_key_123456',
                    'api_key' => 'test_mtn_api_key_123456',
                    'environment' => 'sandbox',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.0,
                    'fees_fixed' => 25,
                    'supported_currencies' => ['XOF'],
                    'supported_countries' => ['CI', 'GH', 'UG', 'RW'],
                    'min_amount' => 100,
                    'max_amount' => 500000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/mtn',
                'webhook_secret' => 'whsec_mtn_test_secret_123456',
            ],
            [
                'name' => 'Moov Money',
                'provider' => 'moov_money',
                'description' => 'Service de paiement mobile de Moov',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'merchant_id' => 'test_moov_merchant_id_123456',
                    'api_key' => 'test_moov_api_key_123456',
                    'environment' => 'sandbox',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.0,
                    'fees_fixed' => 25,
                    'supported_currencies' => ['XOF'],
                    'supported_countries' => ['CI', 'BF', 'ML', 'SN'],
                    'min_amount' => 100,
                    'max_amount' => 500000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/moov',
                'webhook_secret' => 'whsec_moov_test_secret_123456',
            ],
            [
                'name' => 'CinetPay',
                'provider' => 'cinetpay',
                'description' => 'Solution de paiement spécialisée Afrique',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'api_key' => 'test_cinetpay_api_key_123456',
                    'site_id' => 'test_cinetpay_site_id_123456',
                    'environment' => 'TEST',
                ]),
                'settings' => json_encode([
                    'fees_percentage' => 1.2,
                    'fees_fixed' => 30,
                    'supported_currencies' => ['XOF', 'XAF', 'CDF', 'GNF'],
                    'supported_countries' => ['CI', 'SN', 'CM', 'CD', 'GN'],
                    'min_amount' => 100,
                    'max_amount' => 1000000,
                ]),
                'webhook_url' => 'https://pelefood.com/payment/webhook/cinetpay',
                'webhook_secret' => 'whsec_cinetpay_test_secret_123456',
            ],
            [
                'name' => 'Paiement en Espèces',
                'provider' => 'cash',
                'description' => 'Paiement à la livraison en espèces',
                'is_active' => true,
                'test_mode' => false,
                'credentials' => json_encode([]),
                'settings' => json_encode([
                    'fees_percentage' => 0,
                    'fees_fixed' => 0,
                    'supported_currencies' => ['XOF'],
                    'supported_countries' => ['CI'],
                    'min_amount' => 100,
                    'max_amount' => 100000,
                    'requires_change' => true,
                ]),
                'webhook_url' => null,
                'webhook_secret' => null,
            ],
        ];

        foreach ($gateways as $gatewayData) {
            PaymentGateway::updateOrCreate(
                ['provider' => $gatewayData['provider']],
                $gatewayData
            );
        }

        $this->command->info('✅ ' . count($gateways) . ' passerelles de paiement créées/mises à jour');
        
        // Afficher les informations importantes
        $this->command->info('');
        $this->command->info('🔑 Clés de test pour le développement :');
        $this->command->info('   Wave: test_wave_api_key_123456');
        $this->command->info('   Paystack: sk_test_paystack_secret_key_123456');
        $this->command->info('   Flutterwave: FLWSECK_TEST_flutterwave_secret_key_123456');
        $this->command->info('');
        $this->command->info('🌐 URLs des webhooks :');
        $this->command->info('   Wave: https://pelefood.com/payment/webhook/wave');
        $this->command->info('   Paystack: https://pelefood.com/payment/webhook/paystack');
        $this->command->info('   Flutterwave: https://pelefood.com/payment/webhook/flutterwave');
        $this->command->info('');
        $this->command->info('⚠️  Remplacez ces clés par vos vraies clés API en production !');
    }
}
