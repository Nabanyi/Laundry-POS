$(document).ready(function () {
    var helper = new Helper();

    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };
    
    $(document).on('click', '.order-item', function(){
        let orderid = $(this).data('orderid');
        let btn = $(this);

        $.ajax({
            type: "POST",
            url: base_url+'orders/get_order',
            data :  {orderid: orderid},
            dataType: 'json',
            beforeSend: function(){
               helper.btnLoading(btn);
            },
            success: function (response){
                if(response.status){
                    const order = response.result;
                    const items = order.items
                    let detailsModal = $("#detailsModal");

                    let row = '';
                    for (var i = 0; i < items.length; i++) {

                        let sn = i + 1;
                        row += `
                            <tr>
                                <td>${sn}</td>
                                <td>${items[i].name}</td>
                                <td>${items[i].quantity}</td>
                                <td>${Number(items[i].selling_price).format(2)}</td>
                                <td>${Number(items[i].amount).format(2)}</td>
                            </tr>
                        `;
                    }

                    let options = '';
                    if(order.status == "0"){
                        options = `<div class="btn-group">
                                <button data-orderid="${order.id}" data-status="1" class="changeStatus btn btn-primary btn-lg" type="button"> Move to In-Progress </button>
                                <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle Dropdown</span> </button>
                                <ul class="dropdown-menu">
                                    <li><a data-orderid="${order.id}" data-status="2" class="changeStatus dropdown-item" href="#">Or Ready for Pickup</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a data-orderid="${order.id}" data-status="3" class="changeStatus dropdown-item" href="#">Or Picked Up/Delivered</a></li>
                                </ul>
                            </div>`
                    }else if(order.status == "1"){
                        options = `<div class="btn-group">
                                <button data-orderid="${order.id}" data-status="2" class="changeStatus btn btn-primary btn-lg" type="button"> Move to  Ready/Pick-up </button>
                                <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle Dropdown</span> </button>
                                <ul class="dropdown-menu">
                                    <li><a data-orderid="${order.id}" data-status="3" class="changeStatus dropdown-item" href="#">Or Picked Up/Delivered</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a data-orderid="${order.id}" data-status="0" class="changeStatus dropdown-item" href="#">Or back to Pending</a></li>
                                </ul>
                            </div>`
                    }else{
                        options = `<div class="btn-group">
                                <button data-orderid="${order.id}" data-status="3" class="changeStatus btn btn-primary btn-lg" type="button"> Move to Picked Up/Delivered </button>
                                <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle Dropdown</span> </button>
                                <ul class="dropdown-menu">
                                    <li><a data-orderid="${order.id}" data-status="1" class="changeStatus dropdown-item" href="#">Or back to In-Progress</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a data-orderid="${order.id}" data-status="0" class="changeStatus dropdown-item" href="#">Or back to Pending</a></li>
                                </ul>
                            </div>`
                    }

                    let data = `
                        <div class="d-flex justify-content-between">
                        <div>
                            <img src="${base_url + 'assets/img/company-logo.png'}" width="100">
                            <p>${order.companyphone}<br>${order.companyemail}<br>${order.companyaddress}</p>
                            <p class="fw-bold">#LD00${orderid}</p>
                        </div>
                            
                            <address>
                            Customer:<br>
                                ${order.customername}<br>
                                ${order.customerphone}<br>
                                ${order.customeremail}<br>
                                ${order.trans_date}
                            </address>
                        </div>

                        <h3 class="text-center">Items</h3>

                        <table class="table table-center table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%"> SN </th>
                                    <th style="width: 40%"> Items </th>
                                    <th style="width: 20%"> Quantity </th>
                                    <th style="width: 15%"> Price </th>
                                    <th style="width: 15%"> Total Amount </th>
                                </tr>
                            </thead>
                            <tbody>
                                ${row}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Total: ${Number(order.total_amount).format(2)}</td>
                                    <td>Discount: ${Number(order.discount_amt).format(2)}</td>
                                    <td>Paid: ${Number(order.amount_paid).format(2)}</td>
                                    <td>Balance: ${Number(order.balance).format(2)}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <button data-orderid="${order.orderid}" id="deleteOrder" class="${activator} btn btn-danger"><i class="bx bx-trash-alt"></i> Delete</button>
                            
                            ${options}
                        </div>
                    `;

                    $("#detailsbody").html(data);                    

                    detailsModal.modal('show');
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

    $(document).on('click', '.changeStatus', function(){
        let orderid = $(this).data('orderid');
        let status = $(this).data('status');

        let stmt = '';
        if(status == "1"){
            stmt = "Move to In-Progress?"
        }else if(status == "2"){
            stmt = "Move to Ready for Pickup/Delivery?"
        }else if(status == "3"){
            stmt = "Move to Picked Up/Delivered?"
        }else{
            stmt = "Move to Pending?"
        }

        swal({
            title: stmt,
            text: `Do you want to proceed!`,
            type: "warning",
            confirmButtonText: `Yes, Proceed!`,
            cancelButtonText: "No, Cancel!",
            confirmButtonColor: "#005960",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
        }, function(isConfirm){
            if(isConfirm){
                helper.sendRequest('orders/set_order_status', {orderid:orderid,status:status}).then(function(response){
                    if (response.status) {

                        swal({
                            title: "Okay!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        window.location.reload();
                    }else{
                        if (response.message=="login") helper.redirect('login');

                        swal('Oops', response.message, 'error');
                    }
                });
            }
        })
    })

    $(document).on('click', '#deleteOrder', function(){
        let orderid = $(this).data('orderid');

        swal({
            title: 'Delete Order?',
            text: `Do you want to proceed!`,
            type: "warning",
            confirmButtonText: `Yes, Proceed!`,
            cancelButtonText: "No, Cancel!",
            confirmButtonColor: "#dc3545",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
        }, function(isConfirm){
            if(isConfirm){
                helper.sendRequest('orders/delete_order', {orderid:orderid}).then(function(response){
                    if (response.status) {

                        swal({
                            title: "Okay!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        window.location.reload();
                    }else{
                        if (response.message=="login") helper.redirect('login');

                        swal('Oops', response.message, 'error');
                    }
                });
            }
        })
    })
});