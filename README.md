# Typecho-60snew
## 所见即所得 不废话了 直接丢代码把 不想说了

### 使用教程

1. 复制下方代码保存到 typecho 的任意一个目录 推荐创建一个 60s 文件夹然后新建一个 index.php 的文件 把代码丢进去
2. 代码里面需要修改的地方我已经给你们标注出来了
3. 添加宝塔定时任务 任务类型:访问url 任务名称:随便设置 执行周期:每天 7 小时 30 分钟 脚本内容:就是你的域名/60s 保存完事
4. 要是 https://协议的链接用下方 shell 代码
```shell-session
#!/bin/bash

# 要访问的 HTTPS 链接
url="你的文件链接"

# 使用 curl 访问链接
curl -k $url
```
# Typecho-60snew
##WYSIWYG, stop talking nonsense, just throw the code and don't want to talk about it

###Usage Tutorial

1. Copy the code below and save it to any directory in typeecho. It is recommended to create a 60s folder and then create a new index.php file and throw the code in it.
2. I have marked out the changes in the code for you
3. Add pagoda scheduled task task type: access url task name: casually set execution cycle: 7 hours and 30 minutes per day Script content: It's your domain name/60s Save the matter