# 🎨 دليل توحيد تصميم النماذج ورؤوس الصفحات

## 📋 **الملف الموحد:**
`resources/css/unified-forms.css`

---

## 🎯 **رؤوس الصفحات (Page Headers):**

### **استخدام أساسي:**
```blade
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-left">
            <div class="page-header-icon">
                <i class="la la-truck"></i>
            </div>
            <div>
                <h1 class="page-header-title">عنوان الصفحة</h1>
                <p class="page-header-subtitle">وصف مختصر للصفحة</p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="#" class="btn btn-success">
                <i class="la la-file-excel"></i>
                تصدير Excel
            </a>
        </div>
    </div>
</div>
```

### **نوع أخضر (للصفحات الخاصة):**
```blade
<div class="page-header page-header-green">
    <!-- نفس المحتوى -->
</div>
```

### **الميزات:**
- ✅ **Gradient Background** - خلفية متدرجة (بنفسجي/أخضر)
- ✅ **أيقونات احترافية** - أيقونات في مربعات شفافة
- ✅ **عنوان ووصف** - عنوان رئيسي ووصف فرعي
- ✅ **أزرار شفافة** - أزرار بتأثير glassmorphism
- ✅ **Animations** - تأثيرات حركية سلسة
- ✅ **Responsive** - متجاوب مع جميع الأجهزة

---

---

## 🚀 **كيفية الاستخدام:**

### **1. الملف مضاف تلقائياً:**
تم إضافة الملف إلى `config/backpack/ui.php` وسيتم تحميله تلقائياً في جميع صفحات لوحة التحكم.

### **2. استخدام الكلاسات في النماذج:**

#### **Filter Cards (بطاقات الفلاتر):**
```blade
<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET">
            <!-- النموذج هنا -->
        </form>
    </div>
</div>
```

#### **Labels (التسميات):**
```blade
<label class="form-label">اسم الحقل</label>
<label class="form-label required">حقل مطلوب</label>
```

#### **Inputs (حقول الإدخال):**
```blade
<!-- Input عادي -->
<input type="text" name="name" class="form-control" placeholder="...">

<!-- Select -->
<select name="city_id" class="form-select">
    <option value="">الكل</option>
</select>

<!-- أو استخدام الكلاسات الموحدة -->
<input type="text" name="name" class="modern-input" placeholder="...">
<select name="city_id" class="modern-select">
    <option value="">الكل</option>
</select>
```

#### **Buttons (الأزرار):**
```blade
<!-- زر أساسي (بنفسجي) -->
<button type="submit" class="btn btn-show-results">
    <i class="la la-search"></i> عرض النتائج
</button>

<!-- أو -->
<button type="submit" class="btn btn-primary-unified">
    <i class="la la-save"></i> حفظ
</button>

<!-- زر ثانوي (أخضر) -->
<button type="submit" class="btn btn-success-unified">
    <i class="la la-check"></i> تأكيد
</button>

<!-- زر إلغاء -->
<button type="button" class="btn btn-reset">
    <i class="la la-times"></i> إلغاء
</button>
```

#### **Form Groups (مجموعات الحقول):**
```blade
<div class="form-group">
    <label class="form-label">اسم الحقل</label>
    <input type="text" name="field" class="form-control">
    <small class="form-text">نص مساعدة</small>
</div>
```

#### **Form Sections (أقسام النماذج):**
```blade
<div class="form-section">
    <h3 class="form-section-title">
        <i class="la la-user"></i>
        البيانات الأساسية
    </h3>
    <p class="form-section-description">
        وصف القسم هنا
    </p>
    <!-- الحقول هنا -->
</div>
```

---

## 🎨 **الألوان المستخدمة:**

### **البنفسجي (Primary):**
- الأساسي: `#6f6af8`
- الفاتح: `#7c7cff`
- Gradient: `linear-gradient(135deg, #6f6af8, #7c7cff)`

### **الأخضر (Success):**
- الأساسي: `#22c55e`
- الفاتح: `#34d399`
- Gradient: `linear-gradient(135deg, #34d399, #22c55e)`

### **الألوان الأخرى:**
- النص: `#1f2937`
- النص الثانوي: `#6b7280`
- الحدود: `#e2e8ff`
- الخلفية: `#f7f9ff`
- الخطأ: `#ef4444`
- النجاح: `#22c55e`

---

## 📐 **الأحجام القياسية:**

- **ارتفاع الحقول:** `46px` (Desktop), `42px` (Tablet), `40px` (Mobile)
- **Border Radius:** `20px` (Desktop), `16px` (Mobile)
- **Font Size:** `13px` (Labels), `14px` (Buttons)
- **Padding:** `0 18px` (Desktop), `0 14px` (Mobile)

---

## ✅ **الميزات:**

1. ✅ **تصميم موحد** في جميع أنحاء النظام
2. ✅ **ألوان متناسقة** (البنفسجي والأخضر)
3. ✅ **Responsive Design** متجاوب مع جميع الأجهزة
4. ✅ **States متعددة** (Focus, Error, Success, Disabled)
5. ✅ **Animations سلسة** للتفاعلات
6. ✅ **دعم RTL** كامل للغة العربية

---

## 🔄 **التحديث من الأنماط القديمة:**

### **قبل:**
```blade
<input type="text" class="form-control" style="height: 46px; border-radius: 20px;">
```

### **بعد:**
```blade
<input type="text" class="form-control">
<!-- أو -->
<input type="text" class="modern-input">
```

---

## 📝 **ملاحظات مهمة:**

1. **الملف محمّل تلقائياً** - لا حاجة لإضافته يدوياً
2. **استخدم الكلاسات الموحدة** - تجنب الأنماط المخصصة
3. **الألوان موحدة** - استخدم البنفسجي والأخضر فقط
4. **Responsive** - التصميم متجاوب تلقائياً

---

## 🎯 **أمثلة كاملة:**

### **نموذج فلترة بسيط:**
```blade
<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label">المدينة</label>
                <select name="city_id" class="form-select">
                    <option value="">الكل</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label">الموزع</label>
                <select name="distributor_id" class="form-select">
                    <option value="">الكل</option>
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-show-results w-100">
                    <i class="la la-search"></i> عرض النتائج
                </button>
            </div>
        </form>
    </div>
</div>
```

### **نموذج إدخال بيانات:**
```blade
<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="la la-user"></i>
                    البيانات الأساسية
                </h3>
                
                <div class="form-group">
                    <label class="form-label required">الاسم</label>
                    <input type="text" name="name" class="form-control" required>
                    <small class="form-text">أدخل الاسم الكامل</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary-unified">
                    <i class="la la-save"></i> حفظ
                </button>
                <button type="button" class="btn btn-reset">
                    <i class="la la-times"></i> إلغاء
                </button>
            </div>
        </form>
    </div>
</div>
```

---

## ✅ **الخلاصة:**

تم توحيد تصميم النماذج في جميع أنحاء النظام باستخدام:
- ✅ ملف CSS موحد
- ✅ كلاسات قياسية
- ✅ ألوان متناسقة
- ✅ تصميم متجاوب
- ✅ دعم كامل للغة العربية

**استخدم الكلاسات الموحدة في جميع النماذج الجديدة!**

