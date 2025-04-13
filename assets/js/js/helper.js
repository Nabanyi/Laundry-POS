class Helper {
    constructor() {
        //this.removePageLoader();
    }

    isNumeric(num) {
      return !isNaN(parseFloat(num)) && isFinite(num);
    }

    validateEmail(email) {
      let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(!regex.test(email)) {
        return false;
      }else{
        return true;
      }
    }

    // Validate urls provided users
    validateUrl(url){
        reg_exp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(reg_exp.test(url)){
           return true;
        }else{
            return false;
        }
    }

    // Button Loading State
    btnLoading(elem) {
        $(elem).attr("data-original-text", $(elem).html());
        $(elem).prop("disabled", true);
        $(elem).html('<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Loading...');
    }
    
    // Reset button Loading State
    btnReset(elem) {
        $(elem).prop("disabled", false);
        $(elem).html($(elem).attr("data-original-text"));
    }

    // Button Loading State
    btnEditLoading(elem) {
        $(elem).removeClass("bx bxs-edit");
        $(elem).prop("disabled", true);
        $(elem).html('<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>');
    }
    
    // Reset button Loading State
    btnEditReset(elem) {
        $(elem).prop("disabled", false);
        $(elem).addClass("bx bxs-edit");
        $(elem).html('');
    }

    btnIconLoading(elem) {
        $(elem).attr("data-original-text", $(elem).html());
        $(elem).prop("disabled", true);
        $(elem).html('<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>');
    }
    
    // Reset button Loading State
    btnIconReset(elem) {
        $(elem).prop("disabled", false);
        $(elem).html($(elem).attr("data-original-text"));
    }

    removeMsg(elem){
        setTimeout(function(){
            elem.html('');
        }, 3000);
    }

    scrollElem(elem, target){
        elem.animate({
            scrollTop: target.offset().top
        }, 300);
    }

    //check for internet connection
    isOnline(){
        return window.navigator.onLine;
    }

    redirect(path){
        let url = base_url + path;
        location.replace(url);
    }

    goBack(){
        window.history.back();
    }

    showConfirmDialog(title, subtitle, itemid, type){
        let modal_node = $("#confirmActionModal");
        modal_node.find('#title').html(title);
        modal_node.find('#subtitle').html(subtitle);
        modal_node.find('#yes_delete').data('itemid', itemid);
        modal_node.find('#yes_delete').data('type', type);
        modal_node.modal('show');
    }

    showToast(msg, template=true, status="Success"){
        let stat_class = (status=="Success") ? 'bg-success' : 'bg-danger';
        let stat_icon = (status=="Success") ? 'bx-check' : 'bx-error';
        let item = $(".toast").length;

        let html = msg;

        if (template) {
            html = `<div id="toast${item}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header  ${stat_class}">
                    <i class="me-2 text-white fw-bold bx ${stat_icon}"></i>
                    <strong class="me-auto text-white">${status}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${msg}
                </div>
            </div>`;
        }
    
        $("#alertContainer").append(html);
        if (template) {
            $("#toast"+item).toast('show');
        }
    }

    minutesDifferences(startdate, enddate){
        const date1 = new Date(startdate);
        const date2 = new Date(enddate);
        // const diffTime = Math.abs(date2 - date1);
        const diffTime = date2 - date1;
        const diffMinutes = Math.ceil(diffTime / (1000 * 60));
        return diffMinutes;
    }

    lastWeekDay(){
        var currentDate = new Date();
        var lastday = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 6));
        const month = lastday.getMonth() + 1;
        return lastday.getFullYear()+'/'+month+'/'+lastday.getDate();
    }

    lastMonthDay(){
        var dateNow = new Date();  
        //var firstDate = new Date(dateNow.getFullYear(), dateNow.getMonth(), 1);  
        var lastday = new Date(dateNow.getFullYear(), dateNow.getMonth() + 1, 0);
        const month = lastday.getMonth() + 1;
        return lastday.getFullYear()+'/'+month+'/'+lastday.getDate();
    }

    lastYearDay(){
        var actualDate = new Date();
        var lastYear = new Date(actualDate.getFullYear(),12,0);
        const month = lastYear.getMonth() + 1;
        return lastYear.getFullYear()+'/'+month+'/'+lastYear.getDate();
    }

    sendRequest(url, params=null, type=null){
        return $.ajax({
            url: base_url + url,
            type: "POST",
            data: params,
            dataType: 'json'
        });
    }

    readExcelFile(){
        $("#external_file").change(function(){

            var csv = $("#external_file").val();

            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
            if (regex.test($("#external_file").val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var rows = e.target.result.split("\r\n");
                        var total_rows = rows.length;

                        if(total_rows>0){
                            var firstRowCells = GetCSVCells(rows[0], ",");
                            var dataArray = new Array();
                            for(var i=1; i<total_rows; i++)
                            {
                                if(rows[i]!==""){
                                    var cells = rows[i].split(",");
                                    var cell_length = cells.length;
                                    var obj = {};
                                    for(var j=0; j<cell_length; j++)
                                    {
                                        obj[firstRowCells[j]] = cells[j];
                                    }

                                    dataArray.push(obj);
                                }
                            }

                            console.log(dataArray);
                        }
                    }
                    reader.readAsText($("#external_file")[0].files[0]);
                } else {
                    alert('This browser does not support this. Please use the latest version of Firefox or Chrome browser');
                }
            } else {
                alert('Please upload a valid CSV file');
            }
            
        })
    }

    printFooter(){
        return "<center><span style='font-size: 12px;color: #808080;'> </span></center>";
    }
}