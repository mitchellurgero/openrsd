#!/bin/bash
#sudo ifconfig -a | sed 's/[ \t].*//;/^\(lo\|\)$/d'
sudo ifconfig -a | awk '$1 == "inet" {print $2}'