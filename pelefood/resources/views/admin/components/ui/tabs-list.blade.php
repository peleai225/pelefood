@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground ' . $class]) }}>
    {{ $slot }}
</div>
