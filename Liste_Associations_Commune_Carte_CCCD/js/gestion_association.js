/* AJOUTER UNE ASSOCIATION */

$(document).ready(function() {
	  // Action qui est exécutée quand le formulaire est envoyé ( #ajoutAssociation est l'ID du formulaire)
	$('#ajoutAssociation').on('submit', function(e) 
	{
		var myWindow = confirm("Êtes vous sûre d'ajouter cette association ?");
		if(myWindow)			
		{
			var cat_select = document.getElementById("arrayCat");
			var comm_select = document.getElementById("arrayComm");
			$.ajax({
	   			type: 'POST',
	   			url: 'ajax/ajouter_association.php',
	   			datatype: 'json',
	        	encode: true,
	        	data: 'intitule='+vlId('intitule')+'&idCat='+cat_select.selectedIndex+
	        	'&nomP='+vlId('nom')+'&prenomP='+vlId('prenom')+'&civilite='+document.querySelector('input[name="civilite"]:checked').value+
	        	'&idComm='+comm_select.selectedIndex+'&adresse='+vlId('adresse')+
	        	'&tel='+vlId('tel')+'&url='+vlId('url')+'&descriptif='+vlId('descriptif'),
	        		
	        	success: function(retour){
	        			retour = JSON.parse(retour);
	        			switch(retour['erreur'])
	        			{
	        				case 'aucune':
	        					alert('L\'ajout c\'est bien déroulé');
	        					break;
	        					
	        				case 'requete':
	        					alert('ERREUR : Un problème est survenue lors de l\'exécution de la requête');
	        					break;
	        					
	        				case 'post':
	        					alert('ERREUR : Les valeurs des champs obligatoires n\'ont pas pu être récupérées');
	        					break;

	        				case 'connexion':
	        					alert('ERREUR : Vous n\'êtes pas connecté ou ne disposez pas des droits pour cette manipulation');
	        					break;
	        			}
	   			},
	   			error: function(jqXHR, textStatus)
	   			{
				//traitement des erreurs ajax
	     			if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
	    			else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
					else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
					else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
					else if (textStatus === "timeout"){alert("Time out error.");}
					else if (textStatus === "abort"){alert("Ajax request aborted.");}
					else{alert("Uncaught Error.n" + jqXHR.responseText);}
				}
	   		});
		}
		else{return false;}
	});
});

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

function vlId(id) {
	switch (id) {
		case 'nom' :
			document.getElementById(id).value =  document.getElementById(id).value.toUpperCase();
			break;
			
		case 'prenom' :
			document.getElementById(id).value =  document.getElementById(id).value.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
			document.getElementById(id).value =  document.getElementById(id).value.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('-');
			break;
			
		case 'intitule' :
			document.getElementById(id).value =  document.getElementById(id).value.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
			document.getElementById(id).value =  document.getElementById(id).value.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('-');
			break;
	}
	return document.getElementById(id).value
}
