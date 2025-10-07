<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $company = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $newsletter = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'company' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
        'newsletter' => 'boolean'
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.email' => 'Veuillez entrer un email valide.',
        'subject.required' => 'Le sujet est obligatoire.',
        'message.required' => 'Le message est obligatoire.',
        'message.min' => 'Le message doit contenir au moins 10 caractères.'
    ];

    public function submitForm()
    {
        $this->validate();

        // Ici, vous pouvez ajouter la logique pour envoyer l'email
        // Par exemple, utiliser Mail::send() ou un service externe
        
        session()->flash('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->company = '';
        $this->phone = '';
        $this->subject = '';
        $this->message = '';
        $this->newsletter = false;
    }

    public function render()
    {
        return view('livewire.public.contact-page')
            ->layout('layouts.saas-livewire');
    }
}
