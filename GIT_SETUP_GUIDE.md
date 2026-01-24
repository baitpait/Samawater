# 🚀 إعداد Git & GitHub للمشروع - دليل شامل

## 📋 المشروع: Eliyaa Water Distribution System

---

## 🎯 الهدف:
ربط المشروع بـ GitHub لسهولة النشر والتحديثات على السيرفر.

---

## 📁 الخطوات على الجهاز المحلي (Localhost):

### 1️⃣ إعداد Git (إذا لم يكن مثبتاً):
```bash
# على macOS (إذا لم يكن مثبتاً):
xcode-select --install

# على Ubuntu:
sudo apt update && sudo apt install git

# على Windows:
# حمل من: https://git-scm.com/downloads
```

### 2️⃣ إعداد Git:
```bash
git config --global user.name "اسمك الكامل"
git config --global user.email "بريدك@gmail.com"
```

### 3️⃣ إعداد SSH Key لـ GitHub:
```bash
# إنشاء مفتاح SSH
ssh-keygen -t ed25519 -C "بريدك@gmail.com"

# نسخ المفتاح العام
cat ~/.ssh/id_ed25519.pub
```

**أضف المفتاح في GitHub:**
1. اذهب إلى: https://github.com/settings/keys
2. اضغط: **New SSH Key**
3. الصق المفتاح الذي نسخته
4. اضغط: **Add SSH Key**

### 4️⃣ إنشاء Repository على GitHub:

**الطريقة الأولى - عبر الموقع:**
1. اذهب إلى: https://github.com/new
2. **Repository name:** `eliyaa-water-distribution`
3. **Description:** `نظام توزيع مياه ايلياء - Laravel + Backpack`
4. **Visibility:** `Private` (للأمان)
5. **لا تضع** ✅ Initialize with README
6. اضغط: **Create repository**

**الطريقة الثانية - عبر Terminal:**
```bash
# بعد إنشاء الـ repo على GitHub
echo "# Eliyaa Water Distribution" >> README.md
echo "نظام توزيع مياه ايلياء" >> README.md
```

### 5️⃣ إعداد المشروع لـ Git:
```bash
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"

# إنشاء .gitignore (انسخ هذا المحتوى إلى ملف جديد اسمه .gitignore)
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

## الاستخدام
`php artisan serve`

## النشر
`git push origin main`
ثم سحب التغييرات على السيرفر
EOF

# إنشاء repository محلي
git init
git add .
git commit -m "Initial commit - Eliyaa Water Distribution System"

# ربط بـ GitHub
git remote add origin git@github.com:اسم-المستخدم/eliyaa-water-distribution.git
git push -u origin main
```

---

## 🖥️ الخطوات على السيرفر (VPS Ubuntu):

### 1️⃣ إعداد Git على السيرفر:
```bash
# تثبيت Git
sudo apt update
sudo apt install git

# إعداد Git
git config --global user.name "اسمك"
git config --global user.email "بريدك@gmail.com"

# إنشاء SSH Key
ssh-keygen -t ed25519 -C "بريدك@gmail.com"
cat ~/.ssh/id_ed25519.pub

# أضف المفتاح في GitHub (نفس المفتاح السابق أو مفتاح جديد)
```

### 2️⃣ سحب المشروع:
```bash
cd /home/sarfesak/public_html

# سحب المشروع (استبدل اسم-المستخدم باسمك)
git clone git@github.com:اسم-المستخدم/eliyaa-water-distribution.git eliyaa

# أو إذا كان المجلد موجود:
cd eliyaa
git init
git remote add origin git@github.com:اسم-المستخدم/eliyaa-water-distribution.git
git pull origin main
```

### 3️⃣ تثبيت المتطلبات:
```bash
cd /home/sarfesak/public_html/eliyaa

# تثبيت PHP dependencies
composer install --no-dev --optimize-autoloader

# تثبيت Node.js dependencies
npm install
npm run build

# نسخ ملف البيئة
cp .env.example .env

# إعداد Laravel
php artisan key:generate
php artisan storage:link

# مسح الكاش
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4️⃣ إعداد قاعدة البيانات:
```bash
# استيراد قاعدة البيانات (إذا كان لديك backup)
mysql -u sarfesak_eliyaa -p sarfesak_eliyaa < database_eliyaa.sql

# أو تشغيل migrations
php artisan migrate
php artisan db:seed
```

---

## 🔄 سير عمل النشر (Workflow):

### عند كل تحديث:

#### 1️⃣ على الجهاز المحلي:
```bash
# بعد التعديلات
git add .
git commit -m "تحديث: وصف التغيير"
git push origin main
```

#### 2️⃣ على السيرفر:
```bash
cd /home/sarfesak/public_html/eliyaa

# سحب التحديثات
git pull origin main

# تحديث المتطلبات (إذا تغير composer.json)
composer install --no-dev --optimize-autoloader

# تحديث assets (إذا تغير package.json)
npm install
npm run build

# مسح الكاش
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# إعادة تشغيل queue workers إذا كان مستخدماً
php artisan queue:restart
```

---

## 📊 إدارة الفروع (Branches):

### إنشاء فرع للتطوير:
```bash
# على localhost
git checkout -b development
git push origin development

# على السيرفر (للاختبار)
git checkout development
git pull origin development
```

### دمج التغييرات:
```bash
# على localhost
git checkout main
git merge development
git push origin main

# على السيرفر
git pull origin main
```

---

## 🔐 الأمان والخصوصية:

### 1️⃣ لا ترفع الملفات الحساسة:
- ✅ `.env` (محظور في .gitignore)
- ✅ `storage/logs/` (محظور)
- ✅ `storage/app/` (محظور)

### 2️⃣ استخدم Private Repository:
- اجعل الـ repository **Private**
- لا تشارك الـ SSH keys

### 3️⃣ نصائح أمنية:
```bash
# على السيرفر - تأكد من الأذونات
chmod 600 ~/.ssh/id_ed25519
chmod 644 ~/.ssh/id_ed25519.pub

# لا تسمح بالوصول المباشر لـ .git
<DirectoryMatch "^/.*/\.git/">
    Require all denied
</DirectoryMatch>
```

---

## 🆘 حل المشاكل الشائعة:

### خطأ SSH:
```bash
# اختبر الاتصال
ssh -T git@github.com

# إذا فشل، أعد إنشاء SSH key
ssh-keygen -t ed25519 -C "بريدك@gmail.com" -f ~/.ssh/github_key
ssh-add ~/.ssh/github_key
```

### خطأ Permissions:
```bash
# على السيرفر
chown -R sarfesak:sarfesak /home/sarfesak/public_html/eliyaa
chmod -R 755 /home/sarfesak/public_html/eliyaa
chmod -R 775 storage bootstrap/cache
```

### خطأ Database:
```bash
# تحقق من إعدادات .env
php artisan config:clear
php artisan migrate:status
```

---

## 📈 الفوائد:

### ✅ سهولة النشر:
- **Git push** من localhost
- **Git pull** على السيرفر
- **تحديث فوري** بدون رفع ملفات

### ✅ تتبع التغييرات:
- **History كامل** للتعديلات
- **Rollback** للإصدارات السابقة
- **Collaboration** إذا كان هناك فريق

### ✅ النسخ الاحتياطي:
- **GitHub** كنسخة احتياطية سحابية
- **Multiple branches** للتطوير الآمن

---

## 🎯 الخلاصة:

### الطريقة المثالية:
1. **أنشئ repository** على GitHub (Private)
2. **ارفع الكود** من localhost
3. **انسخ المشروع** على السيرفر عبر Git
4. **استخدم Git** لجميع التحديثات المستقبلية

### بدلاً من الرفع اليدوي:
```
❌ رفع 11 ملف يدوياً كل مرة
✅ git push + git pull مرة واحدة
```

---

## 🚀 البدء الآن:

1. **أنشئ repository** على GitHub
2. **اتبع الخطوات** أعلاه
3. **استمتع** بالنشر السهل!

---

**هل تريد البدء بالإعداد؟** 🤔

أخبرني إذا كنت بحاجة لمساعدة في أي خطوة! 💪

---

**تاريخ الدليل:** 31 ديسمبر 2024

