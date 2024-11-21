@echo off
timeout /t 10 /nobreak  >nul

REM Menjalankan php artisan serve di jendela baru
start cmd /k "cd C:\laragon\www\E-Queue Sistem V.5.0 && php artisan serve --host=192.168.1.8"

REM Menjalankan npm run dev di jendela baru
start cmd /k "cd C:\laragon\www\E-Queue Sistem V.5.0 && npm run dev"
