@props([
    'label'    => '',
    'name'     => '',
    'required' => false,
    'hint'     => '',
    'full'     => false,
])

<div class="form-group {{ $full ? 'full' : '' }}">
    @if($label)
        <label class="form-label" for="{{ $name }}">
            {{ $label }}
            @if($required) <span class="req">*</span> @endif
        </label>
    @endif

    {{ $slot }}

    @if($hint)
        <div class="form-hint">{{ $hint }}</div>
    @endif

    @error($name)
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
