#!/bin/bash

# أوامر سريعة لإعداد GitHub repository لمشروع Eliyaa
echo "=========================================="
echo "🚀 إعداد GitHub لمشروع Eliyaa"
echo "=========================================="

cd "/Users/baitpait/BAITPAIT/Bait Pait/Project/water Aelea/eliyaa file/eliyaa"

echo ""
echo "📝 1. إعداد Git الأساسي:"
echo "---------------------------"
echo "# تأكد من وجود Git:"
echo "git --version"
echo ""
echo "# إعداد الاسم والبريد:"
echo "git config --global user.name 'اسمك الكامل'"
echo "git config --global user.email 'بريدك@gmail.com'"
echo ""

echo "📝 2. إنشاء SSH Key:"
echo "---------------------------"
echo "# إنشاء مفتاح SSH:"
echo "ssh-keygen -t ed25519 -C 'بريدك@gmail.com' -f ~/.ssh/github_eliyaa"
echo "ssh-add ~/.ssh/github_eliyaa"
echo "cat ~/.ssh/github_eliyaa.pub"
echo ""
echo "# انسخ المفتاح أعلاه وأضفه في:"
echo "# https://github.com/settings/keys"
echo ""

echo "📝 3. إعداد المشروع:"
echo "---------------------------"
echo "# إنشاء .gitignore:"
cat > .gitignore << 'EOF'
# Laravel
/vendor/
/node_modules/
/storage/app/
/storage/framework/cache/
/storage/framework/sessions/
/storage/framework/views/
/storage/logs/
/bootstrap/cache/

# Environment files
.env
.env.local
.env.production
.env.staging
.env.production.txt

# IDE and editors
.vscode/
.idea/
.DS_Store
Thumbs.db

# Logs
*.log

# Composer & Node
composer.lock
package-lock.json
yarn.lock

# Database
*.sqlite
*.sqlite3
EOF

echo "# تم إنشاء .gitignore"
echo ""

echo "# إنشاء README.md:"
cat > README.md << 'EOF'
# Eliyaa Water Distribution System
نظام توزيع مياه ايلياء - Laravel + Backpack

## المميزات
- إدارة العملاء والموزعين
- تتبع التسليمات والمدفوعات
- التقارير والإحصائيات
- تصميم متجاوب بخط Cairo
- نسخ احتياطي تلقائي

## التثبيت
1. `git clone git@github.com:اسم-المستخدم/eliyaa-water-distribution.git`
2. `composer install`
3. `npm install && npm run build`
4. `cp .env.example .env`
5. `php artisan key:generate`
6. `php artisan migrate`

## النشر
`git push origin main`
ثم `git pull origin main` على السيرفر
EOF

echo "# تم إنشاء README.md"
echo ""

echo "📝 4. إعداد repository محلي:"
echo "---------------------------"
echo "# إنشاء repository:"
echo "git init"
echo "git add ."
echo "git commit -m 'Initial commit - Eliyaa Water Distribution System'"
echo ""

echo "📝 5. إنشاء repository على GitHub:"
echo "---------------------------"
echo "1. اذهب إلى: https://github.com/new"
echo "2. Repository name: eliyaa-water-distribution"
echo "3. Description: نظام توزيع مياه ايلياء - Laravel + Backpack"
echo "4. Private: ✅"
echo "5. Create repository"
echo ""

echo "📝 6. ربط ورافع المشروع:"
echo "---------------------------"
echo "# ربط بـ GitHub (استبدل اسم-المستخدم):"
echo "git remote add origin git@github.com:اسم-المستخدم/eliyaa-water-distribution.git"
echo "git push -u origin main"
echo ""

echo "=========================================="
echo "🎯 على السيرفر (بعد الرفع):"
echo "=========================================="
echo ""
echo "# سحب المشروع للمرة الأولى:"
echo "cd /home/sarfesak/public_html"
echo "git clone git@github.com:اسم-المستخدم/eliyaa-water-distribution.git eliyaa"
echo "cd eliyaa"
echo "composer install --no-dev --optimize-autoloader"
echo "npm install && npm run build"
echo "cp .env.example .env"
echo "php artisan key:generate"
echo "php artisan migrate"
echo "php artisan optimize:clear"
echo ""

echo "# للتحديثات المستقبلية:"
echo "cd /home/sarfesak/public_html/eliyaa"
echo "git pull origin main"
echo "php artisan optimize:clear"
echo ""

echo "=========================================="
echo "✅ اتبع هذه الأوامر بالترتيب!"
echo "=========================================="
echo ""
echo "🔑 اسم Repository: eliyaa-water-distribution"
echo "🔒 نوع Repository: Private"
echo ""
echo "📞 تحتاج مساعدة؟ أخبرني!"
echo ""
echo "=========================================="
