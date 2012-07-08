$(function(){
   $("#pdfRetrib").change(function(){
       if(document.getElementById("pdfRetrib").value != 'Sel') {     
       $.ajax({type:"GET", url: "ajax/generarRetribucion.php?fecha="+$("#fechaTareas").val(),
           dataType: "json", 
          success: function(data) {    
              alert(data);
             }           
      });     
     }
     
     else if(document.getElementById("pdfRetrib").value == 'Sel') {
         $('#pdfRetrib').val('Sel').attr('selected',true);
     }
   }); 
});
