#!/bin/bash

# سكريبت ترقية Node.js على السيرفر
# يجب تشغيله كـ root أو مستخدم مع صلاحيات sudo

echo "🔧 بدء ترقية Node.js..."
echo ""

# التحقق من الإصدار الحالي
echo "📋 الإصدار الحالي:"
node -v 2>/dev/null || echo "Node.js غير مثبت"
npm -v 2>/dev/null || echo "npm غير مثبت"
echo ""

# اختيار طريقة التثبيت
echo "اختر طريقة التثبيت:"
echo "1) تثبيت NVM ثم Node.js 20 (موصى به)"
echo "2) تثبيت Node.js 20 مباشرة من NodeSource (للأنظمة Ubuntu/Debian)"
echo "3) تثبيت Node.js 20 مباشرة من NodeSource (للأنظمة CentOS/RHEL)"
read -p "اختر رقم (1-3): " choice

case $choice in
    1)
        echo ""
        echo "📦 تثبيت NVM..."
        curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
        
        echo ""
        echo "🔄 تحميل NVM..."
        export NVM_DIR="$HOME/.nvm"
        [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
        
        echo ""
        echo "📦 تثبيت Node.js 20..."
        nvm install 20
        nvm use 20
        nvm alias default 20
        
        echo ""
        echo "✅ تم تثبيت Node.js 20 باستخدام NVM"
        ;;
    2)
        echo ""
        echo "📦 تثبيت Node.js 20 من NodeSource (Ubuntu/Debian)..."
        curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
        apt-get install -y nodejs
        
        echo ""
        echo "✅ تم تثبيت Node.js 20"
        ;;
    3)
        echo ""
        echo "📦 تثبيت Node.js 20 من NodeSource (CentOS/RHEL)..."
        curl -fsSL https://rpm.nodesource.com/setup_20.x | bash -
        yum install -y nodejs
        
        echo ""
        echo "✅ تم تثبيت Node.js 20"
        ;;
    *)
        echo "❌ اختيار غير صحيح"
        exit 1
        ;;
esac

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ تم إكمال التثبيت!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# التحقق من الإصدار الجديد
echo "📋 الإصدار الجديد:"
node -v
npm -v
echo ""

# السؤال عن بناء Assets
read -p "هل تريد بناء Assets الآن؟ (y/n): " build_choice
if [ "$build_choice" = "y" ] || [ "$build_choice" = "Y" ]; then
    echo ""
    echo "🎨 بناء Assets..."
    
    # البحث عن مجلد المشروع
    if [ -f "artisan" ]; then
        PROJECT_DIR="$(pwd)"
    elif [ -d "/home/sarfesak/public_html/eliyaa" ]; then
        PROJECT_DIR="/home/sarfesak/public_html/eliyaa"
    else
        read -p "أدخل مسار مجلد المشروع: " PROJECT_DIR
    fi
    
    if [ -d "$PROJECT_DIR" ]; then
        cd "$PROJECT_DIR"
        echo "📂 الانتقال إلى: $PROJECT_DIR"
        
        echo ""
        echo "🧹 حذف node_modules القديم..."
        rm -rf node_modules package-lock.json
        
        echo ""
        echo "📦 تثبيت Dependencies..."
        npm install
        
        echo ""
        echo "🎨 بناء Assets..."
        npm run build
        
        echo ""
        echo "✅ تم بناء Assets بنجاح!"
    else
        echo "❌ مجلد المشروع غير موجود: $PROJECT_DIR"
    fi
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ اكتمل!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📋 الخطوات التالية:"
echo "1. تحقق من الإصدار: node -v (يجب أن يكون v20.x.x)"
echo "2. إذا استخدمت NVM، أضف هذا السطر إلى ~/.bashrc:"
echo "   export NVM_DIR=\"\$HOME/.nvm\""
echo "   [ -s \"\$NVM_DIR/nvm.sh\" ] && \. \"\$NVM_DIR/nvm.sh\""
echo "3. جرب بناء Assets: cd /home/sarfesak/public_html/eliyaa && npm run build"
echo ""

