@props([
    'title' => 'Critères du plan',
    'criteria' => [],
    'selectedCriteria' => [],
    'onCriteriaChange' => null
])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center mb-6">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-filter text-white text-lg"></i>
        </div>
        <div>
            <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
            <p class="text-sm text-gray-500">Sélectionnez les critères pour ce plan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($criteria as $key => $criterion)
        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <input type="checkbox" 
                           id="criterion_{{ $key }}"
                           name="criteria[]"
                           value="{{ $key }}"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           @if(in_array($key, $selectedCriteria)) checked @endif
                           @if($onCriteriaChange) wire:change="{{ $onCriteriaChange }}" @endif>
                </div>
                <div class="flex-1 min-w-0">
                    <label for="criterion_{{ $key }}" class="block text-sm font-medium text-gray-900 cursor-pointer">
                        {{ $criterion['name'] }}
                    </label>
                    @if(isset($criterion['description']))
                    <p class="text-xs text-gray-500 mt-1">{{ $criterion['description'] }}</p>
                    @endif
                    @if(isset($criterion['value']))
                    <div class="mt-2">
                        <input type="number" 
                               name="criterion_value_{{ $key }}"
                               value="{{ $criterion['value'] ?? '' }}"
                               placeholder="Valeur"
                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(empty($criteria))
    <div class="text-center py-8">
        <i class="fas fa-filter text-gray-400 text-3xl mb-3"></i>
        <p class="text-gray-500">Aucun critère disponible</p>
    </div>
    @endif
</div>
