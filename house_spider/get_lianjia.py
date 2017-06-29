#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
reload(sys)
sys.setdefaultencoding("utf-8")
import getopt
import urllib
import urllib2
import urlparse
import re
import threading
import os, time
import time
try:
    import ujson as json
except Exception,e:
    import json
import base64
from lxml import etree as etree
from house_conf import *
from common_func import *

def gen_url_list(xiaoqu, option="default", max_pages=10):
    """获取xiaoqu的全部成交页面url
    Args:
        xiaoqu:指定小区名
        type:str

        option:小区筛选条件选项，根据option取配置文件中对应的条件
        type:str
    Returns:
        url_list:xiaoqu的全部成交页面url
        type:list
    """
    try:
        url_list = []
        url_prefix = conf["url_prefix"]
        xiaoqu_option = conf["option"][option]
        xiaoqu_url = "%spg1%s%s" % (url_prefix, xiaoqu_option, urllib.quote(xiaoqu))
        max_pages_num = get_max_pages(xiaoqu_url, max_pages)
        if max_pages_num == 0:
            xiaoqu_option = conf["option"]["default"]
            default_url = "%spg1%s%s" % (url_prefix, xiaoqu_option, urllib.quote(xiaoqu))
            max_pages_num = get_max_pages(default_url, max_pages)
        for page_num in range(max_pages_num):
            url_list.append("%spg%s%s%s" % (url_prefix, page_num+1, xiaoqu_option, urllib.quote(xiaoqu)))
        return url_list
    except Exception,e:
        print >> sys.stderr, e
        print >> sys.stderr, "gen_url error"
        return []

def get_max_pages(url, max_pages):
    """根据url获取小区成交页面总数
    Args:
        url:小区其中一个成交页面连接
        type:str

        max_pages:设置的默认最大页数
        type:int
    Returns:
        max_pages:小区成交页面总数
        type:int
    """
    html = get_html(url)
    house_pages = int(get_lianjia_house_pages(html.xpath(conf.get("pages",""))))
    max_pages = house_pages if house_pages < max_pages else max_pages
    return max_pages

def get_html(url):
    """抓取url对应的页面
    """
    # TODO use file instead of spider
    # return etree.HTML(open('lianjia.test').read())
    # sys.exit()
    req_header = {'User-Agent':'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36'}
    req_timeout = 120
    #设置代理
    #101.199.103.167, 10.117.81.81
    #proxyConfig = 'http://%s' % ('211.151.122.71:8360')
    #opener = urllib2.build_opener(urllib2.ProxyHandler({'http':proxyConfig}))
    #urllib2.install_opener(opener)
    req = urllib2.Request(url,None,req_header)
    try:
        html = urllib2.urlopen(req,None,req_timeout).read()
        htmlSource = etree.HTML(html)
        return htmlSource
        #val = ''.join(htmlSource.xpath('//meta/@content'))
        #m = re.search("charset=(.*)", val)
        #if m and m.group(1) == 'gb2312':
            #html = html.decode('GBK')
        #else:
            #html = html.decode('utf-8')
    except urllib2.URLError, e:
        print >> sys.stderr, e.code
        print >> sys.stderr, 'get_html fail: %s\n' % (url)
    return None

def parse_result(html):
    """根据配置文件，分析html页面元素
    Args:
        html:输入页面
        type:etree
    Returns:
        ret_data_list:小区成交所有房源各种信息
        type:list
    """
    ret_data_list = []
    house_list_xpath = conf.get("house_list", "")
    house_list = html.xpath(house_list_xpath)
    for item in house_list:
        #单个房源数据
        data_dict = {}
        #val = item.xpath("//div[@class='page-box house-lst-page-box']")
        #if val:
            #print val[0].attrib["page-data"]
        for field in conf.get("fields","").split():
            field_xpath = conf.get(field, "")
            try:
                val = item.xpath(field_xpath)
                ret = "暂无"
                if val:
                    if field in "image_url pages".split():
                        ret = val[0].attrib
                    else:
                        ret = val[0].text
                data_dict[field] = ret
            except Exception,e:
                print >> sys.stderr, "%s error" % field
        data_dict = fmt_lianjia_data(data_dict)
        if data_dict:
            ret_data_list.append(data_dict)
    return ret_data_list

def fmt_lianjia_data(data):
    """对data中某些字段做处理
    """
    func_list = [
            fmt_image,
            fmt_price,
            fmt_date,
            ]
    for func in func_list:
        if data:
            data = func(data)
    return data

def fmt_image(data):
    """获取图片标签中的连接
    """
    if "image_url" in data:
        tmp_val = data["image_url"]["href"]
        data["image_url"] = tmp_val
    return data

def fmt_price(data):
    """ 1.过滤原始网页中无total_price的数据
        2.生成挂牌价和成交价的差价
    """
    if data["total_price"] == "暂无":
        return {}
    else:
        data["total_price"] = float(data["total_price"])
        data["unit_price"] = float(data["unit_price"])
    pattern = "挂牌(\d+)万"
    m = re.match(pattern, enc(data["deal_info"]))
    if m:
        orig_price = m.group(1)
        diff_price = float(orig_price) - float(data["total_price"])
        data["orig_price"] = orig_price
        data["diff_price"] = diff_price
    return data

def fmt_date(data):
    """格式化数据的日期
    Args:
        data:输入的一条房产原始数据
        type:dict
    Returns:
        ret_data:格式化后的数据
        type:dict
    """
    if "deal_date" in data:
        if data["deal_date"].count(".") == 1:
            data["deal_date"] += ".01"
        data["deal_time_stamp"] = int(time.mktime(time.strptime(data["deal_date"],'%Y.%m.%d')))*1000
    return data

def get_lianjia_house_pages(pages):
    """获取lianjia页数字段
    """
    if pages:
        pages = pages[0].attrib["page-data"]
        pages = json.loads(pages)["totalPage"]
    else:
        pages = 0
    return pages

def output_result(result_dict):
    """输出结果
    Args:
        result_dict:抓取的结果，小区为key，各种属性为value
        type:dict
    """
    output_file_name = "data/house.data"
    output_file = open(output_file_name, "w")
    for xiaoqu,detail in result_dict.iteritems():
        orig_detail = json.dumps(detail, ensure_ascii=False)
        fmt_detail = fmt_output_data(detail)
        ret_str = enc("\t".join([xiaoqu, fmt_detail, orig_detail]))
        output_file.write(ret_str+'\n')
    output_file.close()
    print >> sys.stderr, "write to %s" % output_file_name

def fmt_output_data(data):
    """将原始数据转化成图表需要的格式
    Args:
        data:输入原始数据
        type:dict
    Returns:
        ret_dict:格式化后的数据
        type:dict
    """
    ret_dict = {}
    tmp_ret_dict = {}
    field_name_list = "deal_date deal_time_stamp total_price unit_price diff_price".split()
    for field in field_name_list:
        tmp_ret_dict[field] = gen_field_list(data, field)
    for data_type in "total_price unit_price diff_price".split():
        data_type_ret = map(list, zip(tmp_ret_dict["deal_time_stamp"], tmp_ret_dict[data_type]))
        ret_dict[data_type] = sorted(data_type_ret, key=lambda x: x[0])
    return json.dumps(ret_dict, ensure_ascii=False)

def gen_field_list(data, field):
    ret_list = []
    for item in data:
        ret_list.append(item.get(field, ""))
    return ret_list

conf = lianjia_conf
if __name__ == "__main__":
    xiaoqu_list = conf.get("xiaoqu_list",[])
    condition = conf.get("condition", "default")
    #对配置文件中的每个小区进行抓取
    result_dict = {}
    for xiaoqu in xiaoqu_list:
        print >> sys.stderr, "processing --> %s" % xiaoqu
        xiaoqu_url_list = gen_url_list(xiaoqu, condition)
        data_list = []
        for xiaoqu_url in xiaoqu_url_list:
            print >> sys.stderr, "get: %s" % xiaoqu_url
            html = get_html(xiaoqu_url)
            data_list += parse_result(html)
            time.sleep(int(conf.get("sleep_time",0)))
            print >> sys.stderr, "sleep %ds" % conf.get("sleep_time",0)
        result_dict[xiaoqu] = data_list
    output_result(result_dict)
