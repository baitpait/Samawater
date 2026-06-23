# دليل النشر على السيرفر — Sama Water

> **المسار الإنتاجي:** `/home/sarfesak/public_html/sama`  
> **المستودع:** https://github.com/baitpait/Samawater  
> **الفرع:** `main`

---

## 1. سير العمل القياسي (بعد كل تحديث محلي)

### على الجهاز المحلي

```bash
git add .
git commit -m "feat: وصف التغيير"
git push origin main
```

الرفع المحلي يستخدم SSH إن وُجد مفتاح على الجهاز:

```bash
git push git@github.com:baitpait/Samawater.git main
```

### على السيرفر

```bash
cd /home/sarfesak/public_html/sama
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan view:clear
```

**بناء الواجهة (Vite 6 — يتطلب Node ≥ 18، موصى به Node 20):**

```bash
source ~/.nvm/nvm.sh 2>/dev/null
nvm use 20
npm install
npm run build
```

---

## 2. Git — المصادقة والأخطاء الشائعة

### المستودع عام (Public)

بعد تحويل الريبو إلى عام (يونيو 2026):

```bash
git remote set-url origin https://github.com/baitpait/Samawater.git
git pull origin main
```

لا حاجة لـ username/password للقراءة.

> **تحذير أمني:** المستودع العام يعني أن الكود قابل للقراءة من أي شخص. لا ترفع `.env` أو أسراراً. راجع `.gitignore`.

### HTTPS + كلمة مرور GitHub

**لا يعمل.** GitHub أوقف كلمة المرور لعمليات Git.

```
remote: Password authentication is not supported for Git operations.
```

**الحلول:**

| الطريقة | متى تُستخدم |
|---------|-------------|
| HTTPS + مستودع عام | سحب فقط بدون token |
| HTTPS + Personal Access Token | مستودع خاص |
| SSH + Deploy Key | مستودع خاص — مفتاح لكل repo |

### SSH — Deploy Key (مستودع خاص)

**قاعدة GitHub:** مفتاح النشر يُربط **بمستودع واحد فقط**.

إذا ظهرت:

```
Hi baitpait/Doooor! You've successfully authenticated...
ERROR: Repository not found.
```

المفتاح مربوط بمستودع آخر (مثل Doooor) وليس Samawater.

**إنشاء مفتاح جديد لـ Samawater:**

```bash
ssh-keygen -t ed25519 -C "server1-sama-water" -f ~/.ssh/id_ed25519_samawater -N ""
cat ~/.ssh/id_ed25519_samawater.pub
```

أضف المخرجات في:  
https://github.com/baitpait/Samawater/settings/keys → **Add deploy key**

**`~/.ssh/config`:**

```
Host github.com-samawater
  HostName github.com
  User git
  IdentityFile ~/.ssh/id_ed25519_samawater
  IdentitiesOnly yes
```

```bash
ssh -T git@github.com-samawater
# المتوقع: Hi baitpait/Samawater!

cd /home/sarfesak/public_html/sama
git remote set-url origin git@github.com-samawater:baitpait/Samawater.git
git pull origin main
```

---

## 3. Node.js و `npm run build`

### الخطأ

```
TypeError: crypto$2.getRandomValues is not a function
```

**السبب:** Node قديم (غالباً 16 أو أقل). المشروع يستخدم **Vite 6** → يحتاج **Node 18+** (موصى به **20**).

### الحل الآمن (NVM — لا يكسر مشاريع أخرى على السيرفر)

```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
export NVM_DIR="$HOME/.nvm"
source "$NVM_DIR/nvm.sh"
nvm install 20
nvm alias default 20
```

في مجلد المشروع:

```bash
echo "20" > .nvmrc
nvm use
node -v   # v20.x.x
npm install && npm run build
```

مرجع إضافي: `NODE_UPGRADE_SAFE_GUIDE.md`

---

## 4. Migrations بعد السحب

آخر دفعة مهمة (كوميت `8b3b54e` وما بعده):

| الملف | الغرض |
|-------|--------|
| `2026_06_01_210000_create_expense_beneficiaries_table.php` | جدول أصحاب المصروف + ربط بالمصروفات |
| `2026_06_01_220000_replace_beneficiary_type_with_expense_category_on_expense_beneficiaries.php` | استبدال النوع الثابت بفئة مصروف |

```bash
php artisan migrate --force
```

إذا ظهر `Nothing to migrate` بعد فشل `git pull` — الكود لم يُحدَّث؛ أصلح Git أولاً.

---

## 5. التحقق بعد النشر

```bash
php artisan about
php artisan route:list --path=admin/dashboard
git log -1 --oneline
```

**في المتصفح:**

- `/admin/dashboard` — لوحة المالك (KPIs: تسليمات، كاش، عهدة، مستحقات)
- `/admin/expense-beneficiary` — أصحاب المصروف
- `/admin/reports/advanced` — رصيد القوارير لكل العملاء

---

## 6. استكشاف الأخطاء

| العرض | السبب المحتمل | الإجراء |
|-------|---------------|---------|
| لوحة قديمة (روابط فقط) | `git pull` لم ينجح | تحقق من `git log -1` = آخر كوميت |
| `ParseError unexpected end of file` | Blade ناقص `@endif` | `php artisan view:clear` بعد سحب الإصلاح |
| `Nothing to migrate` | كود قديم على السيرفر | أصلح `git pull` |
| `npm run build` فشل | Node قديم | NVM + Node 20 |
| `Repository not found` (SSH) | Deploy key على repo خاطئ | مفتاح جديد لـ Samawater |

---

## 7. مراجع

- `PROJECT_LOG.md` — سجل التغييرات التفصيلي
- `SERVER_MANIFEST.md` — الستاك التقني
- `docs/decisions/ADR-007-expense-beneficiaries.md`
- `docs/decisions/ADR-008-owner-dashboard-routing.md`
- `GIT_SETUP_GUIDE.md` — إعداد Git محلي وسيرفر

---

*آخر تحديث: 2026-06-01*
