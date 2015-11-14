AwvScan
By: Mr.x
Email:coolxia@foxmail.com
==============

AwvScan是基于Awvs+python+nginx+php+mysql框架组成的在线分布式扫描工具（框架图可查看scan.jpg）

==============

修改dns部分，之前是单线程动态读取host-ip地址记录，导致客户端dns查询超时。

现单独起一个线程每3秒查询动态读取host-ip地址记录，避免客户端dns查询超时问题。

2015.11.14

==============

现在是v1.0版本

扫描核心为awvs console，用nginx反向代理+DNSsever解决了，登录认证问题（大部分情况）

现在工作忙，忙着把安全做成服务产品，服务公司各种研发部门，估计这玩意又得放一段时间了...

2015.8.11
