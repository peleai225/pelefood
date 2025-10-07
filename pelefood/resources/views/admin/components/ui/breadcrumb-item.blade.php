@props(['class' => ''])

<li {{ $attributes->merge(['class' => 'inline-flex items-center ' . $class]) }}>
    {{ $slot }}
</li>
