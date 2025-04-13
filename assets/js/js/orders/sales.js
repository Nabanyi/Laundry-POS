$(document).ready(function(){
	Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

	var helper = new Helper();

    $(".datepicker").datetimepicker({ 
        format: "YYYY-MM-DD", 
        maxDate: new Date(),
        defaultDate: new Date(),
        icons: { 
            up: "fas fa-angle-up", 
            down: "fas fa-angle-down", 
            next: "fas fa-angle-right", 
            previous: "fas fa-angle-left" 
        } 
    });

    var filters = {
        fromdate: '',
        todate: '',
        type: 'All'
    };

    $("#search_btn").click(function(e){
        e.preventDefault();
        
        let btn = $(this);

        filters.fromdate    = $("#fromdate").val();
        filters.todate      = $("#todate").val();
        filters.type       = $("#type").val();

        setTable(filters);
    })

    function setTable(filters){
        $.ajax({
            type: "POST",
            url: base_url+'orders/get_sales',
            data : filters,
            dataType: 'json',
            beforeSend: function(){
               helper.btnIconLoading($("#search_btn"));
            },
            success: function (response){
                if (response.status) {
                    $("#salesHolder tbody").html(response.result.table);
                    $("#tableInfo").html(`
                        <p>Total Amount: ${Number(response.result.total_amount).format(2)}</p>
                        <p>Discount Given: ${Number(response.result.total_discount).format(2)}</p>
                        <p>Amount Paid: ${Number(response.result.total_paid).format(2)}</p>
                        <p>Balance: ${Number(response.result.total_balance).format(2)}</p>
                    `);
                }else{
                    $("#salesHolder tbody").html(`<tr>
                        <td colspan="8" class="text-center text-muted">No transactions found for the dates specified</td>
                    </tr>`);
                    $("#tableInfo").html(`
                        <p>Total Amount: 0.00</p>
                        <p>Discount Given: 0.00</p>
                        <p>Amount Paid: 0.00</p>
                        <p>Balance: 0.00</p>
                    `);
                }
                helper.btnIconReset($("#search_btn"));
            },
            error: function(){
                swal('Oops', 'Oops! an unknown error has occurred', 'warning');
                helper.btnIconReset($("#search_btn"));
            }
        })
    }

    $(document).on('click', '.order-item', function(){
        let orderid = $(this).data('orderid');
        let btn = $(this);

        $.ajax({
            type: "POST",
            url: base_url+'orders/get_order',
            data :  {orderid: orderid},
            dataType: 'json',
            beforeSend: function(){
               helper.btnIconLoading(btn);
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
                    `;

                    $("#detailsbody").html(data);                    

                    detailsModal.modal('show');
                } else{
                    if (response.message=="login") helper.redirect('login');
                    swal('Oops', response.message, 'warning');
                }   

                helper.btnIconReset(btn);
            },
            error: function(){
                swal('Oops', 'Oops! an unknown error has occurred', 'warning');
                helper.btnIconReset(btn);
            }
        })
    })

    $(document).on('click', '.printbtn', function(){
        $(this).parents('.modal-content').find('#detailsbody').printThis();
    })

    $(document).on('click', '.receive-payment', function(){
        let orderid = $(this).data('orderid');
        let amount = $(this).data('amount');
        let discount = $(this).data('discount');
        let paid = $(this).data('paid');
        let balance = $(this).data('balance');

        $("#paymentsModal #orderid").val(orderid);
        $("#paymentsModal #total_amount").val(amount);
        $("#paymentsModal #discount").val(discount);
        $("#paymentsModal #paid").val(paid);
        $("#paymentsModal #balance").val(balance);

        $("#paymentsModal").modal('show');
    })

    $("#receivePayments").submit(function(e){
        e.preventDefault();
        let form = $(this);
        let btn = form.find("#submit");

        $.ajax({
            type: "POST",
            url: base_url+'orders/receive_payments',
            data : form.serialize(),
            dataType: 'json',
            beforeSend: function(){
               helper.btnLoading(btn);
            },
            success: function (response){
                if (response.status) {
                    swal({
                        title: "Okay!",
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    $("#paymentsModal").modal('hide');
                }else{
                    swal('Oops', response.message, 'error');
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