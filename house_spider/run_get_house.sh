#!/bin/sh

CUR_DIR=`readlink -f $0`
CUR_DIR=`dirname "${CUR_DIR}"`
cd ${CUR_DIR}
export PATH=${HOME}/bin:/usr/local/bin:/home/s/bin:${CUR_DIR}/env/bin:${PATH}

echo `date`" begin get data"
python get_lianjia.py
echo `date`"finish get data"

echo "cp data/house.data /usr/share/nginx/html/house_stat/"
\cp data/house.data /usr/share/nginx/html/house_stat/
\cp data/house.data data/house.data.`date +%Y%m%d`
echo -e `date`" finish\n\n"
