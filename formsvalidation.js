function askaboutformval(obj)
{	
	if (!obj.name.value.length)
	{
		alert("O campo \"Nome\" é requerido.");
		return false;
	}
	
	if (!obj.contact.value.length && !obj.email.value.length)
	{
		alert("Pelo menos, o campo \"Contacto(s)\" ou \"Email\" é requerido.");
		return false;
	}
	
	if (!obj.email.value.match(/^(([-a-z0-9_\.]+@([-a-z0-9]+\.)+[a-z]{2,})|)$/i))
	{
		alert("O campo \"Email\" tem de ser válido.");
		return false;
	}	
	
	if (!obj.question.value.length)
	{
		alert("O campo \"Questão\" é requerido.");
		return false;
	}
}

function tellafriendformval(obj)
{
	if (!obj.namef.value.length)
	{
		alert("O campo \"Nome\" é requerido.");
		return false;
	}
	
	if (!obj.emailt.value.match(/^[-a-z0-9_\.]+@([-a-z0-9]+\.)+[a-z]{2,}$/i))
	{
		alert("O campo \"Email (do amigo)\" é requerido e tem de ser válido.");
		return false;
	}
}
