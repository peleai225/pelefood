@props(['class' => ''])

<nav {{ $attributes->merge(['class' => 'flex ' . $class]) }} aria-label="Breadcrumb">
    <ol class="flex items-center space-x-1 md:space-x-3">
        {{ $slot }}
    </ol>
</nav>
