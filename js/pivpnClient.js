function CreateClientsTable()
{
    var shellReturn = document.getElementById("resultClients");
    console.log(shellReturn);
    shellText = shellReturn.innerHTML.replace("<div id=\"resultClients\">", "").replace("</div>", "").replace("<!--", "").replace("-->");
    shellText = shellText.substring(shellText.indexOf("Username	Client ID	Peer ID"));
    console.log(shellText);

    var shellLines = shellText.split('\n');
    console.log(shellLines);
    for(var i = 0;i < shellLines.length;i++)
    {
        console.log(shellLines[i]);
        if(shellLines[i].includes("CLIENT_LIST"))
        {
            AddTable(shellLines[1], shellLines[2], shellLines[3], shellLines[6]);
            console.log(shellLines[1]);
            console.log(shellLines[2]);
            console.log(shellLines[3]);
            console.log(shellLines[6]);
        }
    }
}

function AddTable(UserName, IP_wan, ip_assign, since)
{
    var Headstd = "<tr>{line}</tr}";
    var Linestd = "<td>{user}</td><td>{IPwan}</td><td>{IPlan}</td><td>{since}</td>";
    Linestd = Linestd.replace("{user}", UserName).replace("{IPwan}", IP_wan).replace("{IPlan}", ip_assign).replace("{since}", since);
    final = Headstd.replace("{line}", Linestd);
    console.log(final);
    document.getElementById("ConnClients").InnerHTML += final;
}