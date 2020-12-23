#!/bin/sh

touch /data/html/oup-books_d
sudo chmod -R 777 /data/html/oup-books_d
cd /data/html/oup-books_d

git clone git+ssh://developer@172.24.182.52/var/www/html/pmbot/develop .

sudo mkdir background_process

sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap

sudo chmod -R 777 background_process

sudo cp -av /data/html/oup-books/background_process/. /data/html/oup-books_d/background_process/

sudo chmod -R 777 background_process/log
sudo chmod -R 777 background_process/api/log
sudo chmod -R 777 background_process/sentiment/logs
