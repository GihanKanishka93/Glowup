@props([
    'name' => 'owner_contact',
    'id' => null,
    'label' => 'Contact Number',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'columnClass' => 'col-12 col-lg-6',
])

@php
    $inputName = $name;
    $controlId = $id ?? $name;
    $currentValue = old($inputName, $value);
@endphp

<div class="{{ $columnClass }}">
    <label for="{{ $controlId }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input
        type="{{ $type }}"
        id="{{ $controlId }}"
        name="{{ $inputName }}"
        value="{{ $currentValue }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'form-control'.($errors->has($inputName) ? ' is-invalid' : ''),
        ]) }}
    >
    @error($inputName)
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
</div>
