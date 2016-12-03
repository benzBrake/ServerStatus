#service_count
![table](http://git.oschina.net/uploads/images/2016/1202/134105_2a403897_700748.png "界面")

cron.sh文件 crontab定时执行
1分钟发送一次；

crontab设置
>chmod +x cron.sh
>crontab -e 
添加一条记录
>*/1 * * * * /你的路径/cron.sh

cron.sh文件
修改
>POST_URL=127.0.0.1/service.php //你的统计文件脚本
>TOKEN=666//验证的KEY

service.php文件
修改
>define('USER', "root");//数据库用户名
>define('PASS', "");//数据库密码
>define('DB', "vps");//数据库名
>define('KEY', "666");//验证KEY
>define('PA', "666");//如果设置了密码，只有输入密码才能访问
 
VPS.sql导入数据库！

bash由来自悠久的翼