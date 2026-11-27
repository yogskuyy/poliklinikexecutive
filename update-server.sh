#!/bin/bash
set -e

echo "=========================================================="
echo "  SINKRONISASI & UPDATE POLIKLINIK EKSEKUTIF KE SERVER 136 "
echo "=========================================================="

APP_DIR="/var/www/poliklinikexecutive"

if [ ! -d "$APP_DIR" ]; then
    echo "[!] Direktori $APP_DIR tidak ditemukan. Menggunakan direktori aktif saat ini..."
    APP_DIR=$(pwd)
fi

cd "$APP_DIR"
echo "[+] Lokasi kerja: $APP_DIR"

# 1. Hentikan proses php serve lama yang mungkin menahan port 8000
echo "[+] Mematikan proses lama di port 8000..."
fuser -k 8000/tcp 2>/dev/null || true
pkill -9 -f "artisan serve" 2>/dev/null || true
sleep 1

# 2. Reset dan ambil commit terbaru dari GitHub
echo "[+] Mengambil kode terbaru dari GitHub..."
git fetch origin main
git reset --hard origin/main

# 3. Setup environment jika belum ada
if [ ! -f .env ]; then
    echo "[+] Membuat file .env dari template..."
    cp .env.example .env
    php artisan key:generate --force
fi

# 4. Bersihkan seluruh cache Laravel
echo "[+] Membersihkan cache views, routes, dan config..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 5. Atur permission folder storage & database
echo "[+] Mengatur permission folder storage & database..."
chown -R www-data:www-data "$APP_DIR"
chmod -R 775 storage bootstrap/cache database
if [ -f database/database.sqlite ]; then
    chmod 664 database/database.sqlite
fi

# 6. Jalankan php artisan serve di background
echo "[+] Menjalankan server aplikasi di port 8000..."
nohup php artisan serve --host=0.0.0.0 --port=8000 > /var/log/poliklinik.log 2>&1 &
sleep 2

# 7. Verifikasi status
if ss -tuln | grep -q ":8000 " || netstat -tuln 2>/dev/null | grep -q ":8000 "; then
    echo "=========================================================="
    echo " [BERHASIL] Aplikasi Poliklinik Eksekutif telah terupdate!"
    echo " URL Display TV : http://192.168.10.136:8000/tv"
    echo " URL Dashboard  : http://192.168.10.136:8000/dashboard"
    echo " Tekan Ctrl + F5 di browser TV untuk memuat tampilan baru."
    echo "=========================================================="
else
    echo "[!] Peringatan: Port 8000 belum terdeteksi. Silakan cek log di /var/log/poliklinik.log"
fi
