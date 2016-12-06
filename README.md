# ServerStatus
## About branch backup and master
Branch backup is a clone of http://git.oschina.net/supercell/service_count

Branch master is a modified version
## Screenshots
![table](https://ooo.0o0.ooo/2016/12/04/584412d73c5e0.png "Information panel")

## About install.sh
If you logged into informaiton panel, you can find the usage of install.sh

## About configuration

Please edit `config.php`

> define('DB_USER', "root");//DATABASE_USER
>
> define('DB_PASS', "");//DATABASE_PASS
>
> define('DB_NAME', "vps");//DATABASE_NAME
>
> define('DB_HOST',"127.0.0.1");//DATABASE_SEVER
>
> define('DB_PREFIX','ss');//DO_NOT_CHANGE_IN_CURRENT_VERSION
>
> define('POST_TOKEN', "666");//POST_AUTH_KEY
>
> define('LOGIN_PASS', "666");//INFOMATION_PANEL_LOGIN_PASS

## How to init database?
import `vps.sql`