@props([
    'label' => '',
    'name' => '',
    'accept' => 'image/*',
    'required' => false,
    'capture' => null,
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
    <div class="mt-1">
        <label for="{{ $name }}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-secondary-300 rounded-lg cursor-pointer bg-secondary-50 hover:bg-secondary-100 transition-colors">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-secondary-500">
                    <span class="font-medium text-primary-600">Klik untuk upload</span> atau ambil foto
                </p>
                <p class="text-xs text-secondary-400 mt-1">PNG, JPG hingga 5MB</p>
            </div>
            <input 
                type="file"
                name="{{ $name }}"
                id="{{ $name }}"
                accept="{{ $accept }}"
                {{ $capture ? "capture=$capture" : '' }}
                {{ $required ? 'required' : '' }}
                class="hidden"
                onchange="previewImage(this, '{{ $name }}')"
            >
        </label>
        <div id="{{ $name }}_preview" class="mt-2 hidden">
            <img src="" alt="Preview" class="w-full h-40 object-cover rounded-lg">
        </div>
    </div>
    @if($error)
        <p class="mt-1 text-sm text-danger">{{ $error }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>

<script>
function previewImage(input, name) {
    const preview = document.getElementById(name + '_preview');
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
