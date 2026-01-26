@props([
    'pets' => [],
    'name' => 'pet',
    'id' => null,
    'label' => 'Patient',
    'selected' => null,
    'required' => false,
    'columnClass' => 'col-12 col-lg-6',
])

@php
    $controlId = $id ?? $name;
    $inputName = $name;
    $currentValue = $selected ?? old($inputName);
@endphp

<div class="{{ $columnClass }}">
    <label for="{{ $controlId }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select
        style="width: 100%"
        id="{{ $controlId }}"
        name="{{ $inputName }}"
        {{ $attributes->merge([
            'class' => 'select2 form-select'.($errors->has($inputName) ? ' is-invalid' : ''),
        ]) }}
    >
        <option value=""></option>
        @foreach ($pets as $item)
            <option value="{{ $item->id }}" @selected($currentValue == $item->id)>
                {{ $item->patient_id }} - {{ $item->name }}
            </option>
        @endforeach
    </select>
    @error($inputName)
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
</div>
