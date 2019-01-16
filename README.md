# ServerStatus
Server Status website script, displays uptime (days), free RAM, free HDD.

If you don't see any change in this code for a long time, I'm probably dead... Do not try discover who did this, probably you'll die too...

## About branch backup and master
Branch backup is a clone of http://git.oschina.net/supercell/service_count

Branch master is a modified version
## Screenshots
![table](https://ooo.0o0.ooo/2016/12/16/58539a8d0622d.png "Information panel")

## About install.sh
If you logged into informaiton panel, you can find the usage of install.sh

## About configuration

Please edit `config.php`

> define('DB_USER', "root");//DATABASE_USER
>
> define('DB_PASS', "");//DATABASE_PASS
>
> define('DB_HOST',"127.0.0.1");//DATABASE_SEVER
>
> define('DB_NAME', "");//DATABASE_NAME
>
> define('DB_PREFIX','ss');//DO_NOT_CHANGE_IN_CURRENT_VERSION
>
> define('POST_TOKEN', "666");//POST_AUTH_KEY
>
> define('LOGIN_PASS', "666");//INFOMATION_PANEL_LOGIN_PASS
>
> define('IP_TOKEN', '');//LEAVE_BLANK_TO_ALLOW_ALL_PERSONT_TO_USE_IP_WHOIS_API
>
> define('DISPLAY_IP',TRUE);//HIDE_IP_TO_AVOID_DDOS_ATTACK

## How to init database?
import `database.sql`

## About IP Whois
The normal ip whois api print chinese result. If you want to show in your mother touge, please edit `ip.php` and add custom api;

## Credits
Thanks the [BotoX/ServerStatus](https://github.com/BotoX/ServerStatus "BotoX/ServerStatus") project for some of the code which has been used in this project.
