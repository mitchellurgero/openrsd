#!/bin/bash

#########
# This script is to be ran by cron once every day (Or whatever you choose, I recommend at least once a day to get the latest security updates.)
# This will run the following functions to help with OpenDSD:
#		apt-get update
#		Check for OpenDSD updates
########


# Run apt-get update to update list of packages that need to be installed.
apt-get update

# Check for OpenDSD updates

# curl -s https://github.com/mitchellurgero/opendsd_install/install.sh | bash

