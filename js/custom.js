function clearBox(elementID) {
    $(elementID).empty();
}

function ShowIMG(waarde) {
    $(document).ready(function () {
        $("#placehere img:last-child").remove();
        $('#placehere').prepend('<img id="cat' + waarde + '" src="images/menucat' + waarde + '.jpg" />');
    })
}
//onderstaande functie kan gebruikt worden om te kijken of twee wachtwoorden overeenkomen.
String.prototype.isEmpty = function () {
    return (this.length === 0 || !this.trim());
};

function checkPassAcc() {
    var accpass1 = document.getElementById('accwachtwoord1');
    var accpass2 = document.getElementById('accwachtwoord2');
    var accmessage = document.getElementById('accconfirmMessage');
    var accgoodColor = "#66cc66";
    var accbadColor = "#ff6666";
    if (accpass1.value == accpass2.value) {
        accpass2.style.backgroundColor = accgoodColor;
        accmessage.style.color = accgoodColor;
        accmessage.innerHTML = "Wachtwoorden komen overeen!"
    } else {
        accpass2.style.backgroundColor = accbadColor;
        accmessage.style.color = badColor;
        accmessage.innerHTML = "Wachtwoorden komen niet overeen, heeft u een typfout gemaakt?"
    }
}
//voor registratieformulier
function checkPass() {
    var pass1 = document.getElementById('wachtwoord1');
    var pass2 = document.getElementById('wachtwoord2');
    var message = document.getElementById('confirmMessage');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    if (pass1.value == pass2.value) {
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Wachtwoorden komen overeen!"
    } else {
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Wachtwoorden komen niet overeen, heeft u een typfout gemaakt?"
    }
}

function showProductsMenu(str) {


    if (str == "") {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("tablecontainermenu").innerHTML = xmlhttp.responseText;
                var oTable = $('tablecontainermenu').dataTable({"sPaginationType": "full_numbers"});
                var rows = oTable.fnGetNodes();
                {
                    oTable.fnUpdate('X', rows[i], 4);
                }
            }
        };
        xmlhttp.open("GET", "tabledatamenu/tabledatamenu.php?catID=" + str, true);
        xmlhttp.send();


    } else {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            i = 0;
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("tablecontainermenu").innerHTML = xmlhttp.responseText;
                var oTable = $('tablecontainermenu').dataTable({"sPaginationType": "full_numbers"});
                var rows = oTable.fnGetNodes();
                {
                    oTable.fnUpdate('X', rows[i], 4);
                }
            }
        };
        xmlhttp.open("GET", "tabledatamenu/tabledatamenu.php?catID=" + str, true);
        xmlhttp.send();


    }
}
//onderstaande zoekfunctie voor tabellen
function doSearch() {
    var searchText = document.getElementById('search').value;
    var targetTable = document.getElementById('producttable');
    var targetTableColCount;

    for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
        var rowData = '';
        if (rowIndex == 0) {
            targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
            continue;
        }
        for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
            rowData += targetTable.rows.item(rowIndex).cells.item(colIndex).textContent;
        }
        if (rowData.toUpperCase().indexOf(searchText.toUpperCase()) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';
    }
}

$('#myModalToev').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var productid = button.data('productid');
    var productname = button.data('productname');
    var productbaseprice = button.data('product-price');
    clearBox("#verwijderbare_toevoegingen");
    clearBox("#toevoegbare_toevoegingen");
    clearBox("#radio_toevoegingen");
    clearBox("#amount");
    clearBox("#aantalproducten");
    clearBox("#prodid");
    clearBox("#prodname");
    var postData = {
        'productid': productid
    };
    var url = "toevoegingen_ophalen.php";
    var modal = $(this);
    modal.find('#prodid').append('<input type="hidden" id="product_id" name="productid" value="' + productid + '">');
    modal.find('#prodname').append(productname);
    modal.find('#amount').append(productbaseprice);
    modal.find('#aantalproducten').val(1);
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (typeof data['removable'] != 'undefined' && data['removable'] instanceof Array) {
                for (index = 0; index < data['removable'].length; ++index) {
                    modal.find('#verwijderbare_toevoegingen').append("<label><div><input type='checkbox' style='width: 15px;' name='removable' id='removable' " +
                        "value='" + data['removable'][index].removalid + "' data-price='0' align='left' checked>" + " " + data['removable'][index].name + "</div></label><br>");
                }
            } else {
                modal.find('#verwijderbare_toevoegingen').append('<i>Er zijn geen verwijderbare keuzes voor dit product.</i>');
            }
            if (typeof data['addable'] != 'undefined' && data['addable'] instanceof Array) {
                for (index = 0; index < data['addable'].length; ++index) {

                    modal.find('#toevoegbare_toevoegingen').append("<label><div><input type='checkbox' style='width: 15px;' name='addable' id='addable' " +
                        "value='" + data['addable'][index].additionid + "' data-price='" + " " + data['addable'][index].price + "'> " +
                        data['addable'][index].name + data['addable'][index].formattedprice + "</div></label><br>");
                }
            } else {
                modal.find('#toevoegbare_toevoegingen').append('<i>Er zijn geen toevoegingen voor dit product.</i>');
            }
            if (typeof data['radio'] != 'undefined' && data['radio'] instanceof Array) {
                for (index = 0; index < data['radio'].length; ++index) {
                    modal.find('#radio_toevoegingen').append("<p><b>" + data['radio'][index].groupname + "</b></p>");
                    for (index2 = 0; index2 < (countInObject(data['radio'][index]) - 1); ++index2) {
                        if (index2 == 0) {
                            modal.find('#radio_toevoegingen').append("<label><div><input type='radio' checked='checked' style='width: 15px;' name='radio" + (index + 1) + "' id='radio' data-price='0' " +
                                "value='" + data['radio'][index][index2].radioid + "'>" + " " + data['radio'][index][index2].name + "</div></label><br>");
                        } else {
                            modal.find('#radio_toevoegingen').append("<label><div><input type='radio' style='width: 15px;' name='radio" + (index + 1) + "' id='radio' data-price='0' " +
                                "value='" + data['radio'][index][index2].radioid + "'>" + " " + data['radio'][index][index2].name + "</div></label><br>");
                        }
                    }
                    modal.find('#radio_toevoegingen').append("<br>");
                }
            } else {
                modal.find('#radio_toevoegingen').append('<i>Er zijn geen opties voor dit product.</i>');
            }
        }
    });
});

function countInObject(obj) {
    var count = 0;
    // iterate over properties, increment if a non-prototype property
    for (var key in obj) if (obj.hasOwnProperty(key)) count++;
    return count;
}

//
function buttonreferral(bref) {
    showProductsMenu(bref);
    ShowIMG(bref);
}

$('button.removalproduct').on("click", removeProduct);

function removeProduct() {
    var dataofbutton = $(this).data('sessid');
    var postData = {
        'deleteproductfromcart': dataofbutton
    };
    url = 'shopping_cart_session.php';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "text",
        success: function (data) {
            clearBox('#shoppingcart-container');
            $('#shoppingcart-container').html(data);
            $('button.removalproduct').on("click", removeProduct);
        }
    });
}
