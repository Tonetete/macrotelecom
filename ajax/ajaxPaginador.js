

// Muestra y ocultación del panel de ingresar tareas

$(document).ready(function(){
  $("#anadirTarea").click(function(){
    $("#formTarea").slideDown();
  });

});


$(document).ready(function(){
  $("#cancelarTarea").click(function(){
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
                    
    $("#datefin").val("");
    $("#dateini").val("");
    //$(".timepicker_inicio_mod").timepicker({});                                                                                    
    //$(".timepicker_fin_mod").timepicker({}); //                                                                                   
});


$(document).ready(function(){
    $.ajax({type:"GET", url: "ajax/paginador.php?pag=1", dataType: "json", 
          beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');     
          },
          success: function(data) {            
            var x = data[0].pagUltima;  
            for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
              }
              var datos = data;
              var llamada = function() {resultado(datos);};
              setTimeout(llamada,150);  
             }           
      });
});

$(function() {
   $('.rangoFechas').change(function() {       
       if($("#datefin").val()!="" && $("#dateini").val() != "") {
           if(Date.parse($("#datefin").val()) < Date.parse($("#dateini").val())) {
              alert("La fecha final no puede ser menor que la fecha inicial.");
          }       
          else {             
           $("#fechaTareas option:first-child").first().attr('selected','selected');
           var pag=1;
            
           $.ajax({type:"GET", url: "ajax/paginador.php?pag="+pag+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
            beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {              
              $("#selPagAlto").empty();
              $("#selPagBajo").empty();
              var x = data[0].pagUltima;  
                for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
                }
                $("#selPagBajo").val(pag).attr('selected',true);
                $("#selPagAlto").val(pag).attr('selected',true);  
                var datos = data;
                var llamada = function() {resultado(datos);};
                setTimeout(llamada,150); 
             }           
          });
        }
       }    
   });       
}); 


$(function() {
   $("#limpiarRangoFechas").click(function() { 
       $("#datefin").val("");
       $("#dateini").val("");
      
   }); 
});

// Manejador de eventos que cogerá los valores de los selects para realizar el filtro de búsqueda

$(function() {
    $("#menuOptions > select").change(function() {
         var nombre = $(this).val();
         var fecha=""; var agentes=""; var empleado="";
         var pag=""; var fechaIni=""; var fechaFin="";
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
  
       if($(this).attr('id')=="fechaTareas") {
           $("#datefin").val("");
           $("#dateini").val("");
           
           fechaIni="";
           fechaFin="";
       }
       
       if($("#dateFin").val()!="" && $("#dateIni").val() !="") {
           if(Date.parse($("#dateFin").val()) < Date.parse($("#dateIni").val())) {
              alert("La fecha final no puede ser menor que la fecha inicial.");
          }       
          else {
              fechaIni = $("#dateini").val();
              fechaFin = $("#datefin").val();
         }
       }
       
       
       
       var dataString = "fecha="+fecha+"&agente="+agentes+"&emp="+empleado+"&fechaini="+fechaIni+"&fechafin="+fechaFin; 
       var pag=1;
          if($(this).attr('id')=="selPagAlto"||$(this).attr('id')=="selPagBajo") {
                dataString+="&pag="+$(this).val();
                pag = $(this).val();
          }  
        
      
         $.ajax({type:"GET", url: "ajax/paginador.php", dataType: "json", data: dataString,
             beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {    
              $("#selPagAlto").empty();
              $("#selPagBajo").empty();
              var x = data[0].pagUltima;  
                for (j=1; j<=x; j++ ) {
                $("#selPagAlto").append(new Option(j,j));
                $("#selPagBajo").append(new Option(j,j));
                }
                $("#selPagBajo").val(pag).attr('selected',true);
                $("#selPagAlto").val(pag).attr('selected',true);  
                var datos = data;
                var llamada = function() {resultado(datos);};
                setTimeout(llamada,150);
             }           
      });
    }); 
});



// Correspondiente a las opciones de seguir adelante la página

$(function() {
    $(".firstPag").click(function(){
        $("#selPagAlto option:first-child").first().attr('selected','selected');
        $("#selPagBajo option:first-child").first().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
            beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


// Correspondiente a las opciones de seguir adelante la página

$(function() {
    $(".lastPag").click(function(){
        $("#selPagAlto option:last-child").last().attr('selected','selected');
        $("#selPagBajo option:last-child").last().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
            beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


$(function() {
    $(".sigPag").click(function(){
        $("#selPagAlto option:selected").next().attr('selected','selected');
        $("#selPagBajo option:selected").next().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
            beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


$(function() {
    $(".antPag").click(function(){
        $("#selPagAlto option:selected").prev().attr('selected','selected');
        $("#selPagBajo option:selected").prev().attr('selected','selected');
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
            beforeSend: function() {            
            $("#contenido").html('<div style="height:200px;"><img style="margin-top:20px;position: absolute; left:368px;"src="img/loading.gif"></div>');         
          },
          success: function(data) {              
              resultado(data);  
             }           
      });
    });
});


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
               '<td style="display:none;"><span class="idTarea">'+data[index].idTarea+'</span></td>'+    
               '<td><span class="tipoAgente">'+data[index].TipoAgente+"</span></td>"+
               '<td><span class="nombreAgente">'+data[index].Nombre+'</span></td>'+               
               '<td class="editar"><span class ="fechaTarea">'+data[index].Fecha+'</span><input style="display:none; width: 70px;" class="validate[required,custom[date]] text-input datepickerEdit" type="text" name="date" /></td>'+               
               '<td class="editar"><span class="iniTarea">'+data[index].Inicio+'</span><input style="display:none; width: 70px;" style="display:none; width: 70px;" class="validate[required,custom[hour]] text-input timepickerIniEdit" type="text" style="width: 70px"  value="'+data[index].Inicio+'" /></td>'+               
               '<td class="editar"><span class="finTarea">'+data[index].Fin+'</span><input style="display:none; width: 70px;" style="display:none; width: 70px;" class="validate[required,custom[hour]] text-input timepickerFinEdit" type="text" style="width: 70px"  value="'+data[index].Fin+'" /></td>'+    
               '<td><span class="intervaloTarea">'+data[index].Intervalo+'</span></td>'+               
               '<td class="editar"><span class="tipoTarea">'+data[index].TipoTarea+'</span><select style="display:none; width: 78px" class="tareaEdit">'+optionsTareas+'</select></td>'+               
               '<td class="editar"><span class="unidades">'+data[index].Unidades+'</span><input style="display:none; width: 70px;" style="display:none; width: 70px;" class="text-input unidadesEdit" type="text" style="width: 70px"  value="'+data[index].Unidades+'" /></td>'+               
               '<td><span class="costeTarea">'+data[index].Coste+'</span></td>'+               
               '<td><span class="comisionTarea">'+data[index].Comision+'</span></td>'+                              
               '<td><img class="eliminar" src="img/delete.png" alt="Edit" /></td>'+
               '<td><input type="checkbox" name="delete[]" value="" /></td></tr>');
               
               
               // Seleccionamos la opción por defecto que debe presentar el dropdownlist de tareas
               
               $("#tipo-tarea-select-"+i).val(data[index].idTipoTarea).attr("selected", true);
               
           // Cuando se genera el código al hacer el append se llama después a las funciones JQuery que generen el plugin, en este caso generamos los timepicker después de haber escrito el código del
           // timepicker en Inicio y Fin, si se llaman antes, no funcionarán ya que se llaman a las funciones antes de haber sido generado el código RECUÉRDALO !!!!           
                                                 
               
           i++;
           });
           
           $("#contenido tr").each(function() {
                 $(this).find('.datepickerEdit').datepicker();
                 $(this).find('.datepickerEdit').val($(this).find('.fechaTarea').text());
                 //$(this).effect("highlight", {color: "yellow"}, 1000);
                 $(this).find('.timepickerIniEdit').timepicker({
                   showNowButton: true,
                    showDeselectButton: true, // removes the highlighted time for when the input is empty.
                    showCloseButton: true
                 });                                  
                $(this).find('.timepickerFinEdit').timepicker({
                   showNowButton: true,
                    showDeselectButton: true,                   // removes the highlighted time for when the input is empty.
                    showCloseButton: true
               });
           });
  }
   
}

// Validacion del formulario e inserción de la tarea

$(function(){
    $("#ingresarBoton").click(function(){	
        //alert("Tarea introducida.");
        var ok="";
        $("#formID").validationEngine('attach');
             ok= $("#formID").validationEngine('validate');
                if(ok){
                    var id="";
                    $.ajax({type:"GET",url:"ajax/insertarTareas.php?user="+$("#empleadoTarea").val()+
                            "&fecha="+$("#date").val()+"&horaini="+$("#timepicker_inicio_insertar").val()+
                            "&horafin="+$("#timepicker_fin_insertar").val()+"&tarea="+$("#tareas").val()+
                            "&uni="+$("#unidades").val(), dataType: 'json',
                        success: function(data) {
                            id=data;
                           // Una vez introducido se vuelve a mandar una petición ajax para actualizar el grid
                           $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
                                success: function(data) {              
                                    resultado(data);  
                                   $("#contenido tr").each(function() {                                      
                                       if($(this).find('.idTarea').text()==id) {                                       
                                            $(this).effect("highlight", {color: "yellow"}, 1000);
                                            id="";
                                       }
                                    });    
                                }           
                            });
                        }
                    });
                  
                }      
        
    });
});

// Al hacer click sobre un elemento con la clase 'eliminar' se disparará este evento para
// lanzar el ajax que borrará la tarea específica

$(".eliminar").live('click', function() {
    var fila = $(this).closest("tr");    
    var id_tarea_val = fila.find(".idTarea").text();
    var conf=confirm("¿Está seguro de que quiere borrar la tarea?");
    if(conf==true) {
        var dataString = 'id='+ id_tarea_val;
        $.ajax({type: "GET", url: "ajax/borrarTareas.php", data: dataString,
            success: function() {
               // Una vez borrado se vuelve a mandar una petición ajax para actualizar el grid
            $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
                success: function(data) {              
                     resultado(data);  
             }           
           });                            
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
            $.ajax({type: "GET", url: "ajax/borrarTareas.php", data: dataString});
         }
        });
        $.ajax({type:"GET", url: "ajax/paginador.php?pag="+$("#selPagAlto").val()+"&agente="+$("#tipoAgente").val()+"&fecha="+$("#fechaTareas").val()+"&emp="+$("#empleado").val()+"&fechaini="+$('#dateini').val()+"&fechafin="+$('#datefin').val(), dataType: "json", 
                success: function(data) {              
                        resultado(data);  
             }           
         }); 
      }
    });
});




$(".editar").live('click',function() {    
    var fila = $(this).closest("tr");
    
    fila.find(".fechaTarea").hide();
    fila.find(".iniTarea").hide();
    fila.find(".finTarea").hide();
    fila.find(".tipoTarea").hide();
    fila.find(".unidades").hide();
    
    fila.find(".datepickerEdit").show();
    fila.find(".timepickerIniEdit").show();
    fila.find(".timepickerFinEdit").show();
    fila.find(".tareaEdit").show();
    fila.find(".unidadesEdit").show();
    
    }).live('change',function(e) {
    var fila = $(this).closest("tr");
    
    var id_tarea_val=fila.find(".idTarea").text();
    var fecha_val =  fila.find(".datepickerEdit").val();
    var inicio_val =  fila.find(".timepickerIniEdit").val();
    var fin_val = fila.find(".timepickerFinEdit").val();
    var tipo_tarea_val =fila.find(".tareaEdit option:selected").text();
    var unidades_val = fila.find(".unidadesEdit").val();
    //var id_tarea_val = $("#id-tarea-"+ID).text();
    var coste_val =""; var intervalo_val =""; var comision_val ="";
    
    var fila = $(this).closest("tr");
    

    var dataString = 'id='+ id_tarea_val +'&fecha='+fecha_val+'&inicio='+inicio_val+'&fin='+
    fin_val+'&tarea='+tipo_tarea_val+"&unidades="+unidades_val;
    //alert($(this).closest("tr").find(".fechaTarea").text());
    if(fecha_val.length>0&& inicio_val.length>0 && fin_val.length>0 && tipo_tarea_val.length>0 && unidades_val>=0){
    $.ajax({ type: "GET", url: "ajax/modificarTareas.php", dataType: 'json', data: dataString, cache: false,
        
        success: function(data) {
            $.each(data,function(i,item){
                
                fila.find(".costeTarea").text(data[i].Coste);
                fila.find(".comisionTarea").text(data[i].Comision);
                fila.find(".intervaloTarea").text(data[i].Intervalo);               
            });
        }
       });
       
       fila.find(".fechaTarea").html(fecha_val);
       fila.find(".fechaTarea").show();
       fila.find(".datepickerEdit").hide();
       
       fila.find(".iniTarea").html(inicio_val);
       fila.find(".iniTarea").show();
       fila.find(".timepickerIniEdit").hide();
       
       fila.find(".finTarea").html(fin_val);
       fila.find(".finTarea").show();
       fila.find(".timepickerFinEdit").hide();
       
       fila.find(".tipoTarea").html(tipo_tarea_val);
       fila.find(".tipoTarea").show();
       fila.find(".tareaEdit").hide();
       
       fila.find(".unidades").html(unidades_val);
       fila.find(".unidades").show();
       fila.find(".unidadesEdit").hide();
       
       fila.find(".costeTarea").text(coste_val);
       fila.find(".comisionTarea").text(comision_val);
       fila.find(".intervaloTarea").text(intervalo_val);
    }
    else
    {
       alert('Alguno de los campos no están completos.');
    }
});