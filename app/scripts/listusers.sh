#!/bin/bash
awk -F/ '$NF == "bash"' /etc/passwd