#!/bin/sh

CUR_DIR=`readlink -f $0`
CUR_DIR=`dirname "${CUR_DIR}"`
cd ${CUR_DIR}
export PATH=${HOME}/bin:/usr/local/bin:/home/s/bin:${CUR_DIR}/env/bin:${PATH}

#git ci -am "$1"
#git push -u origin master
#rm -rf /usr/share/nginx/html/house_stat/*
#\cp -r ./house_stat/* /usr/share/nginx/html/house_stat/
#echo -e "\n-----rsync-----"
#rsync -rvt house_stat/ /usr/share/nginx/html/house_stat/

#echo -e "\n-----check delete-----"
#rsync -rvtn --delete house_stat/ /usr/share/nginx/html/house_stat/
#echo "rsync -rvt --delete house_stat/ /usr/share/nginx/html/house_stat/"


program="house_stat"
exclude_list=".exclude.list"
src_dir="/home/liuzhuo/project/house"
dest_user="liuzhuo"
dest_host="localhost"
dest_dir="/usr/share/nginx/html/"

update_git() {
    msg="$1"
    echo "git ci -am \"${msg}\""
    git ci -am "${msg}"
}
if [ "${1}"x != ""x ];then
    update_git "$1"
    echo "git push -u origin master"
    git push -u origin master
fi
echo -e "\n-----run rsync-----"
echo "rsync -vtr --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_user}@${dest_host}:${dest_dir}"
rsync -vtr --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_user}@${dest_host}:${dest_dir}
echo -e "\n-----check delete-----"
echo "rsync -vtrn --delete --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_user}@${dest_host}:${dest_dir}"
rsync -vtrn --delete --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_user}@${dest_host}:${dest_dir}
