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
  	
  	
  	
  	function bindPost(){
		$('button#postCommentButton').bind('click', function(){
			$('#newCommentBox').attr('disabled', 'disabled');
			$('.loadingBar').fadeIn();
			
			$.post(window.location.pathname + "/comment", { 'body': $('#newCommentBox').val() }, function(data){
				if(data.status == 200){
					// OK, posted!
					var newComment = $(data.html);
					newComment.hide();
					
					$('#newComment').after(newComment);
					
					newComment.fadeIn();
					$('#newCommentBox').val("").removeAttr('disabled');
				} else {
					alert(data.message);
				}
				
				$('.loadingBar').hide();
			}, 'json');
		});
	
		//$('.loadingBar').disableSelection();
	}

	function bindDelete(){
		$('.delete .deleteButton').bind('click', function(){
			var cfm = confirm("Are you sure you want to delete this comment? This action cannot be undone.");
			
			var comment = $(this).parentsUntil('.comment').parent();

			if(cfm){
				// Get the ID.
				var id = comment.find('input[name=id]').val();
				
				$.post(window.location.pathname + "/comment/" + id + "/delete", function(data){
					if(data.status == 200){
						// OK, deleted!
						
						comment.fadeOut('fast', function() { $(comment).remove(); } );
					} else {
						alert(data.message);
					}
					
				}, 'json');
			}
			
			return false;
		});
	}
	
	function bindDeleteUser(){
		$('.delete-user').bind('click', function(){
			var cfm = confirm("Are you sure you want to delete this user? This action cannot be undone.");
			
			if(cfm){
				// Get the ID.
				var user_id = $(this).attr('name').substr("user_delete_".length);
				var user = $(this).parentsUntil('tr').parent();
				
				$.post(window.location.pathname + "/delete/" + user_id, function(data){
					if(data.status == 200){
						// OK, deleted!
						
						user.fadeOut('fast', function() { $(user).remove(); } );
					} else {
						alert(data.message);
					}
					
				}, 'json');
			}
			
			return false;
		});
	}



	
	bindPost();
		
	bindDelete();
  
  	bindDeleteUser();
});	
