# ⚠️ دليل آمن لترقية Node.js بدون التأثير على المشاريع الأخرى

## 🎯 المشكلة
ترقية Node.js على مستوى النظام قد تؤثر على **جميع المشاريع** على السيرفر.

---

## ✅ الحل الآمن: استخدام NVM (موصى به)

**NVM يسمح لك بـ:**
- تثبيت عدة إصدارات من Node.js
- استخدام إصدار مختلف لكل مشروع
- عدم التأثير على المشاريع الأخرى

---

## 📋 الطريقة الآمنة (خطوة بخطوة)

### الخطوة 1: التحقق من المشاريع الحالية

```bash
# البحث عن جميع المشاريع التي تستخدم Node.js
find /home -name "package.json" -type f 2>/dev/null | head -20

# التحقق من الإصدار الحالي المستخدم
node -v
which node
```

### الخطوة 2: تثبيت NVM (بدون التأثير على النظام)

```bash
# تثبيت NVM للمستخدم الحالي فقط
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# تحميل NVM
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

**مهم:** NVM يتم تثبيته في مجلد المستخدم (`~/.nvm`) و**لا يؤثر** على Node.js النظام.

### الخطوة 3: تثبيت Node.js 20 باستخدام NVM

```bash
# تثبيت Node.js 20
nvm install 20

# استخدام Node.js 20 للمشروع الحالي فقط
nvm use 20

# (اختياري) جعله افتراضي للمستخدم الحالي فقط
nvm alias default 20
```

### الخطوة 4: إضافة NVM إلى shell profile (للاستمرار)

```bash
# إضافة إلى ~/.bashrc أو ~/.zshrc
echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"' >> ~/.bashrc

# إعادة تحميل
source ~/.bashrc
```

---

## 🔄 استخدام إصدارات مختلفة لمشاريع مختلفة

### للمشروع الجديد (eliyaa) - Node.js 20:

```bash
cd /home/sarfesak/public_html/eliyaa
nvm use 20
node -v  # يجب أن يكون v20.x.x
npm run build
```

### للمشاريع القديمة - Node.js 16:

```bash
cd /home/sarfesak/public_html/old-project
nvm use 16
node -v  # يجب أن يكون v16.x.x
npm install
```

### إنشاء ملف .nvmrc لكل مشروع (موصى به)

**في مجلد المشروع eliyaa:**
```bash
cd /home/sarfesak/public_html/eliyaa
echo "20" > .nvmrc
nvm use  # سيستخدم تلقائياً الإصدار المحدد في .nvmrc
```

**في مجلد مشروع قديم:**
```bash
cd /home/sarfesak/public_html/old-project
echo "16" > .nvmrc
nvm use  # سيستخدم Node.js 16
```

---

## ⚠️ ما يجب تجنبه

### ❌ لا تفعل هذا (سيؤثر على جميع المشاريع):

```bash
# تثبيت Node.js على مستوى النظام
apt-get install nodejs
# أو
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs
```

**لماذا؟** لأن هذا سيستبدل Node.js النظام ويؤثر على جميع المشاريع.

---

## ✅ الحل البديل: تثبيت Node.js 20 بجانب الإصدار القديم

إذا كان يجب تثبيت Node.js على مستوى النظام:

### 1. التحقق من الإصدار الحالي:

```bash
node -v
which node
```

### 2. تثبيت Node.js 20 بجانب الإصدار القديم:

```bash
# تثبيت Node.js 20
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

# التحقق من الإصدارات المثبتة
dpkg -l | grep nodejs
```

### 3. استخدام update-alternatives (للتبديل بين الإصدارات):

```bash
# إضافة Node.js 16 (إذا كان موجوداً)
update-alternatives --install /usr/bin/node node /usr/bin/node16 1

# إضافة Node.js 20
update-alternatives --install /usr/bin/node node /usr/bin/node20 2

# اختيار الإصدار الافتراضي
update-alternatives --config node
```

---

## 🔍 التحقق من عدم التأثير على المشاريع الأخرى

### بعد التثبيت:

```bash
# 1. التحقق من جميع المشاريع
find /home -name "package.json" -type f 2>/dev/null

# 2. اختبار كل مشروع
for project in /home/*/public_html/*; do
    if [ -f "$project/package.json" ]; then
        echo "اختبار: $project"
        cd "$project"
        node -v
        npm --version
        echo "---"
    fi
done
```

### 3. التحقق من أن المشاريع القديمة لا تزال تعمل:

```bash
# لكل مشروع قديم
cd /path/to/old-project
node -v  # يجب أن يكون الإصدار المتوقع
npm install  # يجب أن يعمل بدون أخطاء
```

---

## 📝 أفضل الممارسات

### 1. استخدام NVM لكل مستخدم

```bash
# لكل مستخدم على السيرفر
su - username
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
```

### 2. إنشاء ملف .nvmrc لكل مشروع

```bash
# في كل مشروع
echo "20" > .nvmrc  # أو "16" أو "18" حسب المشروع
```

### 3. استخدام npm scripts مع nvm

```bash
# في package.json
{
  "scripts": {
    "preinstall": "nvm use",
    "build": "vite build"
  }
}
```

---

## 🎯 الحل الموصى به لسيرفر Webuzo

### للمستخدم sarfesak:

```bash
# 1. تسجيل الدخول كمستخدم sarfesak
su - sarfesak

# 2. تثبيت NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# 3. إضافة إلى ~/.bashrc
echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc

# 4. إعادة تحميل
source ~/.bashrc

# 5. تثبيت Node.js 20
nvm install 20
nvm use 20
nvm alias default 20

# 6. استخدامه في مشروع eliyaa
cd /home/sarfesak/public_html/eliyaa
echo "20" > .nvmrc
nvm use
npm install
npm run build
```

**مميزات هذا الحل:**
- ✅ لا يؤثر على المشاريع الأخرى
- ✅ يمكن استخدام إصدارات مختلفة لكل مشروع
- ✅ سهل الإدارة والصيانة
- ✅ لا يحتاج صلاحيات root

---

## 🔄 إذا أردت العودة للإصدار القديم

```bash
# استخدام Node.js 16
nvm use 16

# أو استخدام Node.js النظام (إذا كان موجوداً)
nvm use system
```

---

## ✅ قائمة التحقق

- [ ] تم التحقق من جميع المشاريع على السيرفر
- [ ] تم تثبيت NVM (وليس Node.js على مستوى النظام)
- [ ] تم تثبيت Node.js 20 باستخدام NVM
- [ ] تم إنشاء ملف `.nvmrc` في مشروع eliyaa
- [ ] تم اختبار المشاريع القديمة (لا تزال تعمل)
- [ ] تم بناء Assets لمشروع eliyaa بنجاح
- [ ] تم إضافة NVM إلى `~/.bashrc` للاستمرار

---

## 📞 إذا واجهت مشاكل

### مشكلة: مشروع قديم توقف عن العمل

```bash
# استخدام الإصدار القديم لهذا المشروع
cd /path/to/old-project
nvm use 16  # أو الإصدار المطلوب
```

### مشكلة: NVM لا يعمل بعد إعادة الاتصال

```bash
# إعادة تحميل NVM
source ~/.bashrc
# أو
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

---

## 📚 ملخص

| الطريقة | التأثير على المشاريع الأخرى | الصعوبة | موصى به |
|---------|---------------------------|---------|---------|
| **NVM** | ❌ لا يؤثر | ⭐ سهل | ✅ نعم |
| Node.js على مستوى النظام | ✅ يؤثر | ⭐⭐ متوسط | ❌ لا |
| update-alternatives | ⚠️ يحتاج إدارة | ⭐⭐⭐ صعب | ⚠️ فقط إذا لزم |

---

**الخلاصة:** استخدم **NVM** لأنه الحل الأكثر أماناً ولا يؤثر على المشاريع الأخرى.

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** ترقية Node.js بشكل آمن بدون التأثير على المشاريع الأخرى

