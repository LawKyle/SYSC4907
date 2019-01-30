function editName(listID) {
    let oldName = $("#title" + listID).html().trim();
    let inputText = " <input type=\"text\" class=\"form-control\" name=\"inputName\" + listID + \" id=\"inputName" + listID + "\" value='"+ oldName + "'>" +
        "  <button type=\"button\" onclick='editNameAjax(" + listID + ")' class=\"btn btn-primary mb-2\">OK</button>\n";

    $("#divList" + listID).html(inputText);
}

function editNameAjax(listID) {
    let newName = $('#inputName' + listID).val();
    let returnToTitle = "<h4 id=\"title" + listID + "\" class=\"title\">" + newName + "</h4>";
    returnToTitle += "<button class=\"btn pull-right\" onclick=\"deleteList(" + listID + ");\"><i class=\"ti-trash\"></i></button>" +
        "<button class=\"btn pull-right\" onclick=\"editName(" + listID+ ");\"><i class=\"ti-pencil-alt\"></i></button>";
    $("#divList" + listID).html(returnToTitle);

    let dataArray = {};
    dataArray['list_id'] = listID;
    dataArray['new_name'] = newName;
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/myGroceryList/editName',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: dataString,
        success: function(response){
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}

function addProduct(listID) {
    let IDs = $("#products" + listID).val();
    let values = $("#products" + listID + " :selected");

    for(let i = 0; i < values.length; i++) {
        let row = $('<tr>');
        let data = $('<td>');
        data.append("<a href=\"/product/" + IDs[i] + "\">" + values[i].innerHTML + "</a>");
        row.append(data);
        $("#table" + listID + "> tbody:last-child").append(row);
     }

    let dataArray = {};
    dataArray['list_id'] = listID;
    dataArray['product_id'] = JSON.stringify(IDs);
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/myGroceryList/addProduct',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: dataString,
        success: function(response){
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });

}

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        placeholder: 'Select one or more products',
        allowClear: true
    });
});

