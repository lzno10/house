#!/bin/sh

CUR_DIR=`readlink -f $0`
CUR_DIR=`dirname "${CUR_DIR}"`
cd ${CUR_DIR}
export PATH=${HOME}/bin:/usr/local/bin:/home/s/bin:${CUR_DIR}/env/bin:${PATH}

git ci -am "$1"
git push -u origin master
rm -rf /usr/share/nginx/html/house_stat/*
\cp -r ./house_stat/* /usr/share/nginx/html/house_stat/
echo -e "\n-----rsync-----"
rsync -rvt house_stat/ /usr/share/nginx/html/house_stat/

echo -e "\n-----check delete-----"
rsync -rvtn --delete house_stat/ /usr/share/nginx/html/house_stat/
echo "rsync -rvt --delete house_stat/ /usr/share/nginx/html/house_stat/"
