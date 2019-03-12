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
        if(shellLines[i].includes("CLIENT_LIST"))
        {
            AddTable(shellLine[1], shellLine[2], shellLine[3], shellLine[6]);
            console.log(shellLine[1]);
            console.log(shellLine[2]);
            console.log(shellLine[3]);
            console.log(shellLine[6]);
        }
    }
}

function AddTable(UserName, IP_wan, ip_assign, since)
{
    var Headstd = "<tr>{line}</tr}"
    var Linestd = "<td>{user}</td><td>{IPwan}</td><td>{IPlan}</td><td>{since}</td>"
    Linestd = Linestd.replace("{user}", UserName).replace("{IPwan}", IP_wan).replace("{IPlan}", ip_assign).replace("{since}", since)
    final = Headstd.replace("{line}", Linestd)
    document.getElementById("ConnClients").InnerHTML += final;
}