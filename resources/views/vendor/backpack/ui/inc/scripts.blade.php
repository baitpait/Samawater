{{-- Override to prevent loading jQuery from CDN - we use local assets from config/backpack/ui.php --}}
{{-- Original file: vendor/backpack/crud/src/resources/views/ui/inc/scripts.blade.php --}}

{{-- 1. Load Early Guards first --}}
<script src="{{ asset('js/early-guards.js') }}"></script>

{{-- 2. Load jQuery synchronously --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

{{-- 3. Load Popper and Bootstrap synchronously (Required by DataTables Bootstrap 5 integration) --}}
<script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>

{{-- 4. Load DataTables synchronously and locally (No Basset, No CDN) --}}
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-fixedheader/dataTables.fixedHeader.min.js') }}"></script>

{{-- WhatsApp Auto-Open Script --}}
@if(session('whatsapp_url') || session('whatsapp_url_persistent'))
<script>
    (function() {
        // فتح رابط الوتس اب في تبويب جديد فور الحفظ
        var whatsappUrl = "{{ session('whatsapp_url') ?: session('whatsapp_url_persistent') }}";
        console.log("Attempting to open WhatsApp: ", whatsappUrl);
        if (whatsappUrl) {
            // مسح الرابط من السيشن عبر AJAX لضمان عدم فتحه مرة أخرى عند التحديث
            fetch("{{ url('admin/clear-whatsapp-session') }}");
            
            // محاولة الفتح
            var win = window.open(whatsappUrl, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('الرجاء السماح للنوافذ المنبثقة (Popups) لفتح رسالة الوتس اب تلقائياً');
            }
        }
    })();
</script>
@endif

{{-- 5. Load remaining scripts from theme config --}}
@if (backpack_theme_config('scripts') && count(backpack_theme_config('scripts')))
    @foreach (backpack_theme_config('scripts') as $path)
        @php
            // Skip scripts we already loaded manually
            $isAlreadyLoaded = is_string($path) && (
                strpos($path, 'early-guards.js') !== false ||
                strpos($path, 'jquery.min.js') !== false ||
                strpos($path, 'popper.min.js') !== false ||
                strpos($path, 'bootstrap.min.js') !== false ||
                strpos($path, 'datatables') !== false
            );
        @endphp
        @if(!$isAlreadyLoaded)
            @if(is_array($path))
                @basset(...$path)
            @else
                @basset($path)
            @endif
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_scripts') && count(backpack_theme_config('mix_scripts')))
    @foreach (backpack_theme_config('mix_scripts') as $path => $manifest)
        <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

@if (backpack_theme_config('vite_scripts') && count(backpack_theme_config('vite_scripts')))
    @vite(backpack_theme_config('vite_scripts'))
@endif

@include(backpack_view('inc.alerts'))

@if(config('app.debug'))
    @include('crud::inc.ajax_error_frame')
@endif

@push('after_scripts')
    @basset(base_path('vendor/backpack/crud/src/resources/assets/js/common.js'))
@endpush
