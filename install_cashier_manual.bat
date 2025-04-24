@echo off
setlocal enabledelayedexpansion

:: Переход в корень проекта
cd /d D:\OpenServer_6\home\on-hype.loc

:: Создание временной папки
set TMP_DIR=%cd%\manual_tmp
mkdir "%TMP_DIR%"

echo Скачивание ZIP-архивов...

:: Скачивание зависимостей
powershell -Command "Invoke-WebRequest -Uri https://github.com/laravel/cashier-stripe/archive/refs/tags/v15.6.3.zip -OutFile %TMP_DIR%\cashier.zip"
powershell -Command "Invoke-WebRequest -Uri https://github.com/stripe/stripe-php/archive/refs/tags/v16.6.0.zip -OutFile %TMP_DIR%\stripe.zip"
powershell -Command "Invoke-WebRequest -Uri https://github.com/moneyphp/money/archive/refs/tags/v4.7.0.zip -OutFile %TMP_DIR%\money.zip"
powershell -Command "Invoke-WebRequest -Uri https://github.com/symfony/polyfill-intl-icu/archive/refs/tags/v1.31.0.zip -OutFile %TMP_DIR%\icu.zip"

echo Распаковка...

:: Распаковка
powershell -Command "Expand-Archive -Path %TMP_DIR%\cashier.zip -DestinationPath %TMP_DIR%\cashier"
powershell -Command "Expand-Archive -Path %TMP_DIR%\stripe.zip -DestinationPath %TMP_DIR%\stripe"
powershell -Command "Expand-Archive -Path %TMP_DIR%\money.zip -DestinationPath %TMP_DIR%\money"
powershell -Command "Expand-Archive -Path %TMP_DIR%\icu.zip -DestinationPath %TMP_DIR%\icu"

:: Перемещение в vendor
echo Копирование в vendor...

xcopy /E /Y /I "%TMP_DIR%\cashier\cashier-stripe-15.6.3" "vendor\laravel\cashier"
xcopy /E /Y /I "%TMP_DIR%\stripe\stripe-php-16.6.0" "vendor\stripe\stripe-php"
xcopy /E /Y /I "%TMP_DIR%\money\money-4.7.0" "vendor\moneyphp\money"
xcopy /E /Y /I "%TMP_DIR%\icu\polyfill-intl-icu-1.31.0" "vendor\symfony\polyfill-intl-icu"

echo Очистка...
rd /s /q "%TMP_DIR%"

echo Обновление автозагрузки...
composer dump-autoload

echo Готово!
pause
