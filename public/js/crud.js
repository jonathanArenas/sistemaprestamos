function eliminar(numero, description){
	var response = window.confirm("Esta seguro de eliminar a " + description);
	console.log(response);
	
	if (response) {
			document.getElementById("formdelete"+numero).submit();
	}
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
    var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ/ ';//Caracteres validos
  
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
       out += string.charAt(i);
    return out;
}
  
