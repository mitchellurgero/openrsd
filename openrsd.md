<div class="container"><h2>OpenRSD Guide and How-to</h2>
<p><a href="https://github.com/mitchellurgero/openrsd">GitHub Page for OpenRSD</a></p>
<h3>What is OpenRSD</h3>
<p>OpenRSD or ORSD is a set of PHP scripts, JS, HTML, and BootStrap CSS to create a beautiful, easy to use, responsive Dashboard to manage Raspbian based distros for the RPi2-3.</p>
<p>After months of testing, OpenRSD seems to be stable. Please put issues on GitHub if you find any bugs. </p>
<h3>OpenRSD How to install &amp; Use</h3>
<p>Installing OpenRSD is pretty simple to do. Just follow the below instructions:</p>
<ol>
<li>This script is only tested on Raspbian, please make sure you are running a distro based on that, or running Raspbian.</li>
<li>Once Raspbian (Or Raspbian based OS) is installed, run(Note: The following is just the BARE MINIMUM to get OpenRSD to run properly, PiVPN and Samba must be installed separately!):</li>
</ol>
<p><code>sudo apt-get update &amp;&amp; sudo apt-get install git apache2 php5 libapache2-mod-php5 php5-mcrypt expect geoip-bin</code></p>
<ol>
<li>
<p>Once that is done, run &quot;sudo nano /etc/apache2/apache2.conf&quot; Edit the User and Group to the user/group pi, it should look like this.</p>
<pre><code>
...Some Config stuff...
User pi
Group pi
...Some Config stuff...
</code></pre>
</li>
<li>Then run: <code>sudo service apache2 restart</code></li>
<li>Then run: <code>cd /var/www/html</code></li>
<li>Then run: <code>rm -f index.html</code> *Optional!</li>
<li>Then run: <code>git clone https://github.com/mitchellurgero/openrsd</code></li>
<li>Once the command finishes running, you can go to the following URL to access the admin panel for your pi: &quot;<a href="http://YourPIsIPAddress/openrsd">http://YourPIsIPAddress/openrsd</a>&quot;</li>
<li>Login with the user pi, and whatever password you have set for that user.</li>
</ol>
<h3>Updating OpenRSD</h3>
<p>As long as you have not modified any of the files, updating is pretty simple: Just run <code>git pull</code> in the /var/www/html/openrsd directory.
Or through the web interface: Advanced Configuration -&gt; Updates</p>
<h3>Screenshots</h3>
<p><img src="/application/pages/howto/linux/OpenRSD Cap1.PNG" height="50%"><br /><br />
<img src="/application/pages/howto/linux/OpenRSD Cap2.PNG" height="50%"><br /><br />
<img src="/application/pages/howto/linux/OpenRSD Cap3.PNG" height="50%"><br /><br /></p>
<script>
var links = document.links;

for (var i = 0, linksLength = links.length; i < linksLength; i++) {
   if (links[i].hostname != window.location.hostname) {
       links[i].target = '_blank';
   } 
}
</script></div>