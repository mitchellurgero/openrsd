#! /bin/bash
cat /etc/os-release | grep 'NAME\|VERSION' | grep -v 'VERSION_ID' | grep -v 'PRETTY_NAME' > /tmp/osrelease
echo -n -e "<strong>OS Version :</strong>" $tecreset && cat /tmp/osrelease | grep -v "NAME" | cut -f2 -d\"s