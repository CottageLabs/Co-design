$(document).ready(function(){
	//turn on fancybox for login
	$('.fancybox').fancybox();
	
	//Display an alert if the URL has ?alert=<message>
  	var regex = new RegExp(  "[\\?&]alert=([^&#]*)" );
  	var results = regex.exec( window.location.href );
  	if( results != null ) {
  		$.fancybox.open({
			content : '<div class="co-design-alert"><h1>Alert</h1><h2>' + decodeURI(results[1].replace(/\+/g, " ")) +'</h2><p class="ok"><input type="button" onClick="$.fancybox.close();" value="Ok" /></p></div>',
			modal: true
		}); 	
  	}
  
});	
