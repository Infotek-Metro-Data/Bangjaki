@props([
    'id' => 'modal',
    'title' => '',
    'size' => 'md' // sm, md, lg
])

@php
    $sizeClass = match($size) {
        'sm' => 'max-w-sm',
        'lg' => 'max-w-lg',
        default => 'max-w-md',
    };
@endphp

<div 
    id="{{ $id }}" 
    class="modal-overlay hidden"
    onclick="if(event.target === this) closeModal('{{ $id }}')"
>
    <div class="modal-content {{ $sizeClass }} animate-slide-up">
        @if($title)
            <div class="modal-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-secondary-900">{{ $title }}</h3>
                    <button type="button" onclick="closeModal('{{ $id }}')" class="p-1 text-secondary-400 hover:text-secondary-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        <div class="modal-body">
            {{ $slot }}
        </div>
        @if(isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
