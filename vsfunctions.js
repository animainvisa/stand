function getmakes()
{
	var c = 0, newe, newtn;
	var ref = document.getElementsByName("make")[0];
	
	for (c in makes)
	{
		newe = document.createElement("option");
		newtn = document.createTextNode(makes[c]);
		
		newe.setAttribute("value", makes[c]);		
		newe.appendChild(newtn);
		ref.appendChild(newe);
	}
}

function getmakesid(make)
{
	var c = 0;
	
	for (c in makes) 
	{ if (makes[c] == make) { return c; } }
	
	return -1;
}

function getmodels(make)
{	
	var ei = 0, fe = 0;
	var ref = document.getElementsByName("model")[0];	
	
	while (ei < ref.childNodes.length)
	{
		if (ref.childNodes[ei].nodeType == 1 && fe++)
		{ ref.removeChild(ref.childNodes[ei]); }
		else
		{ ei++; }
	}
	
	var id = getmakesid(make);
	
	if (id+1)
	{
		var c = 0, newe, newtn;
	
		for (c in models[id])
		{
			newe = document.createElement("option");
			newtn = document.createTextNode(models[id][c]);
			
			newe.setAttribute("value", models[id][c]);		
			newe.appendChild(newtn);
			ref.appendChild(newe);
		}
	}
}

window.onload = getmakes;
