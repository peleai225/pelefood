<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer les plans d'abonnement
        $this->artisan('db:seed', ['--class' => 'SubscriptionPlanSeeder']);
    }

    public function test_user_can_view_subscription_plans()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/restaurant/subscription/select');

        $response->assertStatus(200);
        $response->assertSee('Plan Mensuel');
        $response->assertSee('Plan Annuel');
    }

    public function test_user_can_subscribe_to_plan()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $plan = SubscriptionPlan::where('slug', 'plan-mensuel')->first();

        $this->actingAs($user);

        $response = $this->post("/restaurant/subscription/subscribe/{$plan->id}");

        $response->assertRedirect("/restaurant/subscription/payment/{$plan->id}");
        
        $restaurant->refresh();
        $this->assertEquals($plan->id, $restaurant->subscription_plan_id);
        $this->assertEquals('pending', $restaurant->subscription_status);
    }

    public function test_user_cannot_subscribe_without_restaurant()
    {
        $user = User::factory()->create();
        $plan = SubscriptionPlan::where('slug', 'plan-mensuel')->first();

        $this->actingAs($user);

        $response = $this->post("/restaurant/subscription/subscribe/{$plan->id}");

        $response->assertRedirect('/restaurant/restaurants/create');
    }

    public function test_user_cannot_subscribe_to_inactive_plan()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $plan = SubscriptionPlan::where('slug', 'plan-mensuel')->first();
        $plan->update(['is_active' => false]);

        $this->actingAs($user);

        $response = $this->post("/restaurant/subscription/subscribe/{$plan->id}");

        $response->assertStatus(404);
    }

    public function test_subscription_activation_after_payment()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'pending',
        ]);

        $plan = $restaurant->subscriptionPlan;

        $this->actingAs($user);

        $response = $this->post("/restaurant/subscription/payment/{$plan->id}");

        $response->assertRedirect('/restaurant/dashboard');
        
        $restaurant->refresh();
        $this->assertEquals('active', $restaurant->subscription_status);
        $this->assertEquals('completed', $restaurant->payment_status);
    }

    public function test_subscription_expiration_check()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'active',
            'subscription_expires_at' => now()->subDay(), // Expiré
        ]);

        $this->actingAs($user);

        $response = $this->get('/restaurant/dashboard');

        $response->assertRedirect('/restaurant/subscription/select');
    }

    public function test_plan_limits_enforcement()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'active',
        ]);

        $this->actingAs($user);

        // Tester l'accès aux fonctionnalités selon le plan
        $response = $this->get('/restaurant/products');
        $response->assertStatus(200);

        $response = $this->get('/restaurant/categories');
        $response->assertStatus(200);
    }

    public function test_subscription_management()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'active',
        ]);

        $this->actingAs($user);

        $response = $this->get('/restaurant/subscription/manage');

        $response->assertStatus(200);
        $response->assertSee($restaurant->subscriptionPlan->name);
    }

    public function test_subscription_cancellation()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $user->update(['tenant_id' => $tenant->id]);
        
        $restaurant = Restaurant::factory()->create([
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'active',
        ]);

        $this->actingAs($user);

        $response = $this->post('/restaurant/subscription/cancel');

        $response->assertRedirect('/restaurant/subscription/manage');
        
        $restaurant->refresh();
        $this->assertEquals('cancelled', $restaurant->subscription_status);
    }

    public function test_webhook_payment_processing()
    {
        $restaurant = Restaurant::factory()->create([
            'subscription_plan_id' => SubscriptionPlan::where('slug', 'plan-mensuel')->first()->id,
            'subscription_status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $response = $this->post('/webhook/wave', [
            'status' => 'success',
            'transaction_id' => 'test_123',
            'amount' => 30000,
        ]);

        $response->assertStatus(200);
        
        $restaurant->refresh();
        $this->assertEquals('active', $restaurant->subscription_status);
        $this->assertEquals('completed', $restaurant->payment_status);
    }
} 