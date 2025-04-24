@props(['messages' => null, 'icon' => false])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
        @foreach ((array) $messages as $message)
            <div>
                @if($icon)
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                @endif
                {{ $message }}
            </div>
        @endforeach
    </div>
@endif

