@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden ' . $class]) }}>
    <div class="h-full w-full rounded-[inherit] overflow-auto">
        {{ $slot }}
    </div>
</div>
