@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-white']) }}>
    {{ $value ?? $slot }}
</label>
