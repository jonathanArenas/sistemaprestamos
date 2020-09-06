

function eliminar(numero, description){
    let id = document.getElementById("modal-destroy");
    cleanAllNodosById(id);
    let modalFade = document.createElement("div");
    modalFade.className = "modal fade";
    modalFade.id = "destroyElement";
    modalFade.setAttribute("tabindex", "-1");
    modalFade.setAttribute("role", "dialog");
    modalFade.setAttribute("aria-labelledby", "ModalLabel");
    modalFade.setAttribute("aria-hidden", "true");
   
    let modalDialog = document.createElement("div")
    modalDialog.className = "modal-dialog modal-dialog-centered modal-sm";
    modalDialog.setAttribute("role", "documet");

    let modalContent  = document.createElement("div");
    modalContent.className = "modal-content";
    
    let modalHeader = document.createElement("div");
    let buttonHidden = document.createElement("button");
    modalHeader.className="modal-header";
    buttonHidden.type = "button";
    buttonHidden.className="close";
    buttonHidden.setAttribute("data-dismiss","modal");
    buttonHidden.setAttribute("aria-label", "close");
    modalHeader.appendChild(buttonHidden);

    let modalBody = document.createElement("div");
    let p = document.createElement("p");
    modalBody.className = "modal-body";
    p.innerHTML = `Estas seguro de eliminar este registro, ${description}`
    modalBody.appendChild(p);

    let modalFooter = document.createElement("div");
    let buttonYes = document.createElement("button");
    let buttonNo = document.createElement("button");

    modalFooter.className= "modal-footer";
    buttonYes.type = "button";
    buttonYes.className = "btn btn-secondary";
    buttonYes.setAttribute("onclick", "destroy("+numero+")");
    buttonYes.innerHTML = "SI";
    buttonNo.type = "button";
    buttonNo.className = "btn btn-primary float-rigth";
    buttonNo.setAttribute("data-dismiss", "modal");
    buttonNo.innerHTML = "NO";
    modalFooter.appendChild(buttonYes);
    modalFooter.appendChild(buttonNo);

    modalContent.appendChild(modalHeader);
    modalContent.appendChild(modalBody);
    modalContent.appendChild(modalFooter);
    modalDialog.appendChild(modalContent);
    modalFade.appendChild(modalDialog);
    id.appendChild(modalFade);
    $('#destroyElement').modal(); 
}

function destroy(numero){
    document.getElementById("formdelete"+numero).submit();
}


    $(document).ready(function(){
      //Mayusculas
      $('.input').on("keypress", function () {
       $input=$(this);
       setTimeout(function () {
        $input.val($input.val().toUpperCase());
       },50);
      });
  });


function Numbers(e){
    var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
}

function Text(string){//solo letras
    var out = '';
    //Se añaden las letras validas
    var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ/ ';//Caracteres validos
  
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
       out += string.charAt(i);
    return out;
}

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatNumberWithDecimals(n){//solo para miles y dos decimales añadiendo signo
        if(isNaN(n) || n == ""){
            return false;
        }
        let copia = new String(n);
        let array = copia.split(/\./);
        let number = 0;
        if(array.length > 1){
            number = array[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            number += '.'+array[1];

            return '$'+number
        }     
        return '$'+number.toFixed(2);
    }

    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.value;
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.selectionStart;
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = "$" + left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = "$" + input_val;
            
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        
        // send updated string to input
        input.value = input_val;

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input.setSelectionRange(caret_pos, caret_pos);
    }
    
    function load(){
        let load = document.getElementById("load");
        let div = document.createElement("div")
        div.id = "loadRequest";
        let iDiv = document.createElement("i");
        div.className = "overlay d-flex justify-content-center align-items-center";
        iDiv.className = "fas fa-2x fa-sync fa-spin";
        div.appendChild(iDiv);   
        load.appendChild(div);
    }

    function hideLoad(){
        let loadRequest = document.getElementById("loadRequest");
        loadRequest.remove();
        $('#modal-save').modal('hide');
    }

    function eraseNumber(n){
        let number = n.replace(/,+/,'');
        number = parseFloat(number.substr(1));
        return number.toFixed(2);
    }

    function cleanAllNodosById(ident){
        if ( ident.hasChildNodes()){//removemos del content
            while ( ident.childNodes.length >= 1 ){
                ident.removeChild(ident.firstChild );
            }
        }
    }

     function nativeTable(idTable, dataBody){
        if ( idTable.hasChildNodes()){//removemos los nodos de la tabla
            while ( idTable.childNodes.length >= 1 ){
            idTable.removeChild(idTable.firstChild );
            }
        }
        const table = document.createElement("table");
		const tBody = document.createElement("tbody");					
		//HEAD TABLE
		const tHead = document.createElement("thead");
        const rowHead = document.createElement("tr");
        let dataHead = Object.keys(dataBody[0]);
        let sizeDataHead = dataHead.length;
        let sizeDataBody = dataBody.length;
        for (let i = 0; i < sizeDataHead; i++) {
            let cellHead = document.createElement("th"); 
            let textCellHead = document.createTextNode(dataHead[i]);
            cellHead.appendChild(textCellHead);
            rowHead.appendChild(cellHead);   
        }
        tHead.appendChild(rowHead);
        tHead.className = "thead-light";
        for (let i = 0; i < sizeDataBody; i++) {
            let row = document.createElement("tr");
            let dataRow = dataBody[i];
            let sizeDataRow = dataRow.length;
            if(Array.isArray(dataRow)){
                for (let index = 0; index < sizeDataRow; index++) {
                    let cell = document.createElement("td");
                    let textCellBody = document.createTextNode(dataRow[index]);
                    cell.appendChild(textCellBody);
                    row.appendChild(cell);
                } 
            }else{
                for( index in dataRow){
                    let cell = document.createElement("td");
                    let textCellBody = document.createTextNode(dataRow[index]);
                    cell.appendChild(textCellBody);
                    row.appendChild(cell);
                }
            }
            tBody.appendChild(row);  
        }
        table.appendChild(tHead);
        table.appendChild(tBody);
        table.id = "table-pdf";
        table.className = "table table-sm table-hover  text-nowrap";
        idTable.appendChild(table);
    }


    function printme(){
      console.log("g");
      window.print();
    }
 
