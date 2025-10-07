<?php

namespace App\Http\Livewire\Payment;

use Livewire\Component;
use App\Services\CinetPayService;
use Illuminate\Support\Facades\Validator;

class CinetPayPayment extends Component
{
    public $amount;
    public $description;
    public $customer_name;
    public $customer_surname;
    public $customer_email;
    public $customer_phone_number;
    public $customer_address;
    public $customer_city;
    public $customer_country = 'CI';
    public $channels = 'ALL';
    
    public $isLoading = false;
    public $paymentUrl = '';
    public $transactionId = '';
    public $showPaymentForm = true;
    public $showPaymentButton = false;

    protected $rules = [
        'amount' => 'required|numeric|min:100',
        'description' => 'required|string|max:255',
        'customer_name' => 'required|string|max:100',
        'customer_surname' => 'required|string|max:100',
        'customer_email' => 'required|email|max:100',
        'customer_phone_number' => 'required|string|max:20',
        'customer_address' => 'nullable|string|max:255',
        'customer_city' => 'nullable|string|max:100',
        'customer_country' => 'nullable|string|max:2',
        'channels' => 'nullable|string|in:ALL,MOBILE_MONEY,CARD,BANK_TRANSFER',
    ];

    protected $messages = [
        'amount.required' => 'Le montant est obligatoire.',
        'amount.numeric' => 'Le montant doit être un nombre.',
        'amount.min' => 'Le montant minimum est 100 FCFA.',
        'description.required' => 'La description est obligatoire.',
        'customer_name.required' => 'Le nom est obligatoire.',
        'customer_surname.required' => 'Le prénom est obligatoire.',
        'customer_email.required' => 'L\'email est obligatoire.',
        'customer_email.email' => 'L\'email doit être valide.',
        'customer_phone_number.required' => 'Le numéro de téléphone est obligatoire.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function initializePayment()
    {
        $this->validate();

        $this->isLoading = true;

        try {
            $cinetPayService = new CinetPayService();
            
            $paymentData = [
                'amount' => $this->amount,
                'description' => $this->description,
                'customer_name' => $this->customer_name,
                'customer_surname' => $this->customer_surname,
                'customer_email' => $this->customer_email,
                'customer_phone_number' => $this->customer_phone_number,
                'customer_address' => $this->customer_address,
                'customer_city' => $this->customer_city,
                'customer_country' => $this->customer_country,
                'channels' => $this->channels,
                'metadata' => json_encode([
                    'source' => 'pelefood_web',
                    'timestamp' => now()->toISOString()
                ])
            ];

            $result = $cinetPayService->initializePayment($paymentData);

            if ($result['success']) {
                $this->paymentUrl = $result['payment_url'];
                $this->transactionId = $result['transaction_id'];
                $this->showPaymentForm = false;
                $this->showPaymentButton = true;
                
                session()->flash('message', 'Paiement initialisé avec succès !');
            } else {
                session()->flash('error', $result['message']);
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'initialisation du paiement: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function proceedToPayment()
    {
        if ($this->paymentUrl) {
            $this->dispatch('redirect-to-payment', [
                'url' => $this->paymentUrl
            ]);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'amount', 'description', 'customer_name', 'customer_surname',
            'customer_email', 'customer_phone_number', 'customer_address',
            'customer_city', 'customer_country', 'channels'
        ]);
        $this->showPaymentForm = true;
        $this->showPaymentButton = false;
        $this->paymentUrl = '';
        $this->transactionId = '';
    }

    public function render()
    {
        return view('livewire.payment.cinet-pay-payment');
    }
}
