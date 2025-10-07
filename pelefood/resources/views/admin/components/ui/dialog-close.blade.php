@props(['class' => ''])

<button {{ $attributes->merge(['class' => 'rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground ' . $class]) }}
        @click="$parent.open = false">
    <i data-lucide="x" class="h-4 w-4"></i>
    <span class="sr-only">Fermer</span>
</button>
