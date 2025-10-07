@props(['class' => '', 'value' => 0, 'max' => 100])

<div {{ $attributes->merge(['class' => 'relative h-4 w-full overflow-hidden rounded-full bg-secondary ' . $class]) }}>
    <div class="h-full w-full flex-1 bg-primary transition-all" style="transform: translateX(-{{ 100 - ($value / $max * 100) }}%)"></div>
</div>
