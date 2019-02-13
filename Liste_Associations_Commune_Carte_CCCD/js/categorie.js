/* permet d'afficher toute les associations lorsque l'on arrive sur la page*/
/*$(function () {
    $('#categorie').trigger('change');
});*/

/* appel AJAX pour afficher les assoc par rapport à la commune / categorie*/
function js_change_cat (){
	document.getElementById('divAssoc').style.display = "block";
var myselect = document.getElementById("categorie");
var commune = document.location.href.slice((document.location.href.length - document.location.href.lastIndexOf( "/" ) - 1)*-1);
$('#divAssoc').empty();
	$.ajax({
   			type: 'POST',
   			url: '../../ajax/recherche_assoc.php',
   			datatype: 'json',
        	encode: true,
        	data: 'idCat='+myselect.options[myselect.selectedIndex].value+'&commune=' + commune,
        	success: function(retour){
        		retour = JSON.parse(retour);
        		var i = 0;
        		while(i < retour["intitule"].length){
       				document.getElementById("divAssoc").innerHTML += '<p>'+
       					'<atstrong>'+retour['intitule'][i]+'</atstrong> - Association '+retour['nomCategorie'][i]+'<br>'+
       					'<atcivil>Président(e) '+retour['civilite'][i]+' '+retour['nom'][i]+'</atcivil><br>'+
       					'<at>'+retour['adresse'][i]+'</at><br>'+
       					'<a class="b" href="'+document.location.href+'/'+encodeURIComponent(retour['intitule'][i].toString().toLowerCase())+'">Plus d\'infos &#8594;</a>'+
        				'<esp><hr></p>';
        			i++;
        		};
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