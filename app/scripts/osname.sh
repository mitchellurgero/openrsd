#! /bin/bash
cat /etc/os-release | grep 'NAME\|VERSION' | grep -v 'VERSION_ID' | grep -v 'PRETTY_NAME' > /tmp/osrelease
echo -n -e "<strong>OS Name:</strong>" $tecreset  && cat /tmp/osrelease | grep -v "VERSION" | cut -f2 -d\"