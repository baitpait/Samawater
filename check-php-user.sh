#!/bin/bash

echo "=== التحقق من المستخدم الذي يشغل PHP-FPM ==="
ps aux | grep php-fpm | grep -v grep | head -3

echo ""
echo "=== التحقق من إعدادات PHP-FPM ==="
if [ -f /etc/php/8.2/fpm/pool.d/www.conf ]; then
    echo "PHP 8.2:"
    grep -E "^user|^group" /etc/php/8.2/fpm/pool.d/www.conf
fi

if [ -f /etc/php/8.1/fpm/pool.d/www.conf ]; then
    echo "PHP 8.1:"
    grep -E "^user|^group" /etc/php/8.1/fpm/pool.d/www.conf
fi

if [ -f /etc/php/8.0/fpm/pool.d/www.conf ]; then
    echo "PHP 8.0:"
    grep -E "^user|^group" /etc/php/8.0/fpm/pool.d/www.conf
fi

echo ""
echo "=== التحقق من أذونات المجلدات الأب ==="
ls -la /home/sarfesak/public_html/eliyaa/storage/framework/ | head -10
ls -la /home/sarfesak/public_html/eliyaa/storage/ | head -10



