#!/bin/bash
sudo LC_ALL=C apt-get --just-print upgrade 2>&1 | awk '/^Inst /{ print $2" INSTALLED: "$3" AVAILABLE: "$4; }' | tr -d '[]('
