
function div_show(ID) {
	var id= ID;
	console.log(id);
	jQuery.ajax({
			type: 'post',
			url: the_ajax_scripts.ajaxurl,		
			data:{
					action: 'speakerinfo',
			     	id: id,
			  }, 
			success: function(data) {
			 
	            console.log(data);
	            document.getElementById('textm').style.display = "block";
	            var value = data;
		        var test = value.split('**');
		        var title= test[0];
		        var speakerimg= test[1];
		        var organsation= test[2];
		        var designation= test[3];
		        var description= test[4];
		        var logos= test[5];
		        document.getElementById("speakerimg").innerHTML = '<img src=\''+speakerimg+'\'>';
	            document.getElementById("namepopup").innerHTML = title;
	            document.getElementById("desigpopup").innerHTML = designation;
	            document.getElementById("orgpopup").innerHTML = organsation;
	            document.getElementById("biopopup").innerHTML = description;
	            document.getElementById("urlpopup").innerHTML = '<img src=\''+logos+'\'>';
	         
	            
        	}
		});

}

function div_hide(){
	document.getElementById('textm').style.display = "none";
}
