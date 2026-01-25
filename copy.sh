#!/bin/bash

SOURCE_PATH="/home/dima/projects/php-orm/generated"
DEST_PATH="/home/dima/projects/orm-test/src/Ptr"

echo "Удаление директории, если она существует..."
if [ -d "$DEST_PATH" ]; then
    rm -rf "$DEST_PATH"
    echo "Директория удалена: $DEST_PATH"
fi

echo "Создание новой директории..."
mkdir -p "$DEST_PATH"

echo "Копирование файлов..."
cp -r "$SOURCE_PATH"/* "$DEST_PATH"/

echo "Операция завершена!"