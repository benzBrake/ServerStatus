#!/bin/bash
# Set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
# Parameters required
if [ $# -lt 2 ]; then 
	echo -e "|   Usage: bash $0 'post_url' 'token'\n|"
	exit 1
fi
POST_URL=$1
TOKEN=$2
# Check if crontab is installed
if [ ! -n "$(command -v crontab)" ]; then 
	# Attempt to install crontab
	if [ -n "$(command -v apt-get)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'cron' via 'apt-get'"
		apt-get -y update
		apt-get -y install cron
	elif [ -n "$(command -v yum)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'cronie' via 'yum'"
		yum -y install cronie
		
		if [ ! -n "$(command -v crontab)" ]; then 
			echo -e "|\n|   Notice: Installing required package 'vixie-cron' via 'yum'"
			yum -y install vixie-cron
		fi
	elif [ -n "$(command -v pacman)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'cronie' via 'pacman'"
		pacman -S --noconfirm cronie
	fi
	if [ ! -n "$(command -v crontab)" ]; then 
		# Show error
		echo -e "|\n|   Error: Crontab is required and could not be installed\n|"
		exit 1
	fi
fi
# Check if cron is running
if [ -z "$(ps -Al | grep cron | grep -v grep)" ]; then 
# Confirm cron service
	if [ -n "$(command -v apt-get)" ]; then 
		echo -e "|\n|   Notice: Starting 'cron' via 'service'"
		service cron start
	elif [ -n "$(command -v yum)" ]; then 
		echo -e "|\n|   Notice: Starting 'crond' via 'service'"
		chkconfig crond on
		service crond start
	elif [ -n "$(command -v pacman)" ]; then 
		echo -e "|\n|   Notice: Starting 'cronie' via 'systemctl'"
		systemctl start cronie
		systemctl enable cronie
	fi
fi
# Check if cron was started
if [ -z "$(ps -Al | grep cron | grep -v grep)" ]; then 
	# Show error
	echo -e "|\n|   Error: Cron is available but could not be started\n|"
	exit 1
fi
# Check if curl is installed
if [ ! -n "$(command -v curl)" ]; then
	if [ -n "$(command -v apt-get)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'curl' via 'apt-get'"
		apt-get -y update
		apt-get -y install curl
	elif [ -n "$(command -v yum)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'curl' via 'yum'"
		yum -y install curl
	elif [ -n "$(command -v pacman)" ]; then 
		echo -e "|\n|   Notice: Installing required package 'curl' via 'pacman'"
		pacman -S --noconfirm curl
	fi
	if [ ! -n "$(command -v curl)" ]; then 
		# Show error
		echo -e "|\n|   Error: Crontab is required and could not be installed\n|"
		exit 1
	fi
fi
# Check if cron is running
if [ -z "$(ps -Al | grep cron | grep -v grep)" ]; then 
# Confirm cron service
	if [ -n "$(command -v apt-get)" ]; then 
		echo -e "|\n|   Notice: Starting 'cron' via 'service'"
		service cron start
	elif [ -n "$(command -v yum)" ]; then 
		echo -e "|\n|   Notice: Starting 'crond' via 'service'"
		chkconfig crond on
		service crond start
	elif [ -n "$(command -v pacman)" ]; then 
		echo -e "|\n|   Notice: Starting 'cronie' via 'systemctl'"
		systemctl start cronie
		systemctl enable cronie
	fi
fi
# Attempt to delete previous cron.sh
if [ -f /etc/serverstatus ]; then 
	# Remove agent dir
	rm -Rf /etc/serverstatus
	# Remove cron entry and user
	(crontab -u root -l | grep -v "/etc/serverstatus/cron.sh") | crontab -u root -
fi
mkdir -p /etc/serverstatus
cat > /etc/serverstatus/config <<EOF
POST_URL=${POST_URL}
TOKEN=${TOKEN}
EOF
cat > /etc/serverstatus/cron.sh <<-'EOF'
. /etc/serverstatus/config
#!/bin/bash
LOAD=`cat /proc/loadavg|awk '{print $1,$2,$3}'| tr ' ' ','` #¸ºÔØ
#ram=`cat /proc/meminfo | grep MemTotal | awk '{print $2,$3}'`
RAM=`free -h | grep Mem | awk '{print $2}'`
USED=`free -h | grep Mem | awk '{print $3}'`
UPTIME=`uptime | awk '{print $3,$4,$5}' | sed 's/,$//'| tr ' ' ','`

curl -s -d "key="$TOKEN"&load="$LOAD"&ram="$RAM"&used="$USED"&uptime="$UPTIME"" $POST_URL > /dev/null
EOF
if [ -f /etc/serverstatus/cron.sh ]; then
	(crontab -u root -l | grep -v "/etc/serverstatus/cron.sh") | crontab -u root -
	crontab -u root -l 2>/dev/null | { cat; echo "*/1 * * * * bash /etc/serverstatus/cron.sh"; } | crontab -u root -
fi
echo "Install Success!"