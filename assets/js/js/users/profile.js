$(document).ready(function(){
	var helper = new Helper();

	$(document).on('submit', '#updateProfile', function(e){
    	e.preventDefault();
    	let form = $(this);
    	let btn = form.find('#add_btn');

    	$.ajax({
            type: "POST",
            url: base_url+'users/update_profile',
            data :  form.serialize(),
            dataType: 'json',
	        beforeSend: function(){
	           helper.btnLoading(btn);
	        },
            success: function (response){
            	if(response.status){

	    			swal({
	                  	title: "Okay!",
	                  	type: "success",
	                  	text: response.message,
	                  	timer: 3000,
	                  	showConfirmButton: false
	                });

	    			window.location.reload();
	    		} else{
	    			if (response.message=="login") helper.redirect('login');
	    			swal('Oops', response.message, 'warning');
	    		}	

	    		helper.btnReset(btn);
            },
            error: function(){
            	swal('Oops', 'Oops! an unknown error has occurred', 'warning');
            	helper.btnReset(btn);
            }
        })
    })

	$(document).on('submit', '#passwordForm', function(e){
    	e.preventDefault();
    	let form = $(this);
    	let btn = form.find('#pass_btn');

    	$.ajax({
            type: "POST",
            url: base_url+'users/update_password',
            data :  form.serialize(),
            dataType: 'json',
	        beforeSend: function(){
	           helper.btnLoading(btn);
	        },
            success: function (response){
            	if(response.status){

	    			swal({
	                  	title: "Okay!",
	                  	type: "success",
	                  	text: response.message,
	                  	timer: 3000,
	                  	showConfirmButton: false
	                });

	    			window.location.reload();
	    		} else{
	    			if (response.message=="login") helper.redirect('login');
	    			swal('Oops', response.message, 'warning');
	    		}	

	    		helper.btnReset(btn);
            },
            error: function(){
            	swal('Oops', 'Oops! an unknown error has occurred', 'warning');
            	helper.btnReset(btn);
            }
        })
    })
})