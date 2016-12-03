
POST_URL=127.0.0.1/service.php
TOKEN=666

LOAD=`cat /proc/loadavg|awk '{print $1,$2,$3}'| tr ' ' ','` #负载
#ram=`cat /proc/meminfo | grep MemTotal | awk '{print $2,$3}'`
RAM=`free -h | grep Mem | awk '{print $2}'`
USED=`free -h | grep Mem | awk '{print $3}'`
UPTIME=`uptime | awk '{print $3,$4,$5}' | sed 's/,$//'| tr ' ' ','`

curl -s -d "key="$TOKEN"&load="$LOAD"&ram="$RAM"&used="$USED"&uptime="$UPTIME"" $POST_URL > /dev/null

