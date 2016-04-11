#!/bin/bash

if [[ $EUID -ne 0 ]]; then
	echo "Please run the installer as root!!!"
	exit 1
fi

echo "Installer for OpenRDS for Raspberry Pi 2 & 3"
echo ""
echo "This PHP script can only be installed on ARMv7 (RPi2&3) Devices!"
echo "This PHP script will not work on the RPi1 (any model)"
echo ""
echo ""
echo "Checking apt-get for updates..."
## Check for updates first (Don't actually update, just want latest packages for lxc)
apt_update

### Popup warning
echo "Installing script dependencies..."
apt_install dialog apache2 php5 libapache2-mod-php5 php5-mcrypt php5-curl

message_box "Warning Pt. 2" "This script modifies some special config files for apache2 and installs some pam modules. If you are sure you want to continue, press enter. Otherwise, press ctrl + c to cancel now."


### Modifications to apache ###

# We will be writing a new config OVER the default installed one:


### Functions ###
## Functions courtesy of @joshdata on GitHub. 

function hide_output {
	# This function hides the output of a command unless the command fails
	# and returns a non-zero exit code.

	# Get a temporary file.
	OUTPUT=$(tempfile)

	# Execute command, redirecting stderr/stdout to the temporary file.
	$@ &> $OUTPUT

	# If the command failed, show the output that was captured in the temporary file.
	E=$?
	if [ $E != 0 ]; then
		# Something failed.
		echo
		echo FAILED: $@
		echo -----------------------------------------
		cat $OUTPUT
		echo -----------------------------------------
		exit $E
	fi

	# Remove temporary file.
	rm -f $OUTPUT
}
function apt_update {
	hide_output apt-get update
}

function apt_get_quiet {
	# Run apt-get in a totally non-interactive mode.
	#
	# Somehow all of these options are needed to get it to not ask the user
	# questions about a) whether to proceed (-y), b) package options (noninteractive),
	# and c) what to do about files changed locally (we don't cause that to happen but
	# some VM providers muck with their images; -o).
	#
	# Although we could pass -qq to apt-get to make output quieter, many packages write to stdout
	# and stderr things that aren't really important. Use our hide_output function to capture
	# all of that and only show it if there is a problem (i.e. if apt_get returns a failure exit status).
	DEBIAN_FRONTEND=noninteractive hide_output apt-get -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confnew" "$@"
}

function apt_install {
	# Install a bunch of packages. We used to report which packages were already
	# installed and which needed installing, before just running an 'apt-get
	# install' for all of the packages.  Calling `dpkg` on each package is slow,
	# and doesn't affect what we actually do, except in the messages, so let's
	# not do that anymore.
	PACKAGES=$@
	apt_get_quiet install $PACKAGES
}
function message_box {
	dialog --title "$1" --msgbox "$2" 0 0
}