function js_change_cat (){
	document.getElementById('divAssoc').style.display = "block";
var myselect = document.getElementById("categorie");
$('#divAssoc').empty();
	$.ajax({
   			type: 'POST',
   			url: 'ajax/recherche_assoc.php',
   			datatype: 'json',
        	encode: true,
        	data: 'idCat='+myselect.options[myselect.selectedIndex].value, // on envoie via post l’id
        	success: function(retour) {
          			//$.each(retour)
          			 //{
        				//document.getElementById('divAssoc').innerHTML += '<p>'+retour.intitule+'><p>' ;	
        				console.dir(retour);			
               		 //}
   				},
   			error: function(jqXHR, textStatus)
			{
			// traitement des erreurs ajax
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