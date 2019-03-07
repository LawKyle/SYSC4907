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

        var color = checkFlagged(IDs[i]);

        var value = "<div class='custom-control custom-checkbox'>"
            + "<input type=\"checkbox\" class=\"custom-control-input\" id='listID" + listID + "productID" + IDs[i] + "' value='" + values[i].innerHTML + "' onclick='checkProduct(this);'>"
            + "<label class=\"custom-control-label\" for='listID" + listID + "productID" + IDs[i] + "'>"
            + "<a id='linklistID" + listID + "productID" +  IDs[i] + "' href='/product/" + IDs[i] + "' style='color:color;'> " + values[i].innerHTML + "</a>"
            + "</label>"
            + "</div>"
            + "<button class=\"btn btn-primary pull-right\" onclick=\"deleteProduct(this, 'listID" + listID + "productID" + IDs[i] + "')\"><i class=\"ti-close\"></i></button>";

        data.append(value);
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

function checkFlagged(id) {
    var color = "";
    let dataArray = {};
    dataArray['product_id'] = id;
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/checkFlagged',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: dataString,
        cache: false,
        success: function(data){
            color = JSON.parse(data);
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
    return color;
}

function deleteProduct(obj, id) {
    var listID = id.replace('listID', '').split('p')[0];
    var productID = id.split('productID')[1];
    $(obj).parents("tr").remove();

    let dataArray = {};
    dataArray['list_id'] = listID;
    dataArray['product_id'] = productID;
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/myGroceryList/deleteProduct',
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

$(".custom-control-input").change(function() {
    checkProduct(this);
});

function checkProduct(obj) {
    var id = obj.id.toString();
    var listID = id.replace('listID', '').split('p')[0];
    var productID = id.split('productID')[1];

    if(obj.checked) {
        $("#link" + id).css("text-decoration", "line-through");
    }
    else {
        $("#link" + id).css("text-decoration", "none");
    }
    checkProductAJAX(listID, productID, obj.checked);
}

function checkProductAJAX(listID, productID, check) {
    let dataArray = {};
    dataArray['list_id'] = listID;
    dataArray['product_id'] = productID;
    dataArray['check'] = check;
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/myGroceryList/rmProduct',
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

function restriction(add, ingredient) {
    var name = ingredient;
    if(add) {
        $("#" + name).removeClass('btn-primary-purple');
    }
    else {
        $("#" + name).addClass('btn-primary-purple');
    }
    addRestriction(add, ingredient);
}

function addRestriction(add, ingredient) {
    let dataArray = {};
    dataArray['ingredient'] = ingredient;
    let dataString = "data=" + JSON.stringify(dataArray);

    let url = "/myProfile/rmRestriction";
    if(add) url = "/myProfile/addRestriction";

    $.ajax({
        method: 'POST',
        url: url,
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

function addRestrictions() {
    let ings = $("#restrictions").val();
    let values = $("#restrictions :selected");

    for(let i = 0; i < values.length; i++) {
        let row = $('<tr>');
        let data = $('<td>');
        var insideTD = "<div class='row'><div class='col-md-9'>" + values[i].innerHTML + "</div>"
            + "<div class='col-md-1'><a href='/myProfile/rmRestrictions" + ings[i] +  "' class='btn'><i class='ti-trash'></i></a></div></div>";
        data.append(insideTD);
        row.append(data);
        $("#tableCustom> tbody:last-child").append(row);
    }

    let dataArray = {};
    dataArray['ingredient'] = JSON.stringify(ings);
    let dataString = "data=" + JSON.stringify(dataArray);

    $.ajax({
        method: 'POST',
        url: '/myProfile/addRestrictions',
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

