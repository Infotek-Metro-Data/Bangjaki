@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'rows' => 3,
    'required' => false,
    'error' => null
])

<div>
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <textarea 
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-textarea' . ($error ? ' border-danger focus:ring-danger' : '')]) }}
    >{{ old($name, $value) }}</textarea>
    @if($error)
        <p class="mt-1 text-sm text-danger">{{ $error }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
