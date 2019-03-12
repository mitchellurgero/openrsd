function CreateClientsTable()
{
    var shellReturn = document.getElementById("resultClients");
    console.log(shellReturn);
    shellText = shellReturn.innerHTML.replace("<div id=\"resultClients\">", "").replace("</div>", "").replace("<!--", "").replace("-->");
    shellText = shellText.substring(shellText.indexOf("Username	Client ID	Peer ID"));
    console.log(shellText);

    var shellLines = shellText.split('\n');
    for(var i = 0;i < shellLines.length;i++)
    {
        console.log(shellLines[i]);
    }
}