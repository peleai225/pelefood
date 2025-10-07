@props(['class' => '', 'side' => 'right'])

<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 ' . $class]) }}
     x-data="{ open: false }"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="open = false">
    <div class="fixed inset-0 bg-background/80 backdrop-blur-sm"></div>
    <div class="fixed {{ $side === 'right' ? 'right-0' : 'left-0' }} top-0 h-full w-3/4 border-r bg-background p-6 shadow-lg sm:max-w-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="{{ $side === 'right' ? 'translate-x-full' : '-translate-x-full' }}"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="{{ $side === 'right' ? 'translate-x-full' : '-translate-x-full' }}"
         @click.stop>
        {{ $slot }}
    </div>
</div>
