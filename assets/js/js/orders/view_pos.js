$(document).ready(function(){
    var helper = new Helper();

	Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  	return new bootstrap.Tooltip(tooltipTriggerEl)
	})

    $(".datepicker").datetimepicker({ 
        format: "YYYY-MM-DD", 
        defaultDate: new Date(),
        icons: { 
            up: "fas fa-angle-up", 
            down: "fas fa-angle-down", 
            next: "fas fa-angle-right", 
            previous: "fas fa-angle-left" 
        } 
    });

    $("#sortItems").on('input', function(){
        let input = $(this);
        let filter = input.val().toLowerCase()

        $("#itemsList h6").filter(function() {
            let htext = $(this).text().toLowerCase()
            let aparent = $(this).parents('.item')
            aparent.toggle(htext.indexOf(filter) > -1)
        });
    })

    var ITEMS_ADDED = [];
    $("#itemsList .item").on('click', function(e){
        e.preventDefault();

        let name = $(this).data('itemname');
        let id = $(this).data('itemid');
        let price = $(this).data('itemprice');

        if(ITEMS_ADDED.includes(name)) return false

        const rowcontent = `
            <tr class="add-row">
                <td><input class="form-control items" type="hidden" name="items[]" value="${id}"> ${name}</td>
                <td>
                    <input class="form-control qty" type="number" id="qty" name="qty[]" value="1" required>
                </td>
                <td>${Number(price).format(2)} <input class="price" type="hidden" value="${price}"></td>
                <td class="rowTotal">${Number(price).format(2)}</td>
                <td class="add-remove text-end">
                    <a class="remove-btn" data-itemname="${name}" href="javascript:void(0);"> <i class="bx bx-trash-alt"> </i> </a>
                </td>
            </tr> 
        `;

        $(".add-table-items tbody").append(rowcontent);

        ITEMS_ADDED.push(name);

        calculate_total_item_amount();
    })

    $(".add-table-items").on('click', '.remove-btn', function() {
        
        const itemname = $(this).data('itemname');
        let index = ITEMS_ADDED.indexOf(itemname);
        if (index !== -1) {
            ITEMS_ADDED.splice(index, 1);
        }

        $(this).closest('.add-row').remove();
        calculate_total_item_amount();
        return false;
    });

    $(document).on('input', '#prepare_form .qty', function(){
        let qty = $(this).val();
        if(qty == "" || qty <= 0){
            $(this).addClass('is-invalid');
        }else{
            $(this).removeClass('is-invalid');
        }

        calculate_total_item_amount();
    });

    function calculate_total_item_amount() {
        let overallTotal = 0
        $(".add-table-items tbody tr").each(function(){
            let qty = $(this).find('.qty').val()
            qty = (qty == '' || qty <= 0) ? 0 : parseFloat(qty)

            let price = $(this).find('.price').val()
            price = (price == '') ? 0 : parseFloat(price)

            let total = qty * price

            overallTotal += total

            $(this).find('.rowTotal').html(Number(total).format(2))
        })

        $("#total_amount").html(`Total: ${overallTotal}`);

        return overallTotal;
    }

    $("#addNewClient").click(function(){
        $("#autocompleteWrapper").slideToggle();
        $("#newClientWrapper").slideToggle();
    })

    //autocomplete for customer selection
    $("#customerautocomplete").autocomplete({
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
                    if (data.message=="login") helper.redirect('login/logout');
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $("#customerautocomplete").val(ui.item.label)
            $("#customerid").val(ui.item.actual_value)
            return false;
        }
    });

    $("#prepare_form").submit(function(e){
        e.preventDefault()

        const form = $(this);
        const btn = form.find('.button')

        const cost = calculate_total_item_amount()

        if(cost <= 0){
            swal('Awwsh!', 'Select at least one item to sell', 'warning');
            return false;
        }

        $.ajax({
            type: "POST",
            url: base_url+'orders/create_order',
            data : new FormData(form[0]),
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function(){
               helper.btnLoading(btn);
            },
            success: function (response){
                if(response.status){

                    $("#printSalesModal #printresult").html(response.result)
                    $("#printSalesModal").modal('show')
                    
                    // reset form here
                    form[0].reset();
                    $(".add-table-items tbody tr").not(".first-row").remove();
                    $("#total_amount").html("Total: 0.00");
                    ITEMS_ADDED = [];

                } else{
                    if (response.message=="login") helper.redirect('login/logout');
                    swal('Awwsh!', response.message, 'warning');
                }   

                helper.btnReset(btn);
            },
            error: function(){
                swal('Awwsh', helper.internetErrorMessage, 'warning');
                helper.btnReset(btn);
            }
        })
    })

    $(document).on('click', '.printbtn', function(){
        $(this).parents('.modal-content').find('#printArea').printThis();
    })


});