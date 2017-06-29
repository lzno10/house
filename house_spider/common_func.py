#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
import time
import re
path = sys.path[0]
import_path = [path+"/conf","/home/hdp-map/liuzhuo/project/main_name"]
for path in import_path:
    sys.path.append(path)

def print_time(output_str):
    TIMEFORMAT = "%Y-%m-%d %H:%M:%S"
    cur_time = time.strftime(TIMEFORMAT, time.localtime())
    print >> sys.stderr, output_str + cur_time

def timeit(func):
    def wrapper(arg):
        start = time.clock()
        func(arg)
        end = time.clock()
        print "total time: %.2fs" % (end-start)
    return wrapper

def enc(input_str):
    try:
        return input_str.encode("utf-8")
    except:
        return input_str

def dec(input_str):
    try:
        return input_str.decode("utf-8")
    except:
        return input_str

#去掉括号中的内容
def rm_bracket(word):
    if word.startswith('('):
        pos = word.find(')')
        word = word[pos+1:]
    if len(word) > 1 and word[-1] == ')':
        pos = word.rfind('(')
        if pos != -1:
            return word[:pos]
    return word

def replace_bracket(data):
    return data.replace("（","(").replace("）",")").replace("((","(").replace("))",")")

def filter_lines(line):
    if not line.startswith('#'):
        return line

if __name__ == "__main__":
    print bracket_rec("(大 润) 发 六 盘 水 店 ( 西 门 )")
