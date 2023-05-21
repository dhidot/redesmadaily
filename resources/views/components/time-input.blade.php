{{-- input time for attendance create form --}}
@props(['id', 'type' => 'time', 'name', 'label', 'value' => null, 'placeholder' => null, 'class' => null, 'disabled' => false])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {{
        $attributes->merge(['class' => 'form-control']) }} {{ $attributes->get('wire') }} @if($disabled) disabled @endif />