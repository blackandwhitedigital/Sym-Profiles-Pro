(function($){
    $('.tlp-color').wpColorPicker();
})(jQuery);
function speakerSettings(e){

    jQuery('#response').hide();
	arg=jQuery( e ).serialize();
	bindElement = jQuery('#tlpSaveButton');
	AjaxCall( bindElement, 'speakerSettings', arg, function(data){
        console.log(data);
        if(data.error){
            jQuery('#response').removeClass('error');
            jQuery('#response').show('slow').text(data.msg);
        }else{
            jQuery('#response').addClass('error');
            jQuery('#response').show('slow').text(data.msg);
        }
    });

}

function AjaxCall( element, action, arg, handle){
    if(action) data = "action=" + action;
    if(arg)    data = arg + "&action=" + action;
    if(arg && !action) data = arg;
    data = data ;

    var n = data.search("speaker_nonce");
    if(n<0){
        data = data + "&speaker_nonce=" + speaker_nonce;
    }

	jQuery.ajax({
		type: "post",
        url: ajaxurl,
        data: data,
		beforeSend: function() { jQuery("<span class='tlp_loading'></span>").insertAfter(element); },
		success: function( data ){
            jQuery(".tlp_loading").remove();
            handle(data);
		}
	});
}
