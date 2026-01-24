# 🚀 ربط GitHub في Cursor - دليل شامل

## 🎯 الهدف:
ربط مشروع Eliyaa بـ GitHub لسهولة النشر والنسخ الاحتياطي.

---

## 📋 الخطوات في Cursor:

### 1️⃣ التأكد من وجود Git:

#### في Terminal داخل Cursor:
```bash
# تحقق من وجود Git
git --version

# إذا لم يكن مثبتاً:
sudo apt update
sudo apt install git
```

### 2️⃣ إعداد Git الأساسي:

#### في Terminal:
```bash
# إعداد الاسم والبريد
git config --global user.name "اسمك الكامل"
git config --global user.email "بريدك@gmail.com"

# تحقق من الإعدادات
git config --global user.name
git config --global user.email
```

### 3️⃣ إنشاء SSH Key لـ GitHub:

#### في Terminal:
```bash
# إنشاء مفتاح SSH
ssh-keygen -t ed25519 -C "بريدك@gmail.com"

# عرض المفتاح العام
cat ~/.ssh/id_ed25519.pub
```

**انسخ المفتاح الذي ظهر** (يبدأ بـ `ssh-ed25519`).

### 4️⃣ إضافة SSH Key في GitHub:

#### على الموقع:
1. **اذهب إلى:** https://github.com/settings/keys
2. **اضغط:** `New SSH key`
3. **Title:** `Cursor - Eliyaa Project`
4. **Key:** الصق المفتاح الذي نسخته
5. **اضغط:** `Add SSH key`

#### اختبار الاتصال:
```bash
# في Terminal
ssh -T git@github.com
# يجب أن ترى: "Hi username! You've successfully authenticated..."
```

### 5️⃣ إعداد المشروع في Cursor:

#### في Cursor - افتح Terminal:
```bash
# اذهب للمشروع
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"

# إنشاء .gitignore
cat > .gitignore << 'EOF'
/vendor/
/node_modules/
/storage/app/
/storage/framework/cache/
/storage/framework/sessions/
/storage/framework/views/
/storage/logs/
/bootstrap/cache/
/.env
.env.local
.env.production
.env.staging
.DS_Store
Thumbs.db
*.log
.vscode/
.idea/
composer.lock
package-lock.json
EOF

# إنشاء README.md
cat > README.md << 'EOF'
# Eliyaa Water Distribution System
نظام توزيع مياه ايلياء - Laravel + Backpack

## المميزات
- إدارة العملاء والموزعين
- تتبع التسليمات
- التقارير والإحصائيات
- تصميم متجاوب بخط Cairo
- نسخ احتياطي تلقائي

## التقنيات
- Laravel 10+
- Backpack for Laravel
- MySQL
- Bootstrap 4
- Font Awesome

## التثبيت
1. `git clone git@github.com:اسم-المستخدم/eliyaa-water-distribution.git`
2. `composer install`
3. `npm install && npm run build`
4. `cp .env.example .env`
5. `php artisan key:generate`
6. `php artisan migrate`
7. `php artisan db:seed`

## النشر
`git push origin main`
ثم `git pull origin main` على السيرفر
EOF

# إنشاء repository محلي
git init
git add .
git commit -m "Initial commit - Eliyaa Water Distribution System"
```

### 6️⃣ إنشاء Repository على GitHub:

#### على الموقع:
1. **اذهب إلى:** https://github.com/new
2. **Repository name:** `eliyaa-water-distribution`
3. **Description:** `نظام توزيع مياه ايلياء`
4. **Private** ✅ (مهم للأمان)
5. **لا تضع علامة** Initialize with README
6. **اضغط:** `Create repository`

#### في Terminal:
```bash
# ربط بـ GitHub (استبدل اسم-المستخدم باسمك الحقيقي)
git remote add origin git@github.com:اسم-المستخدم/eliyaa-water-distribution.git
git push -u origin main
```

---

## 🎨 إعداد Git في Cursor:

### 1️⃣ تفعيل Git في Cursor:

#### في Cursor:
1. **اذهب إلى:** `File` → `Preferences` → `Settings`
2. **ابحث عن:** `git`
3. **تفعيل:** `Git: Enabled`
4. **تفعيل:** `Git: Autofetch`

### 2️⃣ إعداد GitLens Extension (اختياري لكن مفيد):

#### في Cursor:
1. **اذهب إلى:** Extensions (أيقونة المكعبات)
2. **ابحث عن:** `GitLens`
3. **ثبت:** GitLens بواسطة GitKraken

---

## 📊 استخدام Git في Cursor:

### 🔄 سير العمل الأساسي:

#### 1️⃣ بعد كل تعديل:
```bash
# في Terminal أو Git panel
git add .
git commit -m "تحديث: وصف التعديل"
git push origin main
```

#### 2️⃣ رؤية التغييرات:
- **في Cursor:** اضغط `Ctrl+Shift+G` لفتح Git panel
- **سترى:** الملفات المُعدلة والجديدة

#### 3️⃣ Commit & Push:
- **في Git panel:** اضغط `+` بجانب الملفات لإضافتها
- **اكتب رسالة** في مربع النص
- **اضغط:** `Ctrl+Enter` للـ commit
- **اضغط:** `Sync Changes` للـ push

---

## 🖥️ سحب المشروع على السيرفر:

### للمرة الأولى:
```bash
cd /home/sarfesak/public_html

# سحب المشروع كاملاً
git clone git@github.com:اسم-المستخدم/eliyaa-water-distribution.git eliyaa

# تثبيت المتطلبات
cd eliyaa
composer install --no-dev --optimize-autoloader
npm install && npm run build

# إعداد Laravel
cp .env.example .env
php artisan key:generate
php artisan storage:link

# مسح الكاش
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### للتحديثات:
```bash
cd /home/sarfesak/public_html/eliyaa

# سحب التحديثات
git pull origin main

# تحديث إذا لزم الأمر
composer install --no-dev --optimize-autoloader
npm run build

# مسح الكاش
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔧 حل المشاكل الشائعة:

### خطأ SSH:
```bash
# اختبار الاتصال
ssh -T git@github.com

# إذا فشل:
ssh-keygen -t ed25519 -C "بريدك@gmail.com" -f ~/.ssh/github_key
ssh-add ~/.ssh/github_key
```

### خطأ Push:
```bash
# إذا كان هناك upstream error:
git push --set-upstream origin main
```

### مشكلة في Cursor:
```bash
# إعادة تحميل VS Code/Cursor
# أو: Ctrl+Shift+P → "Developer: Reload Window"
```

---

## 📊 الفوائد في Cursor:

### ✅ **سهولة الاستخدام:**
- **Git panel** مدمج في الشريط الجانبي
- **تتبع التغييرات** في الوقت الفعلي
- **Diff viewer** لمقارنة التغييرات

### ✅ **GitLens Features:**
- **Blame annotations** - معرفة من غير آخر تعديل
- **File history** - تاريخ كل ملف
- **Commit search** - البحث في الـ commits

### ✅ **Keyboard Shortcuts:**
- `Ctrl+Shift+G` - فتح Git panel
- `Ctrl+Enter` - Commit
- `Ctrl+Shift+K` - Stage file

---

## 🎯 الخلاصة:

### في Cursor ستحصل على:
- **سهولة** رؤية التغييرات
- **سرعة** في الـ commit والـ push
- **وضوح** في تتبع الملفات
- **أمان** مع SSH keys

### النتيجة النهائية:
```
Cursor (localhost) ←── Git Push ──→ GitHub ←── Git Pull ──→ Server
```

---

## 🚀 البدء السريع:

1. **اتبع الخطوات 1-4** أعلاه
2. **أنشئ repository** على GitHub
3. **اربط المشروع** بالأوامر في الخطوة 5
4. **استمتع** بالنشر السهل!

---

**هل تحتاج مساعدة في أي خطوة؟** 🤔

**أخبرني إذا واجهت أي مشكلة!** 💪

---

**تاريخ الدليل:** 31 ديسمبر 2024

