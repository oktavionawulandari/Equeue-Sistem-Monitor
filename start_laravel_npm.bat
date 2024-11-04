@echo off
timeout /t 10 /nobreak  >nul
D:\webbase-antrian\webbase-antrian


start cmd /k "cd /d D:\webbase-antrian\webbase-antrian && php artisan serve --host=192.168.1.19"

REM Menjalankan npm run dev di jendela baru
start cmd /k "cd /d D:\webbase-antrian\webbase-antrian && npm run dev"
