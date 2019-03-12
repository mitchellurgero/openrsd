function CreateClientsTable()
{
    var shellReturn = Document.getElementById("resultClients");
    console.log(shellReturn);
    shellText = shellReturn.innerHTML.replace("<div id=\"resultClients\">", "").replace("</div>", "").replace("<!--", "").replace("-->");
    shellText = shellText.substring(str.indexOf("Username	Client ID	Peer ID"));
    console.log(shellText);

    var shellLines = $('textarea').val().split('\n');
    for(var i = 0;i < shellLines.length;i++)
    {
        console.log(shellLines[i]);
    }
}