$(document).ready(function(){
	var helper = new Helper();

	var dataTable = $("#dataTable").DataTable({
		"language": { search: '<i class="fas fa-search"></i>', searchPlaceholder: "Customer name, email..." },
        "processing":true,
        "order":[],
        "destroy": true, 
        "ajax": {
            url : base_url+'customers/dataList',
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

    	let stmt = (status == "1") ? 'activate' : 'deactivate';
    	let cstmt = (status == "1") ? 'Activate' : 'Deactivate';

    	swal({
          	title: `${cstmt} Customer!`,
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
        		helper.sendRequest('customers/set_status', {staffid:staffid,status:status}).then(function(response){
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

    $(document).on('click', '.edit_customer', function(e){
    	let id = $(this).data('staffid');
        let btn = $(this);

    	$.ajax({
            type: "POST",
            url: base_url+'customers/get_customer',
            data :  {customerid: id},
            dataType: 'json',
	        beforeSend: function(){
	           helper.btnEditLoading(btn);
	        },
            success: function (response){
            	if(response.status){
                    const customer = response.result;
	    			let editModal = $("#editModal");
                    editModal.find("#firstname").val(customer.firstname);
                    editModal.find("#middlename").val(customer.middlename);
                    editModal.find("#lastname").val(customer.lastname);
                    editModal.find("#dob").val(customer.dob);
                    editModal.find("#address").val(customer.address);
                    editModal.find("#email").val(customer.email);
                    editModal.find("#phone").val(customer.phone);
                    editModal.find("#customerid").val(customer.id);

                    editModal.modal('show');
	    		} else{
	    			if (response.message=="login") helper.redirect('login');
	    			swal('Oops', response.message, 'warning');
	    		}	

	    		helper.btnEditReset(btn);
            },
            error: function(){
            	swal('Oops', 'Oops! an unknown error has occurred', 'warning');
            	helper.btnEditReset(btn);
            }
        })
    })

    $(document).on('submit', '#addForm', function(e){
        e.preventDefault();
        let form = $(this);
        let btn = form.find('#add_btn');

        let data = form.serialize();
        $.ajax({
            type: "POST",
            url: base_url+'customers/create_customer',
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
                    $("#addModal").modal('hide');

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

    $(document).on('submit', '#editForm', function(e){
        e.preventDefault();
        let form = $(this);
        let btn = form.find('#edit_btn');

        let data = form.serialize();
        $.ajax({
            type: "POST",
            url: base_url+'customers/update_customer',
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

                    $("#editForm")[0].reset();
                    $("#editModal").modal("hide");

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
    $("#customerAutoComplete").autocomplete({
    	minLength:2,   
        delay:500,  
        source: function(request, response) {
            $.ajax({
                url: base_url + 'customers/search_customer',
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
            $('#customerAutoComplete').val(ui.item.label);
            $('#customer_id').val(ui.item.value);
            return false;
        }
    });
})