@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'grid gap-4 py-4 ' . $class]) }}>
    {{ $slot }}
</div>
