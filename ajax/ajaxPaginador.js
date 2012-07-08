

// Muestra y ocultación del panel de ingresar tareas

$(document).ready(function(){
  $("#anadirTarea").click(function(){
      //alert('culo');
    $("#formTarea").slideDown();
  });

});


$(document).ready(function(){
  $("#cancelarTarea").click(function(){
      //alert('culo');
    $("#formTarea").slideUp();
  });

  
});

// Timepicker, plugin para seleccionar la hora y minutos en la tarea


$(document).ready(function() {     
    $(".datepicker").datepicker("option","dateFormat","dd/mm/yy");
    $(".datepicker" ).datepicker('setDate', new Date());
    $('#timepicker_inicio_insertar').timepicker({
                            showLeadingZero: false,
                            showOn: 'both',
                    button: '.timepicker_inicio_button'
                    });                                                                                    
    $('#timepicker_fin_insertar').timepicker({
                            showLeadingZero: false,
                            showOn: 'both',
                    button: '.timepicker_fin_button'
                    });                                                                                                                                                                            
    //$(".timepicker_inicio_mod").timepicker({});                                                                                    
    //$(".timepicker_fin_mod").timepicker({}); //                                                                                   
});


$(document).ready(function(){
    $.ajax({type:"GET", url: "ajax/paginador.php?pag=1", dataType: "json", 
          success: function(data) {            
            var x = data[0].pagUltima;  
            for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
              }
              resultado(data);  
             }           
      });
});



// Manejador de eventos que cogerá los valores de los selects para realizar el filtro de búsqueda

$(function() {
    $("select").change(function() {
         var nombre = $(this).val();
         var fecha=""; var agentes=""; var empleado="";
         var pag="";
         $("#menuOptions select").each(function() {
             if($(this).attr("id")=="fechaTareas") {
                 fecha = $(this).val(); 
             } 
             
             else if($(this).attr("id")=="tipoAgente") {
                 agentes = $(this).val(); 
             }  
             
             else if($(this).attr("id")=="empleado") {
                 empleado = $(this).val(); 
             }            
         });         
       var dataString = "fecha="+fecha+"&agente="+agentes+"&emp="+empleado;  
       $("#selPagAlto option:first-child").first().attr('selected','selected');
       $("#selPagBajo option:first-child").first().attr('selected','selected');
         $.ajax({type:"GET", url: "ajax/paginador.php", dataType: "json", data: dataString,
          success: function(data) {    
              $("#selPagAlto").empty();
              $("#selPagBajo").empty();
              var x = data[0].pagUltima;  
                for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
                }
              resultado(data);  
             }           
      });
    }); 
});


/*$(function(){
   $("#fechaTareas").change(function(){
       //alert('entré');
       $("#selPagAlto option:first-child").first().attr('selected','selected');
        $("#selPagBajo option:first-child").first().attr('selected','selected');
       $.ajax({type:"GET", url: "ajax/paginador.php?pag=1&filt="+$("#tipoAgente").val()+"&fecha="+ $("#fechaTareas").val(),
           dataType: "json", 
          success: function(data) {    
              $("#selPagAlto").empty();
              $("#selPagBajo").empty();
              var x = data[0].pagUltima;  
                for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
                }
              resultado(data);  
             }           
      });     
       
   }); 
});

$(function(){ 
  $("#tipoAgente").change(function(){
      $("#selPagAlto option:first-child").first().attr('selected','selected');
        $("#selPagBajo option:first-child").first().attr('selected','selected');
   $.ajax({type:"GET", url: "ajax/paginador.php?pag=1&filt="+$("#tipoAgente").val()+"&fecha="+ $("#fechaTareas").val(), dataType: "json", 
          success: function(data) {    
              $("#selPagAlto").empty();
              $("#selPagBajo").empty();
              var x = data[0].pagUltima;  
                for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
                }
              resultado(data);  
             }           
      });     
    });
});


$(function() {
    $("#firstUp").click(function(){
        $("#selPagAlto option:first-child").first().attr('selected','selected');
        $("#selPagBajo option:first-child").first().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});

$(function() {
    $("#lastUp").click(function(){
        $("#selPagAlto option:last-child").last().attr('selected','selected');
        $("#selPagBajo option:last-child").last().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


$(function() {
    $("#firstDown").click(function(){
        $("#selPagAlto option:first-child").first().attr('selected','selected');
        $("#selPagBajo option:first-child").first().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


$(function() {
    $("#lastDown").click(function(){
        $("#selPagAlto option:last-child").last().attr('selected','selected');
        $("#selPagBajo option:last-child").last().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});

$(function() {
    $("#sigUp").click(function(){
        $("#selPagAlto option:selected").next().attr('selected','selected');
        $("#selPagBajo option:selected").next().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});

$(function() {
    $("#antUp").click(function(){
        $("#selPagAlto option:selected").prev().attr('selected','selected');
        $("#selPagBajo option:selected").prev().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


$(function() {
    $("#sigDown").click(function(){
        $("#selPagAlto option:selected").next().attr('selected','selected');
        $("#selPagBajo option:selected").next().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});



$(function() {
    $("#antDown").click(function(){
        $("#selPagAlto option:selected").prev().attr('selected','selected');
        $("#selPagBajo option:selected").prev().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});

$(function() {
    $("#selPagAlto").change(function(){
        $("#selPagBajo").val($(this).val()).attr('selected',true);
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$(this).val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});

$(function() {
    $("#selPagBajo").change(function(){
        $("#selPagAlto").val($(this).val()).attr('selected',true);
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$(this).val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});*/

function printTareas(data) {
   var options=""
    $.each(data, function(index,value){
                   options += '<option value="'+data[index].idTarea+'">'+data[index].Nombre+'</option>'; 
                 });
    return options;             
}

function opcionesTareas() {
  
    var options = $.ajax({type:"GET", url: "ajax/tipoTareas.php", dataType: "json", async: false     
                        
      }).responseText;
      
      // La variable a devolver la parseamos a JSON para que adquiera las propiedades de este
      
      return $.parseJSON(options);
}


// Función que imprimirá el contenido de la tabla con nuestros datos

function resultado(data) {
  $('#contenido').html("");
  $('#pdfRetrib').val('Sel').attr('selected',true);
  if((data[0].numRegistros)==0) {
         alert('No hay registros para los filtros seleccionados.');
     }
  else {            
  
  var i=0;
  var clase = "highlight";
  var dataTareas = opcionesTareas();
  var optionsTareas = printTareas(dataTareas);  
  //alert(data);
           $.each(data,function(index,value){
               
               if(i%2==0) clase = "''"; else clase="highlight";
               $("#contenido").append('<tr class="'+clase+'">'+
               '<td style="display:none;"><span class="idTarea" title="'+i+'" id="id-tarea-'+i+'">'+data[index].idTarea+'</span></td>'+    
               '<td><span class="tipoAgente" title="'+i+'" id="tipo-agente-'+i+'"">'+data[index].TipoAgente+"</span></td>"+
               '<td><span class="nombreAgente"title="'+i+'" id="nombre-'+i+'">'+data[index].Nombre+'</span></td>'+               
               '<td class="editar"><span class ="fechaTarea" title="'+i+'" id="fecha-'+i+'">'+data[index].Fecha+'</span><input style="display:none; width: 70px;" class="validate[required,custom[date]] text-input datepickerEdit" type="text" name="date" id="fecha-input-'+i+'" /></td>'+               
               '<td class="editar"><span class="iniTarea" title="'+i+'" id="inicio-'+i+'">'+data[index].Inicio+'</span><input style="display:none; width: 70px;" id="inicio-input-'+i+'" style="display:none; width: 70px;" class="validate[required,custom[hour]] text-input timepickerIniEdit-'+i+'" type="text" style="width: 70px"  value="'+data[index].Inicio+'" /></td>'+               
               '<td class="editar"><span class="finTarea" title="'+i+'" id="fin-'+i+'">'+data[index].Fin+'</span><input style="display:none; width: 70px;" id="fin-input-'+i+'" style="display:none; width: 70px;" class="validate[required,custom[hour]] text-input timepickerFinEdit-'+i+'" type="text" style="width: 70px"  value="'+data[index].Fin+'" /></td>'+    
               '<td><span class="intervaloTarea"title="'+i+'" id="intervalo-'+i+'">'+data[index].Intervalo+'</span></td>'+               
               '<td class="editar"><span class="tipoTarea" title="'+i+'" id="tipo-tarea-'+i+'">'+data[index].TipoTarea+'</span><select style="display:none; width: 78px" id="tipo-tarea-select-'+i+'" class="editbox">'+optionsTareas+'</select></td>'+               
               '<td><span class="costeTarea" title="'+i+'" id="coste-'+i+'">'+data[index].Coste+'</span></td>'+               
               '<td><span class="comisionTarea" title="'+i+'" id="comision-'+i+'">'+data[index].Comision+'</span></td>'+                              
               '<td><img title="'+i+'" class="eliminar" id="deleteTarea-'+i+'" src="img/delete.png" alt="Edit" /></td>'+
               '<td><input title="'+i+'" id="check-borrar-'+i+'" type="checkbox" name="delete[]" value="" /></td></tr>');
               
               
               // Seleccionamos la opción por defecto que debe presentar el dropdownlist de tareas
               
               $("#tipo-tarea-select-"+i).val(data[index].idTipoTarea).attr("selected", true);
               
           // Cuando se genera el código al hacer el append se llama después a las funciones JQuery que generen el plugin, en este caso generamos los timepicker después de haber escrito el código del
           // timepicker en Inicio y Fin, si se llaman antes, no funcionarán ya que se llaman a las funciones antes de haber sido generado el código RECUÉRDALO !!!!           
              
               
           // Establecemos la fecha por defecto la que ya teníamos asignada
               
               //$('.datepickerEdit-'+i).datepicker();
               //$('.datepickerEdit-'+i).val('01/01/2010');
               //$('.datepickerEdit-'+i).datepicker("option","dateFormat","dd/mm/yy");
               //$('.datepickerEdit-'+i).datepicker('setDate', new Date());
               $('.timepickerIniEdit-'+i).timepicker({
                   showNowButton: true,
                    showDeselectButton: true, // removes the highlighted time for when the input is empty.
                    showCloseButton: true
               });                                  
               $('.timepickerFinEdit-'+i).timepicker({
                   showNowButton: true,
                    showDeselectButton: true,                   // removes the highlighted time for when the input is empty.
                    showCloseButton: true
               });                                  
               
           i++;
           });
           
           $("#contenido tr").each(function() {
                 $(this).find('.datepickerEdit').datepicker();
                 $(this).find('.datepickerEdit').val($(this).find('.fechaTarea').text());
                 //$(this).effect("highlight", {color: "yellow"}, 1000);
           });
  }
   
}

// Validacion del formulario e inserción de la tarea

$(function(){
    $("#ingresarBoton").click(function(){	
        alert("Tarea introducida.");
            jQuery("#formID").validationEngine('attach', {            
                onValidationComplete: function(form, status){
                if(status){
                    var id="";
                    $.ajax({type:"GET",url:"ajax/insertarTareas.php?user="+$("#empleado").val()+
                            "&fecha="+$("#date").val()+"&horaini="+$("#timepicker_inicio_insertar").val()+
                            "&horafin="+$("#timepicker_fin_insertar").val()+"&tarea="+$("#tareas").val()+
                            "&uni="+$("#unidades").val(), dataType: 'json',
                        success: function(data) {
                            id=data;
                            //alert(id);
                           // Una vez introducido se vuelve a mandar una petición ajax para actualizar el grid
                           $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
                                success: function(data) {              
                                    resultado(data);  
                                   $("#contenido tr").each(function() {                                      
                                       if($(this).find('.idTarea').text()==id) {                                       
                                            $(this).effect("highlight", {color: "yellow"}, 1000);
                                            //id="";
                                       }
                                    });    
                                }           
                            });
                        }
                    });
                  
                }
            }  
        });
    });
});

// Al hacer click sobre un elemento con la clase 'eliminar' se disparará este evento para
// lanzar el ajax que borrará la tarea específica

$(".eliminar").live('click', function() {
    var ID= $(this).attr("title");
    var id_tarea_val = $("#id-tarea-"+ID).text();
    var conf=confirm("¿Está seguro de que quiere borrar la tarea?");
    if(conf==true) {
        var dataString = 'id='+ id_tarea_val;
        $.ajax({type: "GET", url: "ajax/borrarTareas.php", dataType: 'json', data: dataString,
            success: function() {
                //alert("Tarea borrada.");                            
            }
        });
        // Una vez borrado se vuelve a mandar una petición ajax para actualizar el grid
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
                success: function(data) {              
                     resultado(data);  
             }           
         }); 
    }
    
});


// Procedimiento para borrar todas las tareas que estén seleccionadas

$(function(){
    $(".borrarTodos").click( function(){
    var conf=confirm("¿Está seguro de que quiere eliminar las tareas seleccionadas?");
    if(conf==true) {  
        $(':checkbox').each(function () {
        if(this.checked) {
            var idTarea = $(this).closest("tr").find(".idTarea").text();
            var dataString = "id="+idTarea;
            $.ajax({type: "GET", url: "ajax/borrarTareas.php", dataType: 'json', data: dataString ,
                success: function() {
                    
                }
            });
         }
        });
        
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&filt="+
                  $("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val(), dataType: "json", 
                     success: function(data) {              
                           resultado(data);  
                  }           
         }); 
      }
    });
});




$(".editar").live('click',function() {
    var ID=$(this).find("span").attr("title");
    $("#fecha-"+ID).hide();
    $("#inicio-"+ID).hide();
    $("#fin-"+ID).hide();
    $("#tipo-tarea-"+ID).hide();
    
    $("#fecha-input-"+ID).show();
    $("#inicio-input-"+ID).show();
    $("#fin-input-"+ID).show();
    $("#tipo-tarea-select-"+ID).show();
    }).live('change',function(e) {
    var ID=$(this).find("span").attr('title');
    var fecha_val =$("#fecha-input-"+ID).val();
    var inicio_val =$("#inicio-input-"+ID).val();
    var fin_val =$("#fin-input-"+ID).val();
    var tipo_tarea_val =$("#tipo-tarea-select-"+ID+" option:selected").text();//New record
    var id_tarea_val = $("#id-tarea-"+ID).text();
    

    var dataString = 'id='+ id_tarea_val +'&fecha='+fecha_val+'&inicio='+inicio_val+'&fin='+
    fin_val+'&tarea='+tipo_tarea_val;

    if(fecha_val.length>0&& inicio_val.length>0 && fin_val.length>0 && tipo_tarea_val.length>0){
    $.ajax({
        type: "GET",
        url: "ajax/modificarTareas.php",
        dataType: 'json',
        data: dataString,
        cache: false,
        beforeSend: function() {
        $("#fecha-"+ID).html(fecha_val);
        $("#inicio-"+ID).html(inicio_val);
        $("#fin-"+ID).html(fin_val);
        $("#tipo-tarea-"+ID).html(tipo_tarea_val);
        
        $("#fecha-"+ID).show();
        $("#inicio-"+ID).show();
        $("#fin-"+ID).show();
        $("#tipo-tarea-"+ID).show();

        $("#fecha-input-"+ID).hide();
        $("#inicio-input-"+ID).hide();
        $("#fin-input-"+ID).hide();//New record
        $("#tipo-tarea-select-"+ID).hide();//New record
        //e.stopImmediatePropagation();
        },
        success: function(data) {
            $.each(data,function(i,item){                
                $("#intervalo-"+ID).text(data[i].Intervalo);
                $("#coste-"+ID).text(data[i].Coste);
                $("#comision-"+ID).text(data[i].Comision);
            });
        }
       });
    }
    else
    {
       alert('Alguno de los campos no están completos.');
    }
});