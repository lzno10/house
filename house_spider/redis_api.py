#!/usr/bin/env python
# -*- coding: utf-8 -*-

import redis

class RedisApi(object):
    def __init__(self, **redis_kwargs):
        #r-2ze61b26621bf094.redis.rds.aliyuncs.com -p 6379 -a LZgll130831aly info
        self._redis= redis.Redis(host='r-2ze61b26621bf094.redis.rds.aliyuncs.com', port=6379, password="LZgll130831aly")

    def get(self, key):
        data = self._redis.get(key)
        return data

    def set(self, key, val):
        ret = self._redis.set(key, val)
        return ret

if __name__ == "__main__":
    type_redis = RedisApi()
    print type_redis.get("test")
