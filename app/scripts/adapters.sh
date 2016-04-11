#!/bin/bash
sudo ifconfig -a | sed 's/[ \t].*//;/^\(lo\|\)$/d'