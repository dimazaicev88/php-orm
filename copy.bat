@echo off
chcp 65001 >nul

set SOURCE_PATH=E:\projects\php-orm\generated
set DEST_PATH=E:\projects\orm-test\src\Ptr

echo Удаление директории, если она существует...
if exist "%DEST_PATH%" (
    rmdir /s /q "%DEST_PATH%"
    echo Директория удалена: %DEST_PATH%
)

echo Создание новой директории...
mkdir "%DEST_PATH%"

echo Копирование файлов...
xcopy "%SOURCE_PATH%\*" "%DEST_PATH%\" /E /I /H /Y

echo Операция завершена!