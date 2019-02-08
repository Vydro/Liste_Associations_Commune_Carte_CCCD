

function connexion(){
	$.ajax({
		type: 'POST',
		url: 'ajax/valide_connexion.php',
		datatype: 'json',
    	encode: true,
    	data: 'login='+$('#login').val()+'&password='+$('#password').val(),
    	success: function(retour){
    		retour = JSON.parse(retour);
    		if(retour['success'])
    		{
    			document.location.href="accueil";
    		}
    		else{
    			alert("ERREUR : login ou password incorrect !");
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

function InvalidMsg(textbox) {
 
    if (textbox.value == '') {textbox.setCustomValidity('Ce champ est obligatoire');}
    else {textbox.setCustomValidity('');}
    return true;
}

