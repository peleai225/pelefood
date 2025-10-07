@props([
    'show' => false,
    'title' => '',
    'size' => 'md', // sm, md, lg, xl, 2xl
    'closeable' => true,
    'persistent' => false
])

@php
$sizeClasses = [
    'sm' => 'max-w-md',
    'md' => 'max-w-2xl', 
    'lg' => 'max-w-4xl',
    'xl' => 'max-w-6xl',
    '2xl' => 'max-w-7xl'
];
@endphp

@if($show)
<div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" 
     @if($closeable && !$persistent) wire:click="closeModal" @endif>
    <div class="modal-modern relative w-full {{ $sizeClasses[$size] }} bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" 
         @if($closeable && !$persistent) wire:click.stop @endif>
        
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-{{ $icon ?? 'cog' }} text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
                    @if(isset($subtitle))
                    <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if($closeable)
            <button wire:click="closeModal" class="modal-close-btn">
                <i class="fas fa-times text-xl"></i>
            </button>
            @endif
        </div>

        <!-- Contenu du modal -->
        <div class="p-6">
            {{ $slot }}
        </div>

        <!-- Pied du modal -->
        @if(isset($footer))
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>
@endif
