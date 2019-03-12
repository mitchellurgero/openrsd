function CreateClientsTable()
{
    var shellReturn = document.getElementById("resultClients");
    shellText = shellReturn.innerHTML.replace("<div id=\"resultClients\">", "").replace("</div>", "").replace("<!--", "").replace("-->");
    shellText = shellText.substring(shellText.indexOf("Username	Client ID	Peer ID"));

    var shellLines = shellText.split('\n');
    for(var i = 0;i < shellLines.length;i++)
    {
        
        if(shellLines[i].includes("CLIENT_LIST"))
        {
            shellTabs = shellLines[i].split('\t') 
            AddTable(shellTabs[1], shellTabs[2], shellTabs[3], shellTabs[7]);
        }
    }
}

function AddTable(UserName, IP_wan, ip_assign, since)
{
    var Headstd = document.createElement("tr");
    var userTD = document.createElement("td");
    var ipwanTD = document.createElement("td");
    var iplanTD = document.createElement("td");
    var sinceTD = document.createElement("td");

    userTD.innerHTML = UserName;
    ipwanTD.innerHTML = IP_wan;
    iplanTD.innerHTML = ip_assign;
    sinceTD.innerHTML = since;
    //Linestd = Linestd.replace("{user}", UserName).replace("{IPwan}", IP_wan).replace("{IPlan}", ip_assign).replace("{since}", since);
    //final = Headstd.replace("{line}", Linestd);
    Headstd.append(userTD);
    Headstd.append(ipwanTD);
    Headstd.append(iplanTD);
    Headstd.append(sinceTD);

    document.getElementById("tableBody").appendChild(Headstd);
}