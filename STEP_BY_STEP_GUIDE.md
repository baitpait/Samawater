# 📝 دليل خطوة بخطوة - أين تكتب كل أمر

## 🎯 الهدف
ترقية Node.js لمشروع eliyaa فقط بدون التأثير على المشاريع الأخرى.

---

## ✅ الخطوة 1: الاتصال بالسيرفر

**أين:** على جهازك المحلي (Terminal أو SSH Client)

```bash
ssh root@your-server-ip
# أو
ssh root@server1
```

**بعد الاتصال، ستكون في:**
```
root@server1:~#
```

---

## ✅ الخطوة 2: تحميل NVM

**أين:** في Terminal السيرفر (أنت الآن في `/root`) 

```bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

**التحقق:**
```bash
nvm --version
```

**يجب أن ترى:** رقم إصدار NVM (مثل: `0.39.0`)

---

## ✅ الخطوة 3: التحقق من الإصدارات المثبتة

**أين:** في Terminal السيرفر (في `/root`)

```bash
nvm list
```

**يجب أن ترى:**
```
->     v16.20.2
```

---

## ✅ الخطوة 4: تثبيت Node.js 20

**أين:** في Terminal السيرفر (في `/root`)

```bash
nvm install 20
```

**انتظر حتى يكتمل التثبيت...**

**التحقق:**
```bash
nvm list
```

**يجب أن ترى الآن:**
```
->     v16.20.2
       v20.x.x
```

---

## ✅ الخطوة 5: الانتقال إلى مجلد مشروع eliyaa

**أين:** في Terminal السيرفر

```bash
cd /home/sarfesak/public_html/eliyaa
```

**التحقق من أنك في المكان الصحيح:**
```bash
pwd
```

**يجب أن ترى:**
```
/home/sarfesak/public_html/eliyaa
```

**التحقق من وجود ملفات المشروع:**
```bash
ls -la
```

**يجب أن ترى:** `package.json`, `artisan`, `composer.json`, إلخ.

---

## ✅ الخطوة 6: استخدام Node.js 20 لمشروع eliyaa

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
nvm use 20
```

**التحقق:**
```bash
node -v
```

**يجب أن ترى:**
```
v20.x.x
```

**التحقق من المسار:**
```bash
which node
```

**يجب أن ترى:**
```
/root/.nvm/versions/node/v20.x.x/bin/node
```

---

## ✅ الخطوة 7: إنشاء ملف .nvmrc (للاستخدام التلقائي)

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
echo "20" > .nvmrc
```

**التحقق:**
```bash
cat .nvmrc
```

**يجب أن ترى:**
```
20
```

---

## ✅ الخطوة 8: حذف node_modules القديم (اختياري لكن موصى به)

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
rm -rf node_modules package-lock.json
```

**التحقق:**
```bash
ls -la | grep node_modules
```

**يجب ألا ترى:** `node_modules` (تم حذفه)

---

## ✅ الخطوة 9: تثبيت Dependencies

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
npm install
```

**انتظر حتى يكتمل التثبيت...**

**التحقق:**
```bash
ls -la | grep node_modules
```

**يجب أن ترى:** `node_modules` (تم إنشاؤه من جديد)

---

## ✅ الخطوة 10: بناء Assets

**أين:** في Terminal السيرفر (في `/home/sarfesak/public_html/eliyaa`)

```bash
npm run build
```

**انتظر حتى يكتمل البناء...**

**يجب أن ترى في النهاية:**
```
✓ built in X.XXs
```

**التحقق من ملفات البناء:**
```bash
ls -la public/build/
```

**يجب أن ترى:** ملفات CSS و JavaScript

---

## ✅ الخطوة 11: التحقق من عدم التأثير على المشاريع الأخرى

**أين:** في Terminal السيرفر

### التحقق من مشروع abushanab:

```bash
cd /home/sarfesak/public_html/abushanab
nvm use 16
node -v
```

**يجب أن ترى:**
```
v16.20.2
```

### التحقق من مشروع afifabdeen:

```bash
cd /home/sarfesak/public_html/afifabdeen
nvm use 16
node -v
```

**يجب أن ترى:**
```
v16.20.2
```

---

## ✅ الخطوة 12: ضمان الاستمرار بعد إعادة الاتصال

**أين:** في Terminal السيرفر (في `/root`)

```bash
cd ~
```

**التحقق من وجود NVM في ~/.bashrc:**
```bash
grep -q "NVM_DIR" ~/.bashrc && echo "موجود" || echo "غير موجود"
```

**إذا كان غير موجود، أضفه:**
```bash
echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"' >> ~/.bashrc
```

**إعادة تحميل:**
```bash
source ~/.bashrc
```

---

## 📋 ملخص المسارات

| الخطوة | المسار الحالي | الأمر |
|--------|--------------|-------|
| 1 | جهازك المحلي | `ssh root@server-ip` |
| 2 | `/root` | `export NVM_DIR=...` |
| 3 | `/root` | `nvm list` |
| 4 | `/root` | `nvm install 20` |
| 5 | `/root` | `cd /home/sarfesak/public_html/eliyaa` |
| 6 | `/home/sarfesak/public_html/eliyaa` | `nvm use 20` |
| 7 | `/home/sarfesak/public_html/eliyaa` | `echo "20" > .nvmrc` |
| 8 | `/home/sarfesak/public_html/eliyaa` | `rm -rf node_modules` |
| 9 | `/home/sarfesak/public_html/eliyaa` | `npm install` |
| 10 | `/home/sarfesak/public_html/eliyaa` | `npm run build` |
| 11 | `/home/sarfesak/public_html/eliyaa` | `cd /home/sarfesak/public_html/abushanab` |
| 12 | `/root` | `echo 'export NVM_DIR=...' >> ~/.bashrc` |

---

## 🔍 كيف تعرف أنك في المسار الصحيح؟

### في مجلد eliyaa:
```bash
pwd
# يجب أن يكون: /home/sarfesak/public_html/eliyaa

ls -la | grep package.json
# يجب أن ترى: package.json

ls -la | grep artisan
# يجب أن ترى: artisan
```

### في مجلد root:
```bash
pwd
# يجب أن يكون: /root

ls -la | grep .nvm
# يجب أن ترى: .nvm
```

---

## ⚠️ إذا واجهت مشاكل

### مشكلة: "nvm: command not found"

**الحل:**
```bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

### مشكلة: "node: command not found" بعد `nvm use 20`

**الحل:**
```bash
# تأكد من أنك في مجلد eliyaa
cd /home/sarfesak/public_html/eliyaa

# استخدم nvm use مرة أخرى
nvm use 20

# تحقق
node -v
```

### مشكلة: "npm: command not found"

**الحل:**
```bash
# تأكد من استخدام Node.js 20
nvm use 20

# تحقق من npm
npm -v
```

---

## ✅ قائمة التحقق النهائية

- [ ] تم الاتصال بالسيرفر
- [ ] تم تحميل NVM بنجاح
- [ ] تم تثبيت Node.js 20
- [ ] تم الانتقال إلى `/home/sarfesak/public_html/eliyaa`
- [ ] تم استخدام Node.js 20 (`nvm use 20`)
- [ ] تم إنشاء ملف `.nvmrc`
- [ ] تم حذف `node_modules` القديم
- [ ] تم تثبيت Dependencies (`npm install`)
- [ ] تم بناء Assets (`npm run build`)
- [ ] تم التحقق من المشاريع الأخرى (لا تزال تستخدم Node.js 16)
- [ ] تم إضافة NVM إلى `~/.bashrc`

---

## 🎉 النتيجة النهائية

بعد إكمال جميع الخطوات:
- ✅ مشروع eliyaa يستخدم Node.js 20
- ✅ المشاريع الأخرى (abushanab, afifabdeen) لا تزال تستخدم Node.js 16
- ✅ لا يوجد تأثير على المشاريع الأخرى
- ✅ `npm run build` يعمل بنجاح

---

**تاريخ الإنشاء:** 2025-01-01
**الغرض:** دليل خطوة بخطوة يوضح أين تكتب كل أمر

