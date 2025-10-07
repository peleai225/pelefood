@props(['class' => ''])

<input type="radio" {{ $attributes->merge(['class' => 'h-4 w-4 rounded-full border border-input ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground ' . $class]) }}>
