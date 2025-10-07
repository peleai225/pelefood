<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Avis</h1>
            <p class="text-gray-600 mt-2">Gérez tous les avis clients</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        @if($reviews->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($reviews as $review)
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">
                                            {{ $review->user->name ?? 'Client anonyme' }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $review->restaurant->name ?? 'Restaurant' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-sm {{ $i <= ($review->rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            {{ $review->created_at ? $review->created_at->diffForHumans() : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($review->review_comment)
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ $review->review_comment }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>Commande #{{ $review->id }}</span>
                                        <span>{{ number_format($review->total_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($review->status === 'delivered') bg-green-100 text-green-800
                                            @elseif($review->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($review->status ?? 'En cours') }}
                                        </span>
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-star text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun avis</h3>
                <p class="text-gray-500 mb-6">Aucun avis client pour le moment.</p>
            </div>
        @endif
    </div>
</div>