@props(['class' => ''])

<a {{ $attributes->merge(['class' => 'inline-flex items-center text-sm font-medium text-muted-foreground hover:text-foreground ' . $class]) }}>
    {{ $slot }}
</a>
