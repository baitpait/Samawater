/**
 * Business Purpose: تهيئة Select2 لقوائم اختيار المشترك مع بحث داخلي بالاسم (RTL).
 * Recovery: بعد تحديث الصفحة — يُحمَّل تلقائياً؛ لإعادة التهيئة يدوياً: initClientSelect2('.client-select-searchable')
 */
(function () {
    'use strict';

    /**
     * Business Purpose: تفعيل Select2 على عنصر واحد إن لم يكن مفعّلاً مسبقاً.
     */
    function initOne($el) {
        if (!$el.length || $el.hasClass('select2-hidden-accessible')) {
            return;
        }

        var isRequired = $el.prop('required');
        var hasEmptyOption = $el.find('option[value=""]').length > 0;

        $el.select2({
            theme: 'bootstrap',
            width: '100%',
            dir: 'rtl',
            allowClear: !isRequired && hasEmptyOption,
            placeholder: $el.data('placeholder') || 'ابحث عن اسم المشترك…',
            language: {
                noResults: function () {
                    return 'لا توجد نتائج';
                },
                searching: function () {
                    return 'جاري البحث…';
                },
                inputTooShort: function () {
                    return 'اكتب للبحث';
                },
            },
        });
    }

    /**
     * Business Purpose: تهيئة كل قوائم المشترك القابلة للبحث أو محدّد معيّن.
     *
     * @param {string|HTMLElement|jQuery} [selector]
     */
    window.initClientSelect2 = function (selector) {
        if (!window.jQuery || !jQuery.fn.select2) {
            return;
        }

        var $targets = selector
            ? jQuery(selector)
            : jQuery('select.client-select-searchable');

        $targets.each(function () {
            initOne(jQuery(this));
        });
    };

    function boot() {
        window.initClientSelect2();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
