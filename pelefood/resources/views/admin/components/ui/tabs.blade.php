@props(['class' => '', 'defaultValue' => ''])

<div {{ $attributes->merge(['class' => 'w-full ' . $class]) }} x-data="{ activeTab: '{{ $defaultValue }}' }">
    {{ $slot }}
</div>
