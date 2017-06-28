#!/bin/sh

CUR_DIR=`readlink -f $0`
CUR_DIR=`dirname "${CUR_DIR}"`
cd ${CUR_DIR}
export PATH=${HOME}/bin:/usr/local/bin:/home/s/bin:${CUR_DIR}/env/bin:${PATH}

python get_lianjia.py
echo "cp data/house.data /usr/share/nginx/html/house_stat/"
cp data/house.data /usr/share/nginx/html/house_stat/
