@php
    $uniqueId = 'lottie-' . uniqid();
@endphp

<div class="lottie-container" id="{{ $uniqueId }}" style="width: {{ $width }}; height: {{ $height }}; margin: 0 auto;"></div>

@once
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    @endpush
@endonce

@push('scripts')
<script>
    (function() {
        const container = document.getElementById('{{ $uniqueId }}');
        if (container) {
            lottie.loadAnimation({
                container: container,
                renderer: 'svg',
                loop: {{ $loop ? 'true' : 'false' }},
                autoplay: true,
                path: '{{ $path }}'
            });
        }
    })();
</script>
@endpush