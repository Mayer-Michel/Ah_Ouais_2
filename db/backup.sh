#!/usr/bin/sh
mariadb-dump mariadb_ahouais -uroot -pBatmanEgy > /root/Backup-`(date -I)`.sql
echo "Sauvegarde terminée"