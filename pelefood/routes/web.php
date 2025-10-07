<?php

use Illuminate\Support\Facades\Route;

// Inclure les routes SaaS
require_once __DIR__.'/saas.php';
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\FeaturesController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Restaurant\DashboardController;
use App\Http\Controllers\Restaurant\OrderController;
use App\Http\Controllers\Restaurant\ProductController;
use App\Http\Controllers\Restaurant\CategoryController;
use App\Http\Controllers\Restaurant\PromotionController;
use App\Http\Controllers\Restaurant\ReviewController;
use App\Http\Controllers\Restaurant\InvoiceController;
use App\Http\Controllers\Restaurant\PaymentMethodController;
use App\Http\Controllers\Restaurant\PaymentTransactionController;
use App\Http\Controllers\Restaurant\SettingController;
use App\Http\Controllers\Restaurant\SubscriptionController;
use App\Http\Controllers\Restaurant\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes simplifiées pour PeleFood
|
*/

// Landing page moderne (remplace l'ancienne home)
Route::get('/', [App\Http\Controllers\Public\LandingController::class, 'index'])->name('home');

// Ancienne page d'accueil (pour compatibilité)
Route::get('/old-home', App\Http\Livewire\Public\HomePage::class)->name('old.home');

// Routes des pages publiques (Livewire)
Route::get('/features', App\Http\Livewire\Public\FeaturesPage::class)->name('features');

Route::get('/pricing', App\Http\Livewire\Public\PricingPage::class)->name('pricing');

Route::get('/about', function () {
    return view('landing.about');
})->name('about');

Route::get('/contact', App\Http\Livewire\Public\ContactPage::class)->name('contact');

// Routes de paiement CinetPay
Route::get('/payment', App\Http\Livewire\Payment\CinetPayPayment::class)->name('payment.cinetpay');


// Route de test pour le dashboard
Route::get('/test-dashboard', function () {
    return view('test-dashboard');
})->name('test.dashboard');

// Routes d'authentification avec Livewire
Route::middleware('guest')->group(function () {
    // Pages Livewire modernes avec design inspiré de l'image
    Route::get('/login', function () {
        return view('auth.login-clean');
    })->name('login');
Route::get('/register', function () {
    return view('auth.register-modern');
})->name('register');
    
    
    // Page de démonstration des améliorations Livewire
    Route::get('/auth-demo', function () {
        return view('auth.demo-livewire');
    })->name('auth.demo');
    
    Route::get('/demo-modern', function () {
        return view('auth.demo-modern-design');
    })->name('demo.modern');
    Route::get('/demo-standalone', function () {
        return view('auth.demo-standalone');
    })->name('demo.standalone');
    
    // Routes de récupération de mot de passe avec Livewire
    Route::get('/forgot-password', App\Http\Livewire\Auth\ForgotPasswordForm::class)->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', App\Http\Livewire\Auth\ResetPasswordForm::class)->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Dashboard simple
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Routes de création de restaurant (sans middleware check.restaurant)
Route::prefix('restaurant')->name('restaurant.')->group(function () {
    // Index des restaurants (redirige vers la création ou l'édition)
    Route::get('/restaurants', [App\Http\Controllers\Restaurant\RestaurantController::class, 'index'])->name('restaurants.index');
    
    // Création de restaurant
    Route::get('/restaurants/create', [App\Http\Controllers\Restaurant\RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [App\Http\Controllers\Restaurant\RestaurantController::class, 'store'])->name('restaurants.store');
    
    // Édition et affichage de restaurant
    Route::get('/restaurants/{restaurant}', [App\Http\Controllers\Restaurant\RestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('/restaurants/{restaurant}/edit', [App\Http\Controllers\Restaurant\RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [App\Http\Controllers\Restaurant\RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [App\Http\Controllers\Restaurant\RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    
    // Sélection de plan
    Route::get('/subscription/select', [App\Http\Controllers\Restaurant\SubscriptionController::class, 'select'])->name('subscription.select');
    Route::get('/subscription/{plan}', [App\Http\Controllers\Restaurant\SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscription/{plan}/subscribe', [App\Http\Controllers\Restaurant\SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/subscription/select', [App\Http\Controllers\Restaurant\SubscriptionController::class, 'store'])->name('subscription.store');
    
    // Routes de paiement
    Route::get('/payment/{plan}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{plan}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/payment/transaction/{transaction}', [PaymentController::class, 'showTransaction'])->name('payment.transaction.show');
    Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::post('/payment/refund/{transaction}', [PaymentController::class, 'refund'])->name('payment.refund');
    
    // Routes de portefeuille (avec middleware de vérification restaurant)
    Route::middleware(['restaurant.owner'])->group(function () {
        Route::get('/wallet', [App\Http\Controllers\Restaurant\WalletController::class, 'index'])->name('wallet.index');
        Route::get('/wallet/withdrawal/create', [App\Http\Controllers\Restaurant\WalletController::class, 'createWithdrawal'])->name('wallet.withdrawal.create');
        Route::post('/wallet/withdrawal', [App\Http\Controllers\Restaurant\WalletController::class, 'storeWithdrawal'])->name('wallet.withdrawal.store');
        Route::get('/wallet/withdrawal/{withdrawalRequest}', [App\Http\Controllers\Restaurant\WalletController::class, 'showWithdrawal'])->name('wallet.withdrawal.show');
        Route::post('/wallet/withdrawal/{withdrawalRequest}/cancel', [App\Http\Controllers\Restaurant\WalletController::class, 'cancelWithdrawal'])->name('wallet.withdrawal.cancel');
        Route::get('/wallet/stats', [App\Http\Controllers\Restaurant\WalletController::class, 'getStats'])->name('wallet.stats');
        Route::post('/wallet/calculate-fees', [App\Http\Controllers\Restaurant\WalletController::class, 'calculateWithdrawalFees'])->name('wallet.calculate-fees');
    });
    
    // Gestion des produits
    Route::get('/products', [App\Http\Controllers\Restaurant\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Restaurant\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Restaurant\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [App\Http\Controllers\Restaurant\ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Restaurant\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Restaurant\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Restaurant\ProductController::class, 'destroy'])->name('products.destroy');
    
    // Gestion des catégories
    Route::get('/categories', [App\Http\Controllers\Restaurant\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [App\Http\Controllers\Restaurant\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\Restaurant\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [App\Http\Controllers\Restaurant\CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Restaurant\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Restaurant\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Restaurant\CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Gestion des commandes
    Route::get('/orders', [App\Http\Controllers\Restaurant\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [App\Http\Controllers\Restaurant\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\Restaurant\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [App\Http\Controllers\Restaurant\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Gestion du menu
    Route::get('/menu', [App\Http\Controllers\Restaurant\MenuController::class, 'index'])->name('menu.index');
});

// Routes de contournement pour éviter l'erreur 403

// Routes du backoffice restaurant
Route::middleware(['auth', 'user.role:restaurant,admin,super_admin', 'check.restaurant'])->prefix('restaurant')->name('restaurant.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Restaurant\DashboardController::class, 'index'])->name('dashboard');
    
    // Commandes
    Route::get('/orders', [App\Http\Controllers\Restaurant\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [App\Http\Controllers\Restaurant\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\Restaurant\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [App\Http\Controllers\Restaurant\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [App\Http\Controllers\Restaurant\OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/status', [App\Http\Controllers\Restaurant\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Menu et plats
    Route::get('/menu', function () {
        return view('restaurant.menu.index');
    })->name('menu.index');
    
    Route::get('/menu/create', function () {
        return view('restaurant.menu.create');
    })->name('menu.create');
    
    Route::get('/menu/{id}/edit', function ($id) {
        return view('restaurant.menu.edit', compact('id'));
    })->name('menu.edit');
    
    // Catégories
    Route::get('/categories', function () {
        return view('restaurant.categories.index');
    })->name('categories.index');
    
    Route::get('/categories/create', function () {
        return view('restaurant.categories.create');
    })->name('categories.create');
    
    // Clients
    Route::get('/customers', [App\Http\Controllers\Restaurant\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [App\Http\Controllers\Restaurant\CustomerController::class, 'show'])->name('customers.show');
    
    // Livraisons
    Route::get('/deliveries', [App\Http\Controllers\Restaurant\DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/{id}', [App\Http\Controllers\Restaurant\DeliveryController::class, 'show'])->name('deliveries.show');
    
    // Comptabilité
    Route::get('/accounting', [App\Http\Controllers\Restaurant\AccountingController::class, 'index'])->name('accounting.index');
    
    Route::get('/accounting/reports', function () {
        return view('restaurant.accounting.reports');
    })->name('accounting.reports');
    
    // Promotions
    Route::get('/promotions', [App\Http\Controllers\Restaurant\PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/promotions/create', [App\Http\Controllers\Restaurant\PromotionController::class, 'create'])->name('promotions.create');
    Route::post('/promotions', [App\Http\Controllers\Restaurant\PromotionController::class, 'store'])->name('promotions.store');
    Route::get('/promotions/{promotion}/edit', [App\Http\Controllers\Restaurant\PromotionController::class, 'edit'])->name('promotions.edit');
    Route::put('/promotions/{promotion}', [App\Http\Controllers\Restaurant\PromotionController::class, 'update'])->name('promotions.update');
    Route::delete('/promotions/{promotion}', [App\Http\Controllers\Restaurant\PromotionController::class, 'destroy'])->name('promotions.destroy');
    
    // Avis
    Route::get('/reviews', [App\Http\Controllers\Restaurant\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [App\Http\Controllers\Restaurant\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [App\Http\Controllers\Restaurant\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/{review}/reply', [App\Http\Controllers\Restaurant\ReviewController::class, 'reply'])->name('reviews.reply');
    
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Restaurant\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\Restaurant\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\Restaurant\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Restaurant\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread', [App\Http\Controllers\Restaurant\NotificationController::class, 'getUnread'])->name('notifications.unread');
    
    // Paramètres
    Route::get('/settings', [App\Http\Controllers\RestaurantSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\RestaurantSettingController::class, 'store'])->name('settings.store');
    Route::post('/settings/logo', [App\Http\Controllers\RestaurantSettingController::class, 'uploadLogo'])->name('settings.upload-logo');
    Route::post('/settings/cover', [App\Http\Controllers\RestaurantSettingController::class, 'uploadCover'])->name('settings.upload-cover');
    Route::post('/settings/gallery', [App\Http\Controllers\RestaurantSettingController::class, 'uploadGallery'])->name('settings.upload-gallery');
    Route::delete('/settings/gallery/{imageIndex}', [App\Http\Controllers\RestaurantSettingController::class, 'deleteGalleryImage'])->name('settings.delete-gallery-image');
    Route::post('/settings/theme', [App\Http\Controllers\RestaurantSettingController::class, 'updateTheme'])->name('settings.update-theme');
});

// Routes Admin
Route::middleware(['auth', 'admin.access'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', App\Http\Livewire\Admin\Dashboard::class)->name('dashboard');
    // Routes de test supprimées - Dashboard principal fonctionne maintenant
    Route::get('/dashboard-shadcn', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard.shadcn');
    Route::get('/dashboard/modern', [App\Http\Controllers\AdminController::class, 'modernDashboard'])->name('dashboard.modern');
    
    // Routes pour les nouvelles pages modernisées
    Route::get('/restaurants-new-design', App\Http\Livewire\Admin\Restaurants::class)->name('restaurants.new-design');

    Route::get('/users-new-design', App\Http\Livewire\Admin\UsersNewDesign::class)->name('users.new-design');

    Route::get('/orders-new-design', App\Http\Livewire\Admin\Orders::class)->name('orders.new-design');

    Route::get('/payments-new-design', App\Http\Livewire\Admin\Payments::class)->name('payments.new-design');

    Route::get('/reports-new-design', App\Http\Livewire\Admin\Reports::class)->name('reports.new-design');

    Route::get('/settings-new-design', App\Http\Livewire\Admin\Settings::class)->name('settings.new-design');
    
    // Routes pour les catégories (Livewire)
    Route::get('/categories', App\Http\Livewire\Admin\CategoriesFixed::class)->name('categories.index');
    Route::get('/categories/create', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\AdminController::class, 'destroyCategory'])->name('categories.destroy');
    
    // Routes CRUD complètes pour Restaurants (Livewire)
    Route::get('/restaurants', App\Http\Livewire\Admin\RestaurantsFixed::class)->name('restaurants.index');
    Route::get('/restaurants/create', [App\Http\Controllers\AdminController::class, 'createRestaurant'])->name('restaurants.create');
    Route::post('/restaurants', [App\Http\Controllers\AdminController::class, 'storeRestaurant'])->name('restaurants.store');
    Route::get('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'showRestaurant'])->name('restaurants.show');
    Route::get('/restaurants/{restaurant}/edit', [App\Http\Controllers\AdminController::class, 'editRestaurant'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'updateRestaurant'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'destroyRestaurant'])->name('restaurants.destroy');

    // Routes CRUD complètes pour Users (Livewire)
    Route::get('/users', App\Http\Livewire\Admin\UsersFinal::class)->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');

    // Routes CRUD complètes pour Orders (Livewire)
    Route::get('/orders', App\Http\Livewire\Admin\OrdersFixed::class)->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\AdminController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders/{order}/edit', [App\Http\Controllers\AdminController::class, 'editOrder'])->name('orders.edit');
    Route::put('/orders/{order}', [App\Http\Controllers\AdminController::class, 'updateOrder'])->name('orders.update');
    Route::delete('/orders/{order}', [App\Http\Controllers\AdminController::class, 'destroyOrder'])->name('orders.destroy');

    // Routes CRUD complètes pour Products (Livewire)
    Route::get('/products', App\Http\Livewire\Admin\Products::class)->name('products.index');
    Route::get('/products/{product}', [App\Http\Controllers\AdminController::class, 'showProduct'])->name('products.show');
    Route::delete('/products/{product}', [App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::post('/products/{product}/toggle-status', [App\Http\Controllers\AdminController::class, 'updateProductStatus'])->name('products.toggle-status');
    Route::post('/products/{product}/toggle-featured', [App\Http\Controllers\AdminController::class, 'toggleProductFeatured'])->name('products.toggle-featured');
    Route::post('/products/export', [App\Http\Controllers\AdminController::class, 'exportProducts'])->name('products.export');

    // Routes CRUD complètes pour Promotions
    Route::get('/promotions', App\Http\Livewire\Admin\Promotions::class)->name('promotions.index');
    Route::get('/promotions/create', [App\Http\Controllers\AdminController::class, 'createPromotion'])->name('promotions.create');
    Route::post('/promotions', [App\Http\Controllers\AdminController::class, 'storePromotion'])->name('promotions.store');
    Route::get('/promotions/{promotion}/edit', [App\Http\Controllers\AdminController::class, 'editPromotion'])->name('promotions.edit');
    Route::put('/promotions/{promotion}', [App\Http\Controllers\AdminController::class, 'updatePromotion'])->name('promotions.update');
    Route::delete('/promotions/{promotion}', [App\Http\Controllers\AdminController::class, 'destroyPromotion'])->name('promotions.destroy');

    // Routes CRUD complètes pour Reviews
    Route::get('/reviews', App\Http\Livewire\Admin\Reviews::class)->name('reviews.index');
    Route::get('/reviews/{review}', [App\Http\Controllers\AdminController::class, 'showReview'])->name('reviews.show');
    Route::post('/reviews/{review}/toggle-status', [App\Http\Controllers\AdminController::class, 'updateReviewStatus'])->name('reviews.toggle-status');

    // Routes CRUD complètes pour Notifications (Livewire déjà défini plus bas)
    Route::get('/notifications/create', [App\Http\Controllers\AdminController::class, 'createNotification'])->name('notifications.create');
    Route::post('/notifications', [App\Http\Controllers\AdminController::class, 'storeNotification'])->name('notifications.store');
    Route::get('/notifications/{notification}', [App\Http\Controllers\AdminController::class, 'showNotification'])->name('notifications.show');
    Route::get('/notifications/{notification}/edit', [App\Http\Controllers\AdminController::class, 'editNotification'])->name('notifications.edit');
    Route::put('/notifications/{notification}', [App\Http\Controllers\AdminController::class, 'updateNotification'])->name('notifications.update');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\AdminController::class, 'destroyNotification'])->name('notifications.destroy');
    Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\AdminController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/{notification}/mark-unread', [App\Http\Controllers\AdminController::class, 'markNotificationAsUnread'])->name('notifications.mark-unread');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\AdminController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/send-to-all', [App\Http\Controllers\AdminController::class, 'sendNotificationToAll'])->name('notifications.send-to-all');

    // Routes CRUD complètes pour Messages
    Route::get('/messages', App\Http\Livewire\Admin\Messages::class)->name('messages.index');
    Route::get('/messages/create', [App\Http\Controllers\AdminController::class, 'createMessage'])->name('messages.create');
    Route::post('/messages', [App\Http\Controllers\AdminController::class, 'storeMessage'])->name('messages.store');
    Route::get('/messages/{message}/edit', [App\Http\Controllers\AdminController::class, 'editMessage'])->name('messages.edit');
    Route::put('/messages/{message}', [App\Http\Controllers\AdminController::class, 'updateMessage'])->name('messages.update');
    Route::delete('/messages/{message}', [App\Http\Controllers\AdminController::class, 'destroyMessage'])->name('messages.destroy');

    // Routes CRUD complètes pour Invoices
    Route::get('/invoices', App\Http\Livewire\Admin\Invoices::class)->name('invoices.index');
    // Route::get('/invoices/create', [App\Http\Controllers\AdminController::class, 'createInvoice'])->name('invoices.create');
    // Route::post('/invoices', [App\Http\Controllers\AdminController::class, 'storeInvoice'])->name('invoices.store');
    // Route::get('/invoices/{invoice}', [App\Http\Controllers\AdminController::class, 'showInvoice'])->name('invoices.show');
    // Route::get('/invoices/{invoice}/edit', [App\Http\Controllers\AdminController::class, 'editInvoice'])->name('invoices.edit');
    // Route::put('/invoices/{invoice}', [App\Http\Controllers\AdminController::class, 'updateInvoice'])->name('invoices.update');
    // Route::delete('/invoices/{invoice}', [App\Http\Controllers\AdminController::class, 'destroyInvoice'])->name('invoices.destroy');

    // Routes CRUD complètes pour Payment Gateways
    Route::get('/payment-gateways', App\Http\Livewire\Admin\PaymentGateways::class)->name('payment-gateways.index');
    Route::get('/payment-gateways/create', [App\Http\Controllers\AdminController::class, 'createPaymentGateway'])->name('payment-gateways.create');
    Route::post('/payment-gateways', [App\Http\Controllers\AdminController::class, 'storePaymentGateway'])->name('payment-gateways.store');
    Route::get('/payment-gateways/{paymentGateway}', [App\Http\Controllers\AdminController::class, 'showPaymentGateway'])->name('payment-gateways.show');
    Route::get('/payment-gateways/{paymentGateway}/edit', [App\Http\Controllers\AdminController::class, 'editPaymentGateway'])->name('payment-gateways.edit');
    Route::put('/payment-gateways/{paymentGateway}', [App\Http\Controllers\AdminController::class, 'updatePaymentGateway'])->name('payment-gateways.update');
    Route::delete('/payment-gateways/{paymentGateway}', [App\Http\Controllers\AdminController::class, 'destroyPaymentGateway'])->name('payment-gateways.destroy');

    // Routes CRUD complètes pour Tenants
    Route::get('/tenants', App\Http\Livewire\Admin\Tenants::class)->name('tenants.index');
    Route::get('/tenants/create', [App\Http\Controllers\AdminController::class, 'createTenant'])->name('tenants.create');
    Route::post('/tenants', [App\Http\Controllers\AdminController::class, 'storeTenant'])->name('tenants.store');
    Route::get('/tenants/{tenant}/edit', [App\Http\Controllers\AdminController::class, 'editTenant'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [App\Http\Controllers\AdminController::class, 'updateTenant'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [App\Http\Controllers\AdminController::class, 'destroyTenant'])->name('tenants.destroy');

    // Routes CRUD complètes pour Subscription Plans
    Route::get('/subscription-plans', App\Http\Livewire\Admin\SubscriptionPlans::class)->name('subscription-plans.index');
    Route::get('/subscription-plans/create', [App\Http\Controllers\AdminController::class, 'createSubscriptionPlan'])->name('subscription-plans.create');
    Route::post('/subscription-plans', [App\Http\Controllers\AdminController::class, 'storeSubscriptionPlan'])->name('subscription-plans.store');
    Route::get('/subscription-plans/{subscriptionPlan}', [App\Http\Controllers\AdminController::class, 'showSubscriptionPlan'])->name('subscription-plans.show');
    Route::get('/subscription-plans/{subscriptionPlan}/edit', [App\Http\Controllers\AdminController::class, 'editSubscriptionPlan'])->name('subscription-plans.edit');
    Route::put('/subscription-plans/{subscriptionPlan}', [App\Http\Controllers\AdminController::class, 'updateSubscriptionPlan'])->name('subscription-plans.update');
    Route::delete('/subscription-plans/{subscriptionPlan}', [App\Http\Controllers\AdminController::class, 'destroySubscriptionPlan'])->name('subscription-plans.destroy');

    // Routes CRUD complètes pour Payments
    Route::get('/payments', [App\Http\Controllers\AdminController::class, 'payments'])->name('payments.index');
    Route::get('/payments/create', [App\Http\Controllers\AdminController::class, 'createPayment'])->name('payments.create');
    Route::post('/payments', [App\Http\Controllers\AdminController::class, 'storePayment'])->name('payments.store');
    Route::get('/payments/{payment}/edit', [App\Http\Controllers\AdminController::class, 'editPayment'])->name('payments.edit');
    Route::put('/payments/{payment}', [App\Http\Controllers\AdminController::class, 'updatePayment'])->name('payments.update');
    Route::delete('/payments/{payment}', [App\Http\Controllers\AdminController::class, 'destroyPayment'])->name('payments.destroy');

    // Routes CRUD complètes pour Withdrawals
    Route::get('/withdrawals', App\Http\Livewire\Admin\Withdrawals::class)->name('withdrawals.index');
    Route::get('/withdrawals/create', [App\Http\Controllers\AdminController::class, 'createWithdrawal'])->name('withdrawals.create');
    Route::post('/withdrawals', [App\Http\Controllers\AdminController::class, 'storeWithdrawal'])->name('withdrawals.store');
    Route::get('/withdrawals/{withdrawal}', [App\Http\Controllers\AdminController::class, 'showWithdrawal'])->name('withdrawals.show');
    Route::get('/withdrawals/{withdrawal}/edit', [App\Http\Controllers\AdminController::class, 'editWithdrawal'])->name('withdrawals.edit');
    Route::put('/withdrawals/{withdrawal}', [App\Http\Controllers\AdminController::class, 'updateWithdrawal'])->name('withdrawals.update');
    Route::delete('/withdrawals/{withdrawal}', [App\Http\Controllers\AdminController::class, 'destroyWithdrawal'])->name('withdrawals.destroy');

    // Routes pour Analytics et Reports
    Route::get('/analytics', App\Http\Livewire\Admin\Analytics::class)->name('analytics.index');
    Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/orders', [App\Http\Controllers\AdminController::class, 'ordersReport'])->name('reports.orders');
    Route::get('/reports/revenue', [App\Http\Controllers\AdminController::class, 'revenueReport'])->name('reports.revenue');
    Route::get('/reports/restaurants', [App\Http\Controllers\AdminController::class, 'restaurantsReport'])->name('reports.restaurants');
    Route::post('/reports/export', [App\Http\Controllers\AdminController::class, 'exportReport'])->name('reports.export');

    // Routes pour Settings
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Routes pour le profil admin
    Route::get('/profile', App\Http\Livewire\Admin\Profile::class)->name('profile.show');
    
    // Routes de test
    // Routes de test supprimées - backoffice maintenant fonctionnel
    Route::get('/profile/edit', [App\Http\Controllers\AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [App\Http\Controllers\AdminController::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [App\Http\Controllers\AdminController::class, 'updatePassword'])->name('profile.password');
    
    // Routes pour le support (Livewire)
    Route::get('/support', App\Http\Livewire\Admin\SupportFixed::class)->name('support.index');
    
    // Routes pour les vidéos (Livewire)
    Route::get('/videos', App\Http\Livewire\Admin\VideosFixed::class)->name('videos.index');
    Route::get('/videos/create', [App\Http\Controllers\AdminController::class, 'createVideo'])->name('videos.create');
    Route::post('/videos', [App\Http\Controllers\AdminController::class, 'storeVideo'])->name('videos.store');
    Route::get('/videos/export', [App\Http\Controllers\AdminController::class, 'exportVideos'])->name('videos.export');
    
    // Routes pour les transactions (Livewire)
    Route::get('/payment-transactions', App\Http\Livewire\Admin\Payments::class)->name('payment-transactions.index');
    
    // Routes pour les factures (Livewire)
    Route::get('/invoices', App\Http\Livewire\Admin\Invoices::class)->name('invoices.index');
    
    // Routes pour les promotions (Livewire)
    Route::get('/promotions', App\Http\Livewire\Admin\Promotions::class)->name('promotions.index');
    
    // Routes pour les plans d'abonnement (Livewire)
    Route::get('/subscription-plans', App\Http\Livewire\Admin\SubscriptionPlans::class)->name('subscription-plans.index');
    
    Route::get('/test-modern', function () {
        return view('admin.test-modern');
    })->name('test.modern');
    
    // Routes Super Admin
    Route::get('/super-admin/dashboard', function () {
        $stats = [
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
            'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
            'today_orders' => \App\Models\Order::whereDate('created_at', today())->count(),
            'total_users' => \App\Models\User::count(),
        ];
        
        // Top restaurants avec statistiques
        $topRestaurants = \App\Models\Restaurant::withSum('orders', 'total_amount')
            ->withCount('orders')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.super-admin.dashboard', compact('stats', 'topRestaurants'));
    })->name('super-admin.dashboard');
    
    // Routes Super Admin Modernes
    Route::get('/super-admin/dashboard-modern', function () {
        $stats = [
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
            'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
            'today_orders' => \App\Models\Order::whereDate('created_at', today())->count(),
            'total_users' => \App\Models\User::count(),
        ];
        
        // Top restaurants avec statistiques
        $topRestaurants = \App\Models\Restaurant::withSum('orders', 'total_amount')
            ->withCount('orders')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.super-admin.dashboard-modern', compact('stats', 'topRestaurants'));
    })->name('super-admin.dashboard.modern');
    
    Route::get('/super-admin/control-panel', function () {
        return view('admin.super-admin.control-panel');
    })->name('super-admin.control-panel');
    
    Route::get('/super-admin/control-panel-modern', function () {
        return view('admin.super-admin.control-panel-modern');
    })->name('super-admin.control-panel.modern');
    
Route::get('/super-admin/monitoring', function () {
    return view('admin.super-admin.monitoring');
})->name('super-admin.monitoring');

Route::get('/super-admin/monitoring-modern', function () {
    return view('admin.super-admin.monitoring-modern');
})->name('super-admin.monitoring.modern');

Route::get('/super-admin/test-responsiveness', function () {
    return view('admin.test-responsiveness');
})->name('super-admin.test-responsiveness');

Route::get('/super-admin/demo', function () {
    return view('admin.super-admin-demo');
})->name('super-admin.demo');

// Route pour le nouveau design
Route::get('/super-admin/dashboard-new-design', function () {
    $stats = [
        'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
        'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
        'today_orders' => \App\Models\Order::whereDate('created_at', today())->count(),
        'total_users' => \App\Models\User::count(),
    ];
    return view('admin.super-admin.dashboard-new-design', compact('stats'));
})->name('super-admin.dashboard.new-design');

Route::get('/super-admin/new-design-demo', function () {
    return view('admin.super-admin-new-design-demo');
})->name('super-admin.new-design.demo');

    Route::get('/dashboard-modern', function () {
        $stats = [
            'total_restaurants' => 25,
            'total_users' => 150,
            'today_orders' => 89,
            'revenue' => 2500000
        ];
        return view('admin.dashboard.modern', compact('stats'));
    })->name('admin.dashboard.modern');
    
    Route::get('/shadcn-demo', function () {
        return view('admin.shadcn-demo');
    })->name('shadcn-demo');
    
    Route::get('/shadcn-complete', function () {
        return view('admin.shadcn-complete-demo');
    })->name('shadcn-complete');
    
    Route::get('/users-shadcn', [App\Http\Controllers\AdminController::class, 'users'])->name('users.shadcn');
    
    // CRUD Restaurants - Remplacé par Livewire plus haut
    // Route::get('/restaurants', [App\Http\Controllers\AdminController::class, 'restaurants'])->name('restaurants.index');
    // Route::get('/restaurants/create', [App\Http\Controllers\AdminController::class, 'createRestaurant'])->name('restaurants.create');
    // Route::post('/restaurants', [App\Http\Controllers\AdminController::class, 'storeRestaurant'])->name('restaurants.store');
    // Route::get('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'showRestaurant'])->name('restaurants.show');
    // Route::get('/restaurants/{restaurant}/edit', [App\Http\Controllers\AdminController::class, 'editRestaurant'])->name('restaurants.edit');
    // Route::put('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'updateRestaurant'])->name('restaurants.update');
    // Route::delete('/restaurants/{restaurant}', [App\Http\Controllers\AdminController::class, 'destroyRestaurant'])->name('restaurants.destroy');
    
    // CRUD Utilisateurs - Remplacé par Livewire plus haut
    // Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    // Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    // Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    // Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('users.show');
    // Route::get('/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    // Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    // Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // CRUD Tenants
    Route::get('/tenants', App\Http\Livewire\Admin\Tenants::class)->name('tenants.index');
    Route::get('/tenants/create', [App\Http\Controllers\AdminController::class, 'createTenant'])->name('tenants.create');
    Route::post('/tenants', [App\Http\Controllers\AdminController::class, 'storeTenant'])->name('tenants.store');
    Route::get('/tenants/{tenant}/edit', [App\Http\Controllers\AdminController::class, 'editTenant'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [App\Http\Controllers\AdminController::class, 'updateTenant'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [App\Http\Controllers\AdminController::class, 'destroyTenant'])->name('tenants.destroy');
    
    // CRUD Vidéos - Routes pour la gestion des vidéos
    Route::get('/videos/{video}', [App\Http\Controllers\Admin\VideoController::class, 'show'])->name('videos.show');
    Route::get('/videos/{video}/edit', [App\Http\Controllers\Admin\VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{video}', [App\Http\Controllers\Admin\VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [App\Http\Controllers\Admin\VideoController::class, 'destroy'])->name('videos.destroy');
    Route::post('/videos/{video}/toggle-active', [App\Http\Controllers\Admin\VideoController::class, 'toggleActive'])->name('videos.toggle-active');
    Route::post('/videos/{video}/toggle-featured', [App\Http\Controllers\Admin\VideoController::class, 'toggleFeatured'])->name('videos.toggle-featured');
    
    // CRUD Plans d'Abonnement
    Route::get('/subscription-plans', App\Http\Livewire\Admin\SubscriptionPlans::class)->name('subscription-plans.index');
    Route::get('/subscription-plans/create', [App\Http\Controllers\AdminController::class, 'createSubscriptionPlan'])->name('subscription-plans.create');
    Route::post('/subscription-plans', [App\Http\Controllers\AdminController::class, 'storeSubscriptionPlan'])->name('subscription-plans.store');
    Route::get('/subscription-plans/{plan}/edit', [App\Http\Controllers\AdminController::class, 'editSubscriptionPlan'])->name('subscription-plans.edit');
    Route::put('/subscription-plans/{plan}', [App\Http\Controllers\AdminController::class, 'updateSubscriptionPlan'])->name('subscription-plans.update');
    Route::delete('/subscription-plans/{plan}', [App\Http\Controllers\AdminController::class, 'destroySubscriptionPlan'])->name('subscription-plans.destroy');

    // ===== PHASE 2: SYSTÈME DE PAIEMENTS =====
    
    // Gestion des Paiements
    Route::get('/payments', [App\Http\Controllers\AdminController::class, 'payments'])->name('payments.index');
    Route::get('/payments/create', [App\Http\Controllers\AdminController::class, 'createPayment'])->name('payments.create');
    Route::post('/payments', [App\Http\Controllers\AdminController::class, 'storePayment'])->name('payments.store');
    Route::get('/payments/{payment}/edit', [App\Http\Controllers\AdminController::class, 'editPayment'])->name('payments.edit');
    Route::put('/payments/{payment}', [App\Http\Controllers\AdminController::class, 'updatePayment'])->name('payments.update');
    Route::delete('/payments/{payment}', [App\Http\Controllers\AdminController::class, 'destroyPayment'])->name('payments.destroy');

    // Gestion des Passerelles de Paiement
    Route::get('/payment-gateways', App\Http\Livewire\Admin\PaymentGateways::class)->name('payment-gateways.index');
    Route::get('/payment-gateways/create', [App\Http\Controllers\AdminController::class, 'createPaymentGateway'])->name('payment-gateways.create');
    Route::post('/payment-gateways', [App\Http\Controllers\AdminController::class, 'storePaymentGateway'])->name('payment-gateways.store');
    Route::get('/payment-gateways/{paymentGateway}/edit', [App\Http\Controllers\AdminController::class, 'editPaymentGateway'])->name('payment-gateways.edit');
    Route::put('/payment-gateways/{paymentGateway}', [App\Http\Controllers\AdminController::class, 'updatePaymentGateway'])->name('payment-gateways.update');
    Route::delete('/payment-gateways/{paymentGateway}', [App\Http\Controllers\AdminController::class, 'destroyPaymentGateway'])->name('payment-gateways.destroy');

    // Gestion des Transactions de Paiement
    // Route::get('/payment-transactions', [App\Http\Controllers\AdminController::class, 'paymentTransactions'])->name('payment-transactions.index');

    // Gestion des Factures
    Route::get('/invoices', App\Http\Livewire\Admin\Invoices::class)->name('invoices.index');
    Route::get('/invoices/create', [App\Http\Controllers\AdminController::class, 'createInvoice'])->name('invoices.create');
    Route::post('/invoices', [App\Http\Controllers\AdminController::class, 'storeInvoice'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [App\Http\Controllers\AdminController::class, 'editInvoice'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [App\Http\Controllers\AdminController::class, 'updateInvoice'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [App\Http\Controllers\AdminController::class, 'destroyInvoice'])->name('invoices.destroy');

    // Gestion des Commandes Globales - Remplacé par Livewire plus haut
    // Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders.index');
    // Route::get('/orders/{order}', [App\Http\Controllers\AdminController::class, 'showOrder'])->name('orders.show');
    // Route::get('/orders/{order}/edit', [App\Http\Controllers\AdminController::class, 'editOrder'])->name('orders.edit');
    // Route::put('/orders/{order}', [App\Http\Controllers\AdminController::class, 'updateOrder'])->name('orders.update');
    // Route::put('/orders/{order}/status', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    // Route::delete('/orders/{order}', [App\Http\Controllers\AdminController::class, 'destroyOrder'])->name('orders.destroy');

    // Gestion Globale des Produits (Livewire)
    Route::get('/products', App\Http\Livewire\Admin\Products::class)->name('products.index');
    Route::get('/products/{product}', [App\Http\Controllers\AdminController::class, 'showProduct'])->name('products.show');
    Route::put('/products/{product}/status', [App\Http\Controllers\AdminController::class, 'updateProductStatus'])->name('products.update-status');
    Route::put('/products/{product}/featured', [App\Http\Controllers\AdminController::class, 'toggleProductFeatured'])->name('products.toggle-featured');
    Route::delete('/products/{product}', [App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/products/export', [App\Http\Controllers\AdminController::class, 'exportProducts'])->name('products.export');

    // ===== PHASE 3: ANALYTICS ET RAPPORTS =====
    
    // Analytics et Rapports
    Route::get('/analytics', App\Http\Livewire\Admin\Analytics::class)->name('analytics.index');
    Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/orders', [App\Http\Controllers\AdminController::class, 'ordersReport'])->name('reports.orders');
    Route::get('/reports/revenue', [App\Http\Controllers\AdminController::class, 'revenueReport'])->name('reports.revenue');
    Route::get('/reports/restaurants', [App\Http\Controllers\AdminController::class, 'restaurantsReport'])->name('reports.restaurants');
    Route::get('/reports/export', [App\Http\Controllers\AdminController::class, 'exportReport'])->name('reports.export');
    Route::get('/reports/restaurants/export', [App\Http\Controllers\AdminController::class, 'exportRestaurantsReport'])->name('reports.restaurants.export');
    Route::get('/reports/orders/export', [App\Http\Controllers\AdminController::class, 'exportOrdersReport'])->name('reports.orders.export');
    
    // Routes de gestion des retraits
    // Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/{withdrawalRequest}', [App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals/{withdrawalRequest}/approve', [App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawalRequest}/reject', [App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    Route::post('/withdrawals/{withdrawalRequest}/process', [App\Http\Controllers\Admin\WithdrawalController::class, 'process'])->name('withdrawals.process');
    Route::get('/withdrawals/stats', [App\Http\Controllers\Admin\WithdrawalController::class, 'stats'])->name('withdrawals.stats');
    Route::get('/withdrawals/export', [App\Http\Controllers\Admin\WithdrawalController::class, 'export'])->name('withdrawals.export');

    // Gestion des Promotions
    Route::get('/promotions', App\Http\Livewire\Admin\Promotions::class)->name('promotions.index');
    Route::get('/promotions/create', [App\Http\Controllers\AdminController::class, 'createPromotion'])->name('promotions.create');
    Route::post('/promotions', [App\Http\Controllers\AdminController::class, 'storePromotion'])->name('promotions.store');
    Route::get('/promotions/{promotion}/edit', [App\Http\Controllers\AdminController::class, 'editPromotion'])->name('promotions.edit');
    Route::put('/promotions/{promotion}', [App\Http\Controllers\AdminController::class, 'updatePromotion'])->name('promotions.update');
    Route::delete('/promotions/{promotion}', [App\Http\Controllers\AdminController::class, 'destroyPromotion'])->name('promotions.destroy');
    Route::get('/promotions/export', [App\Http\Controllers\AdminController::class, 'exportPromotions'])->name('promotions.export');

    // Gestion des Avis et Reviews
    Route::get('/reviews', App\Http\Livewire\Admin\Reviews::class)->name('reviews.index');
    Route::get('/reviews/{review}', [App\Http\Controllers\AdminController::class, 'showReview'])->name('reviews.show');
    Route::put('/reviews/{review}/status', [App\Http\Controllers\AdminController::class, 'updateReviewStatus'])->name('reviews.update-status');
    Route::get('/reviews/export', [App\Http\Controllers\AdminController::class, 'exportReviews'])->name('reviews.export');

    // Gestion des Notifications (Livewire)
    Route::get('/notifications', App\Http\Livewire\Admin\Notifications::class)->name('notifications.index');
    Route::get('/send-notification', App\Http\Livewire\Admin\SendNotification::class)->name('send-notification.index');
    Route::post('/notifications/{notification}/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    
    // Marketing Digital
    Route::get('/marketing', App\Http\Livewire\Admin\Marketing::class)->name('marketing.index');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/create-bulk', [App\Http\Controllers\Admin\NotificationController::class, 'createBulk'])->name('notifications.create-bulk');
    Route::post('/notifications/send-bulk', [App\Http\Controllers\Admin\NotificationController::class, 'sendBulk'])->name('notifications.send-bulk');
    Route::post('/notifications/test', [App\Http\Controllers\Admin\NotificationController::class, 'test'])->name('notifications.test');
    Route::get('/notifications/unread', [App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->name('notifications.unread');

    // Paramètres du Système
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
    
});

// Routes publiques
Route::get('/features', [FeaturesController::class, 'index'])->name('features');
Route::get('/about', function () {
    return view('landing.about');
})->name('about');
Route::get('/pricing', function () {
    return view('landing.pricing');
})->name('pricing');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Routes publiques des restaurants
Route::get('/restaurant/{slug}', [RestaurantController::class, 'show'])->name('restaurant.show');
Route::get('/restaurant/{slug}/checkout', [RestaurantController::class, 'checkout'])->name('restaurant.checkout');

// Routes de commandes (publiques)
Route::post('/restaurant/{slug}/order', [App\Http\Controllers\OrderController::class, 'store'])->name('restaurant.order.store');
Route::get('/order/confirmation/{orderNumber}', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('order.confirmation');

// Routes de factures
Route::get('/invoice/{order}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
Route::get('/invoice/{order}/print', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoice.print');
Route::get('/invoice/{order}/preview', [App\Http\Controllers\InvoiceController::class, 'preview'])->name('invoice.preview');
Route::get('/invoice/{order}/receipt', [App\Http\Controllers\InvoiceController::class, 'receipt'])->name('invoice.receipt');
Route::get('/invoice/{order}/ticket', [App\Http\Controllers\InvoiceController::class, 'ticket'])->name('invoice.ticket');
Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');

// Routes de suivi des commandes (publiques)
Route::get('/order/track/{orderNumber}', [App\Http\Controllers\OrderTrackingController::class, 'track'])->name('order.tracking');
Route::get('/order/receipt/{orderNumber}', [App\Http\Controllers\OrderTrackingController::class, 'showReceipt'])->name('order.receipt');
Route::get('/order/download/{orderNumber}', [App\Http\Controllers\OrderTrackingController::class, 'downloadReceipt'])->name('order.download');
Route::post('/order/check-status', [App\Http\Controllers\OrderTrackingController::class, 'checkStatus'])->name('order.check-status');

// Routes des avis (publiques)
Route::get('/order/{orderNumber}/review', [App\Http\Controllers\ReviewController::class, 'showReviewForm'])->name('order.review');
Route::post('/order/{orderNumber}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('order.review.store');
Route::get('/restaurant/{slug}/reviews', [App\Http\Controllers\ReviewController::class, 'showRestaurantReviews'])->name('restaurant.reviews');

// ===== ROUTES DE PAIEMENT =====
// Routes publiques de paiement
Route::prefix('payment')->name('payment.')->group(function () {
    // Initialisation et vérification des paiements
    Route::post('/initialize', [App\Http\Controllers\PaymentController::class, 'initialize'])->name('initialize');
    Route::post('/verify', [App\Http\Controllers\PaymentController::class, 'verify'])->name('verify');
    
    // Pages de résultat
    Route::get('/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('success');
    Route::get('/failure', [App\Http\Controllers\PaymentController::class, 'failure'])->name('failure');
    
    // Webhooks des passerelles de paiement
    Route::post('/webhook/wave', [App\Http\Controllers\PaymentController::class, 'webhookWave'])->name('webhook.wave');
    Route::post('/webhook/paystack', [App\Http\Controllers\PaymentController::class, 'webhookPaystack'])->name('webhook.paystack');
    Route::post('/webhook/flutterwave', [App\Http\Controllers\PaymentController::class, 'webhookFlutterwave'])->name('webhook.flutterwave');
    
    // API pour obtenir les passerelles et calculer les frais
    Route::get('/gateways', [App\Http\Controllers\PaymentController::class, 'getGateways'])->name('gateways');
    Route::post('/calculate-fees', [App\Http\Controllers\PaymentController::class, 'calculateFees'])->name('calculate-fees');
    Route::get('/transaction-history', [App\Http\Controllers\PaymentController::class, 'getTransactionHistory'])->name('transaction-history');
});

    // Gestion des commandes
    Route::get('/orders', [App\Http\Controllers\RestaurantOrderController::class, 'index'])->name('restaurant.orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\RestaurantOrderController::class, 'show'])->name('restaurant.orders.show');
    Route::post('/orders/{id}/update-status', [App\Http\Controllers\RestaurantOrderController::class, 'updateStatus'])->name('restaurant.orders.update-status');
    Route::post('/orders/{id}/cancel', [App\Http\Controllers\RestaurantOrderController::class, 'cancel'])->name('restaurant.orders.cancel');
    Route::post('/orders/{id}/mark-ready', [App\Http\Controllers\RestaurantOrderController::class, 'markAsReady'])->name('restaurant.orders.mark-ready');
    Route::get('/orders-ajax/get-orders', [App\Http\Controllers\RestaurantOrderController::class, 'getOrders'])->name('restaurant.orders.ajax.get-orders');
    Route::get('/orders-ajax/get-stats', [App\Http\Controllers\RestaurantOrderController::class, 'getStats'])->name('restaurant.orders.ajax.get-stats');

 
// Routes de contournement radicales (sans aucun middleware)
Route::get('/create-restaurant', function() {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté.');
    }
    return view('restaurant.restaurants.create');
})->name('create.restaurant');

Route::get('/select-subscription', function() {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté.');
    }
    $plans = \App\Models\SubscriptionPlan::all();
    return view('subscription.select', compact('plans'));
})->name('select.subscription');


// Route de test pour vérifier que tout fonctionne
Route::get('/test-restaurant', function() {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté.');
    }
    return view('test.restaurant-create');
})->name('test.restaurant');


// Route de test pour vérifier que tout fonctionne
Route::get('/test-403-fix', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'Erreur 403 corrigée !',
        'user' => auth()->user() ? auth()->user()->name : 'Non connecté',
        'timestamp' => now()
    ]);
});


// Route de test pour vérifier que tout fonctionne
Route::get('/test-403-fix', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'Erreur 403 corrigée !',
        'user' => auth()->user() ? auth()->user()->name : 'Non connecté',
        'timestamp' => now()
    ]);
});

