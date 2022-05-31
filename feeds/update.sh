#!/bin/bash
cd /var/www/plots_new/cache/
chmod 666 device_*
/usr/bin/python updateFeeds.py
for i in device_*.csv; do python csv2xml.py $i; done
