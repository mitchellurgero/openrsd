function CreateClientsTable()
{
    var shellReturn = document.getElementById("resultClients");
    shellText = shellReturn.innerHTML.replace("<div id=\"resultClients\">", "").replace("</div>", "").replace("<!--", "").replace("-->");
    shellText = shellText.substring(shellText.indexOf("Username	Client ID	Peer ID"));

    var shellLines = shellText.split('\n');
    for(var i = 0;i < shellLines.length;i++)
    {
        shellTabs = shellLines[i].split('\t')
        for(var i = 0;i < shellTabs.length;i++)
        {   
            if(shellTabs[i].includes("CLIENT_LIST"))
            {
                AddTable(shellTabs[1], shellTabs[2], shellTabs[3], shellTabs[7]);
            }
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
    document.getElementById("tableBody").InnerHTML += final;
}