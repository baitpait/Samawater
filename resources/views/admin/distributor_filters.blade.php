<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ backpack_url('distributor') }}" class="row g-3 align-items-end">
            {{-- الصف الأول: البحث وزر الإضافة --}}
            <div class="row g-3 mb-3 align-items-end">
                {{-- البحث --}}
                <div class="col-12 col-md-10 col-lg-11">
                    <label class="form-label" style="font-size: 14px; font-weight: 600; color: #55607b; margin-bottom: 8px;">
                        <i class="la la-search" style="margin-left: 6px; color: #6f6af8;"></i>
                        بحث
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control modern-input" 
                        placeholder="اسم الموزع، رقم الهاتف، أو اسم المستخدم"
                        value="{{ request('search') }}"
                        style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif; width: 100%;"
                    >
                </div>

                {{-- الأزرار --}}
                <div class="col-12 col-md-2 col-lg-1">
                    <button type="submit" class="btn btn-show-results w-100" title="عرض النتائج" style="height: 50px; display: flex; align-items: center; justify-content: center; font-size: 20px; min-width: 60px;">
                        <i class="la la-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

