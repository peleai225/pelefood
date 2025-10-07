@props([
    'title' => '',
    'icon' => 'info-circle',
    'iconColor' => 'blue',
    'description' => '',
    'columns' => 1, // 1, 2, 3, 4
    'spacing' => 'normal' // compact, normal, relaxed
])

@php
$iconColors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600', 
    'purple' => 'bg-purple-100 text-purple-600',
    'orange' => 'bg-orange-100 text-orange-600',
    'red' => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'gray' => 'bg-gray-100 text-gray-600'
];

$columnClasses = [
    1 => 'grid-cols-1',
    2 => 'grid-cols-1 md:grid-cols-2', 
    3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
];

$spacingClasses = [
    'compact' => 'space-y-4',
    'normal' => 'space-y-6', 
    'relaxed' => 'space-y-8'
];
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <!-- En-tête de la section -->
    <div class="flex items-center mb-6">
        <div class="w-10 h-10 {{ $iconColors[$iconColor] }} rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-{{ $icon }} text-lg"></i>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-900">{{ $title }}</h2>
            @if($description)
            <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
            @endif
        </div>
    </div>
    
    <!-- Contenu de la section -->
    <div class="grid {{ $columnClasses[$columns] }} gap-6 {{ $spacingClasses[$spacing] }}">
        {{ $slot }}
    </div>
</div>
