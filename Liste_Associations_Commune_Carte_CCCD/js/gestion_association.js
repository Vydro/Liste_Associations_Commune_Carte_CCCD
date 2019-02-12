/*Ajouter une association*/


/*fonctions diverses*/

function InvalidMsg(textbox) {
    if (textbox.value == '') 
    {
    	textbox.setCustomValidity('Ce champ est obligatoire');
    }
    else 
    {
    	textbox.setCustomValidity('');
    }    
    return true;
}

function valid()
{
	var myWindow = confirm("Êtes vous sûre d'ajouter cette association ?");
	if(myWindow){alert('tout est OK :D');}
}