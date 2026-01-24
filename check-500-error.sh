#!/bin/bash

cd /home/sarfesak/public_html/eliyaa

echo "=== آخر 50 سطر من سجل Laravel ==="
tail -n 50 storage/logs/laravel.log

echo ""
echo "=== التحقق من أذونات storage ==="
ls -la storage/framework/views | head -5
ls -la storage/logs | head -5

echo ""
echo "=== التحقق من المستخدم الذي يشغل PHP ==="
ps aux | grep php-fpm | grep -v grep | head -3



