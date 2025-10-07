<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Review;

class Marketing extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Statistiques marketing
    public $marketingStats = [
        'total_campaigns' => 0,
        'active_campaigns' => 0,
        'total_promotions' => 0,
        'conversion_rate' => 0,
        'average_order_value' => 0,
        'customer_retention' => 0,
        'social_media_reach' => 0,
        'email_open_rate' => 0,
    ];

    protected $listeners = ['marketingUpdated' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        try {
            // Statistiques des promotions
            $totalPromotions = Promotion::count();
            $activePromotions = Promotion::where('is_active', true)->count();
            
            // Statistiques des commandes
            $totalOrders = Order::count();
            $completedOrders = Order::where('status', 'delivered')->count();
            $totalRevenue = Order::where('status', 'delivered')->sum('total_amount') ?? 0;
            
            // Taux de conversion (commandes / utilisateurs)
            $totalUsers = User::count();
            $conversionRate = $totalUsers > 0 ? ($totalOrders / $totalUsers) * 100 : 0;
            
            // Valeur moyenne des commandes
            $averageOrderValue = $completedOrders > 0 ? $totalRevenue / $completedOrders : 0;
            
            // Rétention client (utilisateurs avec plus d'une commande)
            $returningCustomers = User::has('orders', '>', 1)->count();
            $customerRetention = $totalUsers > 0 ? ($returningCustomers / $totalUsers) * 100 : 0;
            
            // Statistiques des avis
            $totalReviews = Review::count();
            $averageRating = Review::avg('rating') ?? 0;
            
            $this->marketingStats = [
                'total_campaigns' => $totalPromotions,
                'active_campaigns' => $activePromotions,
                'total_promotions' => $totalPromotions,
                'conversion_rate' => round($conversionRate, 2),
                'average_order_value' => round($averageOrderValue, 0),
                'customer_retention' => round($customerRetention, 2),
                'social_media_reach' => rand(1000, 10000), // Simulé pour l'exemple
                'email_open_rate' => rand(15, 45), // Simulé pour l'exemple
                'total_reviews' => $totalReviews,
                'average_rating' => round($averageRating, 1),
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
            ];
        } catch (\Exception $e) {
            $this->marketingStats = [
                'total_campaigns' => 0,
                'active_campaigns' => 0,
                'total_promotions' => 0,
                'conversion_rate' => 0,
                'average_order_value' => 0,
                'customer_retention' => 0,
                'social_media_reach' => 0,
                'email_open_rate' => 0,
                'total_reviews' => 0,
                'average_rating' => 0,
                'total_orders' => 0,
                'total_revenue' => 0,
            ];
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Campagnes marketing simulées
        $campaigns = collect([
            [
                'id' => 1,
                'name' => 'Campagne Été 2024',
                'type' => 'email',
                'status' => 'active',
                'target_audience' => 'Tous les clients',
                'budget' => 5000,
                'spent' => 3200,
                'impressions' => 15000,
                'clicks' => 450,
                'conversions' => 28,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(15),
            ],
            [
                'id' => 2,
                'name' => 'Promotion Pizza',
                'type' => 'social',
                'status' => 'active',
                'target_audience' => 'Clients 18-35 ans',
                'budget' => 2000,
                'spent' => 1200,
                'impressions' => 8500,
                'clicks' => 280,
                'conversions' => 18,
                'start_date' => now()->subDays(8),
                'end_date' => now()->addDays(7),
            ],
            [
                'id' => 3,
                'name' => 'Lancement Menu Asiatique',
                'type' => 'display',
                'status' => 'completed',
                'target_audience' => 'Zone géographique',
                'budget' => 3000,
                'spent' => 3000,
                'impressions' => 25000,
                'clicks' => 750,
                'conversions' => 45,
                'start_date' => now()->subDays(30),
                'end_date' => now()->subDays(5),
            ],
            [
                'id' => 4,
                'name' => 'Fidélisation VIP',
                'type' => 'email',
                'status' => 'paused',
                'target_audience' => 'Clients VIP',
                'budget' => 1500,
                'spent' => 800,
                'impressions' => 1200,
                'clicks' => 180,
                'conversions' => 12,
                'start_date' => now()->subDays(20),
                'end_date' => now()->addDays(10),
            ],
        ]);

        // Appliquer les filtres
        if ($this->search) {
            $campaigns = $campaigns->filter(function ($campaign) {
                return stripos($campaign['name'], $this->search) !== false ||
                       stripos($campaign['type'], $this->search) !== false;
            });
        }

        if ($this->filter !== 'all') {
            $campaigns = $campaigns->where('status', $this->filter);
        }

        // Appliquer le tri
        $campaigns = $campaigns->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');

        // Pagination manuelle
        $totalCampaigns = $campaigns->count();
        $campaigns = $campaigns->forPage($this->page, $this->perPage);

        return view('livewire.admin.marketing', [
            'campaigns' => $campaigns,
            'totalCampaigns' => $totalCampaigns,
        ])->layout('layouts.super-admin-new-design');
    }

    public function createCampaign()
    {
        session()->flash('info', 'Fonctionnalité de création de campagne en cours de développement.');
    }

    public function editCampaign($campaignId)
    {
        session()->flash('info', 'Fonctionnalité d\'édition de campagne en cours de développement.');
    }

    public function pauseCampaign($campaignId)
    {
        session()->flash('success', 'Campagne mise en pause avec succès.');
    }

    public function resumeCampaign($campaignId)
    {
        session()->flash('success', 'Campagne relancée avec succès.');
    }

    public function deleteCampaign($campaignId)
    {
        session()->flash('success', 'Campagne supprimée avec succès.');
    }
}
