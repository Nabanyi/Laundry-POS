$(document).ready(function () {

    var helper = new Helper();

    var dataTable = $("#dataTable").DataTable({
        "language": { search: '<i class="fas fa-search"></i>', searchPlaceholder: "Search product name, sku" },
        "processing":true,
        "order":[],
        "destroy": true, 
        "ajax": {
            url : base_url+'products/dataList',
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

    $(document).on('click', '.activate_product', function(){
        let id = $(this).data('itemid');
        let name = $(this).data('name');
        let status = $(this).data('status');

        let stmt = (status == "1") ? 'activate' : 'deactivate';
        let cstmt = (status == "1") ? 'Activate' : 'Deactivate';

        swal({
            title: `${cstmt} Product!`,
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
                helper.sendRequest('products/set_product_status', {id:id,status:status}).then(function(response){
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
    
    $('#productForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = form.find('#addBtn');

        let formData = new FormData(this);

        $.ajax({
            url: "products/create",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function(){
               helper.btnLoading(btn);
            },
            success: function (response) {                
                if(response.status){

                    swal({
                        title: "Okay!",
                        type: "success",
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    dataTable.ajax.reload();

                    $("#productForm")[0].reset();
                    $('#addProductModal').modal('hide');
                } else{
                    if (response.message=="login") helper.redirect('login');
                    swal('Oops', response.message, 'warning');
                }   

                helper.btnReset(btn);
            },
            error: function (xhr) {
                helper.btnReset(btn);
                alert(xhr.responseJSON.error);
            }
        });
    });

    $(document).on('click', '.editItem', function(){
        let itemid = $(this).data('itemid');
        let btn = $(this);
        $.ajax({
            url: "products/getProduct",
            type: "POST",
            data: {id: itemid},
            dataType: 'json',
            beforeSend: function(){
               helper.btnEditLoading(btn);
            },
            success: function (response) {                
                if(response.status){

                    let product = response.result;
                    let editProductModal = $("#editProductModal");
                    editProductModal.find("#name").val(product.name)
                    editProductModal.find("#id").val(product.id)
                    editProductModal.find("#sku").val(product.sku)
                    editProductModal.find("#price").val(product.price)

                    editProductModal.modal('show');
                    
                } else{
                    if (response.message=="login") helper.redirect('login');
                    swal('Oops', response.message, 'warning');
                }   

                helper.btnEditReset(btn);
            },
            error: function (xhr) {
                helper.btnEditReset(btn);
                alert(xhr.responseJSON.error);
            }
        });
    })

    $('#updateForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = form.find('#editBtn');

        let formData = new FormData(this);

        $.ajax({
            url: "products/update",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function(){
               helper.btnLoading(btn);
            },
            success: function (response) {                
                if(response.status){

                    swal({
                        title: "Okay!",
                        type: "success",
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    dataTable.ajax.reload();

                    $("#updateForm")[0].reset();
                    $('#editProductModal').modal('hide');
                } else{
                    if (response.message=="login") helper.redirect('login');
                    swal('Oops', response.message, 'warning');
                }   

                helper.btnReset(btn);
            },
            error: function (xhr) {
                helper.btnReset(btn);
                alert(xhr.responseJSON.error);
            }
        });
    });

});