$(document).ready(function(){
	var helper = new Helper();

	var dataTable = $("#dataTable").DataTable({
		"language": { search: '<i class="fas fa-search"></i>', searchPlaceholder: "Staff ID or username" },
        "processing":true,
        "order":[],
        "destroy": true, 
        "ajax": {
            url : base_url+'users/dataList',
            type: "POST",
            data: function(req){ }, 
        },
      	lengthChange: true,
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "columnDefs": [
	    	{
	    		"targets": -1,
	    		"searchable": false,
	    		"className": "text-end",
	    		"orderable":false
	    	},
	  	],
	  	buttons: [
          	'copy', 'excel', 'pdf', 'print', 'csv'
      	],
	  	"initComplete": function( settings, json ) {
	  		dataTable.buttons().container().appendTo( '#example_wrapper .col-sm-12:eq(0)' );
		}
    });

    dataTable.on( 'xhr', function () {
	    let json = dataTable.ajax.json();
	    if (json.message=="login") {
	    	helper.redirect('login');
	    }	    
	});

	// DataTables print button re-mapped
    $("#excelExport").on("click", function(e) {
        e.preventDefault();
        $(".buttons-excel").trigger("click");
    });
    $("#csvExport").on("click", function(e) {
        e.preventDefault();
        $(".buttons-csv").trigger("click");
    });
    $("#copyExport").on("click", function(e) {
        e.preventDefault();
        $(".buttons-copy").trigger("click");
    });
    $("#pdfExport").on("click", function(e) {
        e.preventDefault();
        $(".buttons-pdf").trigger("click");
    });
    $("#printExport").on("click", function(e) {
        e.preventDefault();
        $(".buttons-print").trigger("click");
    });

    $(document).on('click', '.activate_user', function(){
    	let staffid = $(this).data('staffid');
    	let name = $(this).data('name');
    	let status = $(this).data('status');

    	let stmt = (status == "1") ? 'activate' : 'block';
    	let cstmt = (status == "1") ? 'Activate' : 'Block';

    	swal({
          	title: `${cstmt} User!`,
          	text: `Do you really want to ${stmt} ${name}`,
          	type: "warning",
          	confirmButtonText: `Yes, ${stmt}!`,
          	cancelButtonText: "No, Cancel!",
          	confirmButtonColor: "#005960",
          	showCancelButton: true,
          	closeOnConfirm: false,
          	closeOnCancel: true,
          	showLoaderOnConfirm: true,
        }, function(isConfirm){
        	if(isConfirm){
        		helper.sendRequest('users/set_user_status', {staffid:staffid,status:status}).then(function(response){
					if (response.status) {

						swal({
	                      	title: "Okay!",
	                      	text: response.message,
	                      	timer: 2000,
	                      	showConfirmButton: false
	                    });

						dataTable.ajax.reload();
					}else{
						if (response.message=="login") helper.redirect('login');

						swal('Oops', response.message, 'error');
					}
				});
        	}
        })
    })

    $(document).on("click", "#add_new_user_btn", function () {
        $("#add_new_user_wrapper").slideToggle("slow");
    });

    $(document).on('submit', '#addForm', function(e){
    	e.preventDefault();
    	let form = $(this);
    	let btn = form.find('#add_btn');

    	let data = form.serialize();
    	$.ajax({
            type: "POST",
            url: base_url+'users/create_user',
            data :  data,
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

	    			$("#addForm")[0].reset();
	    			$("#add_new_user_wrapper").slideToggle("slow");

	    			dataTable.ajax.reload();
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

    //autocomplete for staff selection
    $("#staffAutoComplete").autocomplete({
    	minLength:2,   
        delay:500,  
        source: function(request, response) {
            $.ajax({
                url: base_url + 'users/search_staff',
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $('#staffAutoComplete').val(ui.item.label);
            $('#staff_id').val(ui.item.value);
            return false;
        }
    });
})