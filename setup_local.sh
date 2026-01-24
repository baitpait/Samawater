#!/bin/bash

# سكريبت إعداد البيئة المحلية لنظام إيليا
# Usage: ./setup_local.sh

echo "🚀 بدء إعداد البيئة المحلية لنظام إيليا..."
echo ""

# الألوان
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# التحقق من وجود Laravel
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ خطأ: لا يمكن العثور على ملف artisan. تأكد من أنك في مجلد المشروع.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Laravel موجود${NC}"

# 1. تنظيف الكاش
echo ""
echo "🧹 تنظيف الكاش..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo -e "${GREEN}✅ تم تنظيف الكاش${NC}"

# 2. التحقق من ملف .env
echo ""
echo "📝 التحقق من ملف .env..."
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}⚠️  ملف .env غير موجود. سيتم إنشاؤه من .env.example${NC}"
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo -e "${GREEN}✅ تم إنشاء ملف .env${NC}"
    else
        echo -e "${RED}❌ خطأ: لا يمكن العثور على .env.example${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}✅ ملف .env موجود${NC}"
fi

# 3. تحديث APP_ENV و APP_DEBUG
echo ""
echo "⚙️  تحديث إعدادات التطبيق للمحلي..."
sed -i '' 's/APP_ENV=.*/APP_ENV=local/' .env 2>/dev/null || sed -i 's/APP_ENV=.*/APP_ENV=local/' .env
sed -i '' 's/APP_DEBUG=.*/APP_DEBUG=true/' .env 2>/dev/null || sed -i 's/APP_DEBUG=.*/APP_DEBUG=true/' .env
sed -i '' 's|APP_URL=.*|APP_URL=http://localhost:8000|' .env 2>/dev/null || sed -i 's|APP_URL=.*|APP_URL=http://localhost:8000|' .env
echo -e "${GREEN}✅ تم تحديث إعدادات التطبيق${NC}"

# 4. التحقق من قاعدة البيانات
echo ""
echo "🗄️  التحقق من إعدادات قاعدة البيانات..."
DB_CONNECTION=$(grep "^DB_CONNECTION=" .env | cut -d '=' -f2)
DB_DATABASE=$(grep "^DB_DATABASE=" .env | cut -d '=' -f2)

echo -e "${YELLOW}📊 نوع قاعدة البيانات: ${DB_CONNECTION}${NC}"
echo -e "${YELLOW}📊 اسم قاعدة البيانات: ${DB_DATABASE}${NC}"

if [ "$DB_CONNECTION" = "mysql" ] || [ "$DB_CONNECTION" = "mariadb" ]; then
    echo ""
    echo -e "${YELLOW}💡 تلميح: تأكد من أن قاعدة البيانات '${DB_DATABASE}' موجودة ومستوردة${NC}"
    echo -e "${YELLOW}   يمكنك استيرادها باستخدام:${NC}"
    echo -e "${YELLOW}   mysql -u root -p ${DB_DATABASE} < database_eliyaa.sql${NC}"
fi

# 5. التحقق من APP_KEY
echo ""
echo "🔑 التحقق من مفتاح التطبيق..."
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}⚠️  مفتاح التطبيق غير موجود. سيتم إنشاؤه...${NC}"
    php artisan key:generate
    echo -e "${GREEN}✅ تم إنشاء مفتاح التطبيق${NC}"
else
    echo -e "${GREEN}✅ مفتاح التطبيق موجود${NC}"
fi

# 6. تحديث الصلاحيات
echo ""
echo "🔐 تحديث صلاحيات الملفات..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || echo -e "${YELLOW}⚠️  لا يمكن تحديث الصلاحيات (قد تحتاج sudo)${NC}"
echo -e "${GREEN}✅ تم تحديث الصلاحيات${NC}"

# 7. تحديث الإعدادات
echo ""
echo "⚙️  تحديث إعدادات Laravel..."
php artisan config:cache
echo -e "${GREEN}✅ تم تحديث الإعدادات${NC}"

# 8. التحقق من Composer
echo ""
echo "📦 التحقق من المكتبات..."
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}⚠️  مجلد vendor غير موجود. سيتم تثبيت المكتبات...${NC}"
    composer install
    echo -e "${GREEN}✅ تم تثبيت المكتبات${NC}"
else
    echo -e "${GREEN}✅ المكتبات موجودة${NC}"
fi

# 9. التحقق من Node modules
echo ""
echo "📦 التحقق من Node modules..."
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}⚠️  مجلد node_modules غير موجود. سيتم تثبيته...${NC}"
    npm install
    echo -e "${GREEN}✅ تم تثبيت Node modules${NC}"
else
    echo -e "${GREEN}✅ Node modules موجودة${NC}"
fi

# 10. ملخص
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${GREEN}✅ تم إعداد البيئة المحلية بنجاح!${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📋 الخطوات التالية:"
echo ""
echo "1. تأكد من أن قاعدة البيانات جاهزة:"
if [ "$DB_CONNECTION" = "mysql" ] || [ "$DB_CONNECTION" = "mariadb" ]; then
    echo "   mysql -u root -p ${DB_DATABASE} < database_eliyaa.sql"
fi
echo ""
echo "2. شغل السيرفر:"
echo "   php artisan serve --host=0.0.0.0 --port=8000"
echo ""
echo "3. افتح المتصفح:"
echo "   http://localhost:8000"
echo "   http://localhost:8000/admin"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

