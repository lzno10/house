#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
reload(sys)
sys.setdefaultencoding("utf-8")

lianjia_conf = {
        #各种字段xpath配置
        "house_list":"/descendant::ul[@class='listContent']//li",
        "fields":"image_url title deal_date total_price unit_price deal_info",
        "image_url":"a",
        "title":"div//div[@class='title']/a",
        "deal_date":"div//div[@class='dealDate']",
        "total_price":"div//div[@class='totalPrice']/span",
        "unit_price":"div//div[@class='unitPrice']/span",
        "deal_info":"div//div[@class='dealCycleeInfo']/span/span",
        "pages":"//div[@class='page-box house-lst-page-box']",
        "url_prefix":"https://bj.lianjia.com/chengjiao/",
        #配置目前需要抓取的条件
        "condition":"condition2",
        #各种条件的配置
        "option":{
            "default":"l2rs",#二居室,
            "condition1":"l2a3a2rs",#50-70平，70-90平，二居室,
            "condition2":"l2l1rs",#一、二居室,
            },
        "sleep_time":60,
        #需要抓取的小区列表
        "xiaoqu_dict":{
            "龙博苑三区":"condition2",
            "龙博苑一区":"condition2",
            "龙博苑二区":"condition2",
            "紫金新干线":"default",
            "紫金新干线二期":"default",
            "名佳花园一区":"default",
            "名佳花园三区":"default",
            "名佳花园四区":"default",
            "望都新地":"default",
            "望都新地二期":"default",
            "名流花园":"default",
            "望都家园":"default",
            #"西辛南区":"default",
            #"义宾北区":"default",
            #"仓上小区":"default",
            },
        }
