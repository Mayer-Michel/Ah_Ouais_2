#!/usr/bin/sh
mariadb-dump ahouais -uroot -pBatmanEgy > /root/Backup-`(date -I)`.sql
echo "Sauvegarde terminée"