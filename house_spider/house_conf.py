#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
reload(sys)
sys.setdefaultencoding("utf-8")

lianjia_conf = {
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
        "option":{
            "default":"l2a3a2rs",#50-70平，70-90平，二居室
            },
        "sleep_time":10,
        # "xiaoqu_list_str":"紫金新干线 紫金新干线二期 名佳花园一区 名佳花园三区 名佳花园四区 望都新地 望都新地二期 望都家园 名流花园 西辛南区 义宾北区 仓上小区",
        "xiaoqu_list":[
            "紫金新干线",
            "紫金新干线二期",
            "名佳花园一区",
            # "名佳花园三区",
            # "名佳花园四区",
            # "望都新地",
            # "望都新地二期",
            # "望都家园",
            # "名流花园",
            # "西辛南区",
            # "义宾北区",
            # "仓上小区",
            ]
        }
