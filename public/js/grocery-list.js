function editName(listID) {
    alert(listID);
    let oldName = $("#title" + listID).html().trim();
    alert(oldName);
    let inputText = " <input type=\"text\" class=\"form-control\" name=\"inputName\" + listID + \" id=\"inputName" + listID + "\" value='"+ oldName + "'>" +
        "  <button type=\"button\" onclick='editNameAjax(" + listID + ")' class=\"btn btn-primary mb-2\">OK</button>\n";

    $("#divList" + listID).html(inputText);
}

function editNameAjax(listID) {
    let newName = $('#inputName' + listID).val();
    let returnToTitle = "<h4 id=\"title" + listID + " class=\"title\">" + newName + "</h4>";
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

function addProduct(listID, products) {
    alert(products);
    let inputText = " <input type=\"text\" class=\"form-control\" name=\"inputName\" + listID + \" id=\"inputName" + listID + "\">" +
        "  <button type=\"button\" onclick='editNameAjax(" + listID + ")' class=\"btn btn-primary mb-2\">OK</button>\n";
    $("#table" + listID + "> tbody:last-child").append('<tr><td>' + inputText + '</td></tr>');
}
