function fadeintext(ID){
 	//alert('hiee');
        $("#fulldesc"+ID).fadeIn();
        $("#shortdesc"+ID).hide();
    };
function fadeouttext(ID){
	
	$("#fulldesc"+ID).hide();
    $("#shortdesc"+ID).show();
    
}