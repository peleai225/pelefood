@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'required' => false,
    'placeholder' => '',
    'help' => '',
    'error' => null,
    'value' => '',
    'options' => [],
    'rows' => 3,
    'accept' => '',
    'multiple' => false,
    'wireModel' => null
])

@php
$inputClasses = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors';
if($error) {
    $inputClasses .= ' border-red-300 focus:ring-red-500';
}
@endphp

<div class="space-y-2">
    <!-- Label -->
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if($required)
        <span class="text-red-500 ml-1">*</span>
        @endif
    </label>
    @endif

    <!-- Champ de saisie -->
    @if($type === 'textarea')
        <textarea 
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder }}"
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            @if($required) required @endif
        >{{ old($name, $value) }}</textarea>
    
    @elseif($type === 'select')
        <select 
            id="{{ $name }}"
            name="{{ $name }}"
            class="{{ $inputClasses }}"
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            @if($required) required @endif
        >
            <option value="">{{ $placeholder ?: 'Sélectionner...' }}</option>
            @foreach($options as $key => $option)
                <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                    {{ is_array($option) ? $option['label'] : $option }}
                </option>
            @endforeach
        </select>
    
    @elseif($type === 'file')
        <div class="relative">
            <input 
                type="file"
                id="{{ $name }}"
                name="{{ $name }}"
                class="{{ $inputClasses }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($multiple) multiple @endif
                @if($wireModel) wire:model="{{ $wireModel }}" @endif
                @if($required) required @endif
            >
        </div>
    
    @elseif($type === 'checkbox')
        <div class="flex items-center space-x-3">
            <label class="relative inline-flex items-center cursor-pointer">
                <input 
                    type="checkbox"
                    id="{{ $name }}"
                    name="{{ $name }}"
                    value="1"
                    class="sr-only peer"
                    @if($wireModel) wire:model="{{ $wireModel }}" @endif
                    {{ old($name, $value) ? 'checked' : '' }}
                >
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
            <span class="text-sm text-gray-700">{{ $label }}</span>
        </div>
    
    @else
        <input 
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder }}"
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            @if($required) required @endif
        >
    @endif

    <!-- Message d'aide -->
    @if($help)
    <p class="text-sm text-gray-500">{{ $help }}</p>
    @endif

    <!-- Message d'erreur -->
    @if($error)
    <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
