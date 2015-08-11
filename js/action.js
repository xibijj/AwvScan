function cpasswd(){
	
	if ( $('#newpasswd').val() == $('#repasswd').val() ) {
		
		//alert( $('#newpasswd').val() + $('#oldpasswd').val());
		$.ajax({  
			type: "POST",  
			url: "ajax.php?m=cpasswd",  
			data: { oldpasswd: $('#oldpasswd').val() , newpasswd: $('#newpasswd').val() },  
			success: function(data) { alert(data); }
		});
	}
}

function del(p){
		
		//alert( p );
		$.ajax({  
			type: "POST",  
			url: "ajax.php?m=del",  
			data: { hash : p },  
			success: function(data) { 
						alert(data); 
						window.location.reload();
						}
		});
}

function exportexcel(p){
		window.location.href = 'ajax.php?m=export&hash=' + p;
}