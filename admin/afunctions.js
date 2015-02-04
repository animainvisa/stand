function pidsetup(iid)
{ window.location = "editimage.php?setpid=" + iid; }

function imageremoval(iid)
{
	if (confirm("Tem a certeza de que deseja remover?")) 
	{ window.location = "removeimage.php?id=" + iid; }
	
	return false;
}

function vehicleremoval(vid)
{
	if (confirm("Tem a certeza de que deseja remover?")) 
	{ window.location = "removevehicle.php?id=" + vid; }
	
	return false;
}
