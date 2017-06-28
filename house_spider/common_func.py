#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys
import time
import re
path = sys.path[0]
import_path = [path+"/conf","/home/hdp-map/liuzhuo/project/main_name"]
for path in import_path:
    sys.path.append(path)
from rec_main_name import rec_main_name

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

def bracket_rec(word):
    """识别主体内容和括号部分内容
    Args:
        word:需要识别的字符串，type是str
    Returns:
        main_name:识别出来的主体部分
        content:识别出来的括号部分
    """
    content = ""
    main_name, field = rec_main_name(dec(word), gate_only_flag=False)
    main = main_name
    head_pattern = "^\(([^()]+)\)(.+)$"
    tail_pattern = "^(.+)\(([^()]+)\)$"

    #head_m = re.match(head_pattern, main)
    #if head_m:
        #content = head_m.group(1)
        #main = head_m.group(2)

    tail_m = re.match(tail_pattern, main)
    if tail_m:
        main = tail_m.group(1)
        content = tail_m.group(2)
    content = content+field
    return main, content

def filter_lines(line):
    if not line.startswith('#'):
        return line

if __name__ == "__main__":
    print bracket_rec("(大 润) 发 六 盘 水 店 ( 西 门 )")
