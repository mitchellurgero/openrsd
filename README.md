# OpenRSD - Stable - State: Usable

### What is OpenRSD
OpenRSD or ORSD is a set of PHP scripts, JS, HTML, and BootStrap CSS to create a beautiful, easy to use, responsive Dashboard to manage Raspbian based distros for the RPi2-3.

After months of testing, OpenRSD seems to be stable. Please put issues on GitHub if you find any bugs.


<h3>OpenRSD How to install &amp; Use</h3>
<p>Installing OpenRSD is pretty simple to do. Just follow the below instructions:</p>
<ol>
<li>This script is only tested on Raspbian, please make sure you are running a distro based on that, or running Raspbian.</li>
<li>Once Raspbian (Or Raspbian based OS) is installed, run(Note: The following is just the BARE MINIMUM to get OpenRSD to run properly, PiVPN and Samba must be installed separately!):
<p><code>sudo apt-get update &amp;&amp; sudo apt-get install git apache2 php5 libapache2-mod-php5 php5-mcrypt expect geoip-bin shellinabox</code></p>
In case you have Raspbian Stretch you could set up <b>lighttpd and php7.0-fpm</b> as the BARE MINIMUM:
<p><code>
sudo apt-get update && sudo apt-get upgrade -y && 
sudo apt-get -y install git lighttpd php7.0 php7.0-fpm php7.0-curl php7.0-gd php7.0-intl php7.0-mbstring php7.0-mcrypt php7.0-readline php7.0-xml php7.0-zip php-pear expect geoip-bin shellinabox
</code></p>
</li>
</ol>
<ol>
<li>
<p><b>PLEASE KEEP IN MIND THAT ONCE APACHE IS RUNNING AS A USER WITH SUDO RIGHTS, IT SHOULD NOT BE ACCESSIBLE VIA THE INTERNET TO KEEP SECURITY AS BEST AS POSSIBLE. AND ALTHOUGH NOT AS BIG A DEAL AS BEING INTERNET ACCESSIBLE, PLEASE ALSO NOT THAT THIS CAN STILL CAUSE ISSUES ON LAN. (Say as an example an attacker got on your network, they could try and access the Pi.)</b></p>
<p>Once that is done, run &quot;sudo nano /etc/apache2/apache2.conf&quot; Edit the User and Group to the user/group pi, it should look like this.</p>
<pre><code>
...Some Config stuff...
User pi
Group pi
...Some Config stuff...
</code></pre>
<p>For Stretch with <b>lighttpd and php7.0-fpm</b> you should run the following to raise the max execution timeout to 300 seconds, allow passwordless sudo for www-data user, and switch php on for lighttpd:</p>
<pre><code>sudo sed -i -e "s/^max_execution_time =.*/max_execution_time = 300/g" /etc/php/7.0/fpm/php.ini
echo "www-data ALL=(ALL) NOPASSWD: ALL" | sudo tee --append /etc/sudoers.d/010_pi-nopasswd
sudo lighttpd-enable-mod fastcgi-php
sudo service php7.0-fpm force-reload
sudo service lighttpd force-reload
</code></pre>
</li>
<li>Then run: <code>sudo sed -i -e "s/SHELLINABOX_ARGS=.*/SHELLINABOX_ARGS=\"--no-beep -t\"/g" /etc/default/shellinabox</code></li>
<li>Then run: <code>sudo service apache2 restart</code> or <code>sudo service lighttpd force-reload</code></li>
<li>Then run: <code>cd /var/www/html</code></li>
<li>Then run: <code>rm -f index.html</code> *Optional!</li>
<li>Then run: <code>git clone https://github.com/mitchellurgero/openrsd</code></li>
<li>Once the command finishes running, you can go to the following URL to access the admin panel for your pi: &quot;<a href="http://YourPIsIPAddress/openrsd">http://YourPIsIPAddress/openrsd</a>&quot;</li>
<li>Login with the user pi, and whatever password you have set for that user.</li>
</ol>
<h3>Updating OpenRSD</h3>
<p>As long as you have not modified any of the files, updating is pretty simple: Just run <code>git pull</code> in the /var/www/html/openrsd directory.
Or through the web interface: Advanced Configuration -&gt; Updates</p>

## Screenshots

![Screenshot - Dashboard](img/screen1.PNG)
![Screenshot - Services](img/screen2.PNG)
![Screenshot - User Accounts](img/screen3.PNG)
