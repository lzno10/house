#!/bin/sh

CUR_DIR=`readlink -f $0`
CUR_DIR=`dirname "${CUR_DIR}"`
cd ${CUR_DIR}
export PATH=${HOME}/bin:/usr/local/bin:/home/s/bin:${CUR_DIR}/env/bin:${PATH}

program="house_stat/"
exclude_list=".exclude.list"
src_dir="/home/liuzhuo/project/house"
dest_user=""
dest_host=""
dest_dir="/usr/share/nginx/html/house"

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

if [ "${dest_host}"x != ""x ];then
    dest_dir=${dest_user}@${dest_host}:${dest_dir}
fi
echo -e "\n-----run rsync-----"
echo "rsync -vtr --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_dir}"
rsync -vtr --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_dir}

echo -e "\n-----check delete-----"
echo "rsync -vtrn --delete --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_dir}"
rsync -vtrn --delete --exclude-from=${exclude_list} ${src_dir}/${program} ${dest_dir}
