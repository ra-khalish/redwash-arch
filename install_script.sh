#!/bin/bash

echo "[~] Build Image Notification Service"
cd notification_service
docker build --tag notification_service:1.0 .
cd ..

echo "[~] Build Image Redwash Web"
cd redwash
docker build --tag redwash_web:1.0 .
cd ..

echo "[~] Run Docker Compose"
docker-compose up -d

echo "[~] Install dependency of Redwash Web"
docker-compose exec redwash_web composer install