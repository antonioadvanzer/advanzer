#!/bin/sh
mysqldump -uadvanzer_ch -padvanzer_ch --opt advanzer_ch > /opt/rh/backups/advanzer_ch.sql
cd /opt/rh/backups/
tar -zcvf backup_$(date +%d%m%Y).tgz advanzer_ch.sql
#find -name '*.tgz' -type f -mtime +30 -exec rm -f {} ;
