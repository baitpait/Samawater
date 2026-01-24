# 🔧 حل مشكلة Node.js Version - ترقية Node.js على السيرفر

## ⚠️ تحذير مهم
**قبل البدء:** إذا كان لديك مشاريع أخرى على السيرفر تستخدم Node.js، استخدم **NVM** بدلاً من ترقية Node.js على مستوى النظام لتجنب التأثير على المشاريع الأخرى.

**راجع:** `NODE_UPGRADE_SAFE_GUIDE.md` للتفاصيل الكاملة.

---

## المشكلة
```
error during build:
TypeError: crypto$2.getRandomValues is not a function
```

**السبب:** السيرفر يستخدم Node.js v16.20.2، بينما المشروع يتطلب Node.js 18 أو أحدث.

---

## ✅ الحل الآمن: ترقية Node.js باستخدام NVM (موصى به)

### الخطوة 1: تثبيت NVM (Node Version Manager)

```bash
# تحميل وتثبيت NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# إعادة تحميل shell configuration
source ~/.bashrc
# أو
source ~/.zshrc
# أو
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

### الخطوة 2: تثبيت Node.js 20 (LTS - الأكثر استقراراً)

```bash
# تثبيت Node.js 20
nvm install 20

# استخدام Node.js 20 كإصدار افتراضي
nvm use 20
nvm alias default 20

# التحقق من الإصدار
node -v
npm -v
```

**يجب أن ترى:**
```
v20.x.x
10.x.x
```

### الخطوة 3: بناء Assets

```bash
# الانتقال إلى مجلد المشروع
cd /home/sarfesak/public_html/eliyaa

# حذف node_modules القديم (اختياري)
rm -rf node_modules package-lock.json

# تثبيت Dependencies من جديد
npm install

# بناء Assets
npm run build
```

---

## ⚠️ الحل البديل: تثبيت Node.js 20 مباشرة (بدون NVM)

**تحذير:** هذا الحل سيؤثر على جميع المشاريع على السيرفر. استخدمه فقط إذا كنت متأكداً أن جميع المشاريع تدعم Node.js 20.

### للأنظمة Ubuntu/Debian:

```bash
# تحديث النظام
apt update

# تثبيت Node.js 20 من NodeSource
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

# التحقق من الإصدار
node -v
npm -v
```

### للأنظمة CentOS/RHEL:

```bash
# تثبيت Node.js 20 من NodeSource
curl -fsSL https://rpm.nodesource.com/setup_20.x | bash -
yum install -y nodejs

# التحقق من الإصدار
node -v
npm -v
```

**ملاحظة:** إذا كان لديك مشاريع أخرى، استخدم NVM بدلاً من هذا الحل.

---

## 🎯 الحل السريع (نسخ ولصق)

```bash
# تثبيت NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# تثبيت Node.js 20
nvm install 20
nvm use 20
nvm alias default 20

# التحقق
node -v

# بناء Assets
cd /home/sarfesak/public_html/eliyaa
rm -rf node_modules package-lock.json
npm install
npm run build
```

---

## 🔍 التحقق من الإصدار

بعد التثبيت، تحقق من:

```bash
node -v  # يجب أن يكون v20.x.x أو v18.x.x
npm -v   # يجب أن يكون 10.x.x أو 9.x.x
```

---

## ⚠️ ملاحظات مهمة

### 1. إذا كنت تستخدم Webuzo

قد يكون Webuzo يستخدم Node.js الخاص به. في هذه الحالة:

```bash
# البحث عن Node.js في النظام
which node
which npm

# استخدام المسار الكامل
/usr/local/bin/node -v
```

### 2. إذا كان هناك عدة مستخدمين

إذا كان هناك مستخدمون آخرون، قد تحتاج لتثبيت NVM لكل مستخدم، أو تثبيت Node.js 20 على مستوى النظام.

### 3. إعادة تشغيل Shell

بعد تثبيت NVM، قد تحتاج لإعادة الاتصال بـ SSH أو إعادة تحميل shell:

```bash
source ~/.bashrc
# أو
exec bash
```

---

## 🚨 إذا استمرت المشكلة

### الحل البديل: بناء Assets محلياً ثم رفعها

**على جهازك المحلي:**

```bash
cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"
npm install
npm run build
```

**ثم ارفع مجلد `public/build/` إلى السيرفر:**

```bash
# من جهازك المحلي
scp -r public/build username@server-ip:/home/sarfesak/public_html/eliyaa/public/
```

---

## ✅ قائمة التحقق

- [ ] تم تثبيت NVM أو Node.js 20
- [ ] `node -v` يظهر v20.x.x أو v18.x.x
- [ ] `npm -v` يظهر إصدار حديث
- [ ] تم حذف `node_modules` القديم (اختياري)
- [ ] تم تشغيل `npm install` بنجاح
- [ ] تم تشغيل `npm run build` بنجاح
- [ ] ملفات `public/build/` موجودة

---

## 📞 إذا واجهت مشاكل

### مشكلة: "nvm: command not found"

```bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

### مشكلة: "Permission denied"

```bash
# إذا كنت root، لا مشكلة
# إذا كنت مستخدم عادي، قد تحتاج sudo
sudo npm install -g npm@latest
```

### مشكلة: "EACCES: permission denied"

```bash
# تغيير مالك مجلد npm
sudo chown -R $(whoami) ~/.npm
```

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** حل مشكلة Node.js Version على السيرفر

