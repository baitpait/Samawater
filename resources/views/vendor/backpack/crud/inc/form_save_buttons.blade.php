<div id="saveActions" class="form-group my-3">
    {{-- زر حفظ واحد فقط - Unified Design --}}
    <input type="hidden" name="_save_action" value="save_and_back">
    <button type="submit" class="btn btn-save-unified">
        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
        <span>{{ trans('backpack::crud.save') }}</span>
    </button>
</div>

<style>
    .btn-save-unified {
        background: linear-gradient(135deg, #7d5bff 0%, #6f6af8 100%) !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 12px 28px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(125, 91, 255, 0.3) !important;
        transition: all 0.3s ease !important;
        font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    }

    .btn-save-unified:hover {
        background: linear-gradient(135deg, #6f6af8 0%, #7d5bff 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(125, 91, 255, 0.4) !important;
        color: #fff !important;
    }

    .btn-save-unified:active {
        transform: translateY(0) !important;
        box-shadow: 0 2px 10px rgba(125, 91, 255, 0.3) !important;
    }

    .btn-save-unified:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(125, 91, 255, 0.2) !important;
    }
</style>

@push('after_scripts')
<script>
    // make submit button trigger HTML5 validation
    jQuery(document).ready(function($) {
        var form = $('#saveActions').closest('form');
        var saveActionField = $('[name="_save_action"]');
        var $submitButton = $('#saveActions').find('button[type="submit"]');
        
        $submitButton.on('click', function(e) {
            e.preventDefault();
            
            // if form is valid just submit it
            if (form[0].checkValidity && form[0].checkValidity()) {
                saveActionField.val('save_and_back');
                form[0].requestSubmit();
            } else {
                // validate and display form errors
                if (form[0].reportValidity) {
                    form[0].reportValidity();
                }
            }
        });
    });
</script>
@endpush

