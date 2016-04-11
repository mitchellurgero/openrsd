#!/bin/bash
service=$1
if (( $(ps -ef | grep -v grep | grep $service | wc -l) > 0 ))
then
echo "<tr><td><strong>APACHE</strong></td><td>running</td><td><a href="#">Stop Service</a></td></tr>"
else
echo "<tr><td><strong>APACHE</strong></td><td>stopped<br /></td><td><a href="#">Start Service</a></td></tr>"
fi
