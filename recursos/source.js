// COMIENZA TODO UNA VEZ QUE YA SE CARGO POR COMPLETO EL DOCUMENTO HTML.
$(document).ready(function(){
    //  funcion que actualiza la tabla de informacion.
//  recibe:
//  namefield ->  determina el campo que actualizara.
//  totaldata ->  determina el valor que se asignara.
    function update_table(nameField, totalData){
        if (nameField == 'servicio_egreso') {
            $('#Servicios').text(totalData);
        }
        if (nameField == 'nombre') {
            $('#Unidades').text(totalData);
            var concatValor = [];
            $("#lista_unidades option").each(function(){
                if ($(this).val() != "" ){
                    concatValor.push($(this).text());
                }
            });
            verUnidades(concatValor);
        }
        if (nameField == 'afeccion_principal'){
            $('#Afecciones').text(totalData);
        }
        if (nameField == 'registros'){
            $('#registros').text(totalData);
        }
    }// Termina update_table
    function add_boton_div(name_div, arreglo){
        var html = '';
        for (var i = 0; i < arreglo.length; i++) {
            html += (i+1) + '<button type="button" class="btn btn-link">'+arreglo[i]+'</button> <br>';
        }
        $(name_div).html(html);
    }

//  CONEXION
//  nameField es el nombre del campo que extraego de ls BD
//  elemento es un elemento HTML select
    function con(dataQuery, nameField, elemento){
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            var totalData =  valores.length;
            //  ESTE IF ME PERMITE HACER EL LLENADO DEL SEGUNDO COMBOBOX
            //
            if (nameField == 'tipo_servicio') {
                elemento.length = totalData;
                temp = ['AMBAS ESTANCIAS'];
                for (var i = 0; i < elemento.length; i++) {
                    temp.push(valores[i][nameField]);
                }
                for (var i =0; i < temp.length; i++) {
                    elemento.options[i] =  new Option(temp[i]);
                }
                update_table(nameField, totalData);
            }else {
                elemento.length = totalData;
                for (var i = 0; i < elemento.length; i++) {

                    elemento.options[i] =  new Option(valores[i][nameField]);
                }
                update_table(nameField, totalData);
            }
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
        });
    }
    function conAfeccionRegistros(dataQuery, nameField){
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            for (var i = 0; i < valores.length; i++) {
                cantidad = valores[i][nameField];
                update_table(nameField, cantidad);
                break;
            }
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
        });
    }
    function lugaresServicioEnfermedad(dataQuery, nameField, elemento, namePiramide){
        var data = [];
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            var temp = [];

            elemento.length = valores.length;
            var names = nameField.split(",");

            for (var i = 0; i < valores.length; i++) {
                temp.push(valores[i][names[0]]);
                verUnidades2(valores[i][names[0]]);
                elemento.options[i] =  new Option(valores[i][names[0]]);
                data.push([ valores[i][names[0]] , parseInt(valores[i][names[1]]) ])

            }

            update_table('nombre',valores.length);
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
            crearPiramide(data,namePiramide);
            var concatValor = '';
            $("#lista_unidades option").each(function(){
                if ($(this).val() != "" ){
                    concatValor += "'"+$(this).val()+"',";
                }
            });
            dataQuery = 'valor='+concatValor+'&funcion=getDelegaciones';
            getDelegaciones(dataQuery);
        });
    }

    function ubicacionesServicios(dataQuery, nameField, elemento){
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            var temp = [];
            elemento.length = valores.length;
            for (var i = 0; i < valores.length; i++) {
                temp.push(valores[i][nameField]);
                verUnidades2(valores[i][nameField]);
                elemento.options[i] =  new Option(valores[i][nameField]);
            }
            update_table('nombre',valores.length);
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
            var concatValor = '';
            $("#lista_unidades option").each(function(){
                if ($(this).val() != "" ){
                    concatValor += "'"+$(this).val()+"',";
                }
            });
            dataQuery = 'valor='+concatValor+'&funcion=getDelegaciones';
            getDelegaciones(dataQuery);

        });
    }
    function getDelegaciones(dataQuery){
        //dataQuery = 'valor='n1,n2,n2'+'&funcion=getDelegaciones';
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            /*                          Logica para la identificacion de delegaciones en el mapa por requerimientos.
            map.getLayers().forEach(function(layer) {
                namesDelegaciones.forEach(function (p1, p2, p3) {
                    if (layer.get('name') == p1) {
                        layer.setVisible(false);
                        map.removeLayer(layer);
                    }
                });
            });
            var delegacionesXVer = [], posicionesXVer = [];
            for(var i = 0; i < namesDelegaciones.length; i++){
                for (var j = 0; j < valores.length; j++) {
                    if(namesDelegaciones[i] == valores[j]['delegacion']){
                        delegacionesXVer.push(valores[j]['delegacion']);
                        posicionesXVer.push(i);
                    }
                }
            }
            createFeature2(preDelegaciones,delegacionesXVer, posicionesXVer);
*/
            for(var i = 0; i < delegaciones.length; i++){
                delegaciones[i].setVisible(false);
            }
            for(var i = 0; i < delegaciones.length; i++){
                for (var j = 0; j < valores.length; j++) {
                    if(delegaciones[i].get('name') == valores[j]['delegacion']){
                        delegaciones[i].setVisible(true);
                    }
                }
            }
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
        });
    }
    function conUnidadesDelegaciones(dataQuery, nameField, elemento){
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            var totalData =  valores.length;
            elemento.length = totalData;
            for (var i = 0; i < elemento.length; i++) {
                elemento.options[i] =  new Option(valores[i][nameField]);
            }
            update_table(nameField, totalData);
        }).always(function() {
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
        });
    }
    function limpiarRepetidos(lista, elemento){
        existe = false;
        lista.forEach(function (item){
            if(item.name == elemento.name) {
                existe = true;
                for (var i = 0; i < item.data.length; i++) {
                    item.data[i] += elemento.data[i];
                }
            }
        });
        if (existe)return lista;
        lista.push(elemento);
        return lista;
    }
    function createChart(tema, name, time, data, fecha){
        dataset = {'tema': tema,
            'date': fecha,
            'datos':[]
        };
        var arTemp = [];
        for (var i = 0; i < name.length; i++){
            temp = String(time[i]).split("-");
            ejex = [0,0,0,0,0,0,0,0,0,0,0,0];
            ejex[parseInt(temp[1]-1)] += parseInt(data);
            arTemp.push({"name": name[i], "data": ejex});
        }
        arTemp.forEach(function (item){
            dataset.datos =limpiarRepetidos(dataset.datos, item);
        });
        graficar(dataset);

    }
    function chartData(dataQuery, servicio, fecha){
        var name = [], time = [], data = [];
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            for (var i = 0; i < valores.length; i++) {
                name.push(valores[i]['nombre']);
                time.push(valores[i]['ingre']);
                data.push(valores[i]['total']);
            }
        }).always(function() {
            createChart(servicio,name, time, data, fecha);
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
            $('.bd-example-modal-lg').modal('show');
        });
    }
    function dataChart_afeccion(dataQuery, servicio, fecha){
        var name = [], time = [], data = [];
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            for (var i = 0; i < valores.length; i++) {
                name.push(valores[i]['servicio_egreso']);
                time.push(valores[i]['ingre']);
                data.push(valores[i]['total']);
            }
        }).always(function() {
            createChart(servicio,name, time, data, fecha);
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
            $('.bd-example-modal-lg').modal('show');
        });
    }
    function chartGeneral(dataQuery, servicio, fecha){
        var name = [], enfermedad = [], sexo = [], data = [];
        $.ajax({
            beforeSend: function (){
                $(".statuss").html('<img src="../recursos/imagenes/load2.gif" />');
            },
            url:'../controladores/afecciones.php',
            type:'POST',
            data:dataQuery
        }).done(function(resp){
            var valores=eval(resp);
            for (var i = 0; i < valores.length; i++) {
                name.push(valores[i]['nombre']);
                enfermedad.push(valores[i]['afeccion_principal']);
                sexo.push(valores[i]['sexo']);
                data.push(valores[i]['total']);
            }
            grafoGeneral2(createDescriptionChart(name,enfermedad,sexo,data));
        }).always(function() {
            //createChart(servicio,name, time, data, fecha);
            $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
            $('.bd-example-modal-lg').modal('show');
        });
    }
//  Funcion para actualizar desde el comienzo por medio de la fecha
    function update_data(fecha){
        switch (nivel) {
            case 1:
                dataQuery  = 'valor=unidades|'+fecha+'&funcion='+nivel;
                dataQuery2 = 'valor=servicios|'+fecha+'&funcion='+nivel;


                var elemento = document.getElementById('lista_servicios');
                con(dataQuery2, "servicio_egreso", elemento);

                var elemento = document.getElementById('lista_unidades');
                con(dataQuery, "nombre", elemento);

                dataQuery  = 'valor=afeccion_principal|'+fecha+'&funcion='+nivel;
                var elemento = document.getElementById('lista_afecciones');
                con(dataQuery, "afeccion_principal", elemento);

                /*
                 dataQuery3 = 'valor=afeccion_principal|'+fecha+'&funcion='+nivel;
                 conAfeccionRegistros(dataQuery3,'afeccion_principal');
                 */
                dataQuery3 = 'valor=registros|'+fecha+'&funcion='+nivel;
                conAfeccionRegistros(dataQuery3,'registros');

                break;
        }
    }

//  funcion que me retorna el valor del input de fecha
    function get_dateRange(){
        fecha = $("#fecha").val();
        return fecha;
    }
// funcion de la fecha, en ella especifico la fecha inicial y la fecha final
    $('input[name="daterange"]').daterangepicker(
        {
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: '2009-01-05',//'2009-12-26',
            endDate: '2012-01-01'//'2010-01-01'
        },
        function(start, end, label) {
            nivel = 1;
            update_data(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }
    );
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  comienzo primer nivel
    // actualizacion de la tabla principal
    nivel = 1;
    update_data(get_dateRange());
    // cargamos al mapa
    load_map('map');
    loadDelegacion();
    lugares();

    //  Primer filtro

    //  servicio ingreso / egreso
    $('#select_1').on('change', function() {
        var valor = $(this).find(":selected").val();
        var fecha = get_dateRange();
        nivel = 1.1;
        dataQuery = 'valor='+valor+'|'+fecha+'&funcion='+nivel;
        var elemento = document.getElementById('select_2');
        var nameField = 'tipo_servicio';
        con(dataQuery, nameField, elemento);

        nivel = 1.2;
        dataQuery = 'valor='+valor+'|'+fecha+'&funcion='+nivel;
        var elemento = document.getElementById('lista_servicios');
        con(dataQuery, "servicio_egreso", elemento);
        $('#helpServicio').html("NOMBRES");
    });// termina #select_1

    // estancias || corta / normal
    $('#select_2').on('change', function() {
        var valor = $(this).find(":selected").val();
        var fecha = get_dateRange();
        var egreso = document.getElementById('select_1').value;
        nivel = 1.3;
        dataQuery = 'valor='+valor+'*'+egreso+'|'+fecha+'&funcion='+nivel;
        var elemento = document.getElementById('lista_servicios');
        var nameField1 = 'servicio_egreso';
        con(dataQuery, nameField1, elemento);

        dataQuery = 'valor='+valor+'*'+egreso+'|'+fecha+'&funcion='+1.31;
        elemento = document.getElementById('lista_afecciones');
        con(dataQuery, 'afeccion_principal',elemento);


        nivel = 1.4;
        dataQuery = 'valor='+valor+'|'+fecha+'&funcion='+nivel;
        var elemento = document.getElementById('lista_unidades');
        conUnidadesDelegaciones(dataQuery, "nombre", elemento);

        // numero de registros
        nivel = 1.5;
        dataQuery = 'valor='+valor+'|'+fecha+'&funcion='+nivel;
        conAfeccionRegistros(dataQuery, "registros");

        $('#helpServicio').html("NOMBRES");
    });// termina #select_2

    $("#seleccionCategoryMapa").click(function(event){
        event.preventDefault();
    });
    $('#lista_servicios').dblclick(function () {
        $("#helpafecciones").text("NOMBRES");
        $("#container").show();
        $("#barra").show();
        $("#piramide").hide();
        var valor = $(this).find(":selected").val();
        var fecha = get_dateRange();
        var egreso = document.getElementById('select_1').value;
        var estancia = document.getElementById('select_2').value;


        var a1 = ['Hospital 1','Hospital 1','Hospital 1','Hospital 1','Hospital 2','Hospital 2','Hospital 2','Hospital 2','Hospital 3','Hospital 3','Hospital 3','Hospital 3','Hospital 4','Hospital 4','Hospital 4','Hospital 5','Hospital 5','Hospital 5','Hospital 6','Hospital 7','Hospital 8','Hospital 9','Hospital 10'];
        var a2 = ['enfermedad 1','enfermedad 1','enfermedad 1','enfermedad 2','enfermedad 2','enfermedad 2','enfermedad 2','enfermedad 2','enfermedad 3','enfermedad 3','enfermedad 4','enfermedad 4','enfermedad 4','enfermedad 5','enfermedad 5','enfermedad 5','enfermedad 2','enfermedad 1','enfermedad 1','enfermedad 1','enfermedad 1','enfermedad 1','enfermedad 1'];
        var a3 = ['H','J','M','H','M','M','H','M','H','M','H','M','M','H','M','H','M','M','M','M','M','M','M'];
        var a4 = [1,2,3,6,5,4,2,1,5,3,6,5,12,2,45,3,1,8,8,4,1,4,5];
        //grafoGeneral();           //Muestra el Grafo final
        //grafoGeneral2(createDescriptionChart(a1,a2,a3,a4));
        dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=grafoGeneral';
        chartGeneral(dataQuery, valor, fecha);
        dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=dataChart';
        chartData(dataQuery, valor, fecha);

        dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=ubicacionesServicios';
        elemento = document.getElementById('lista_unidades');
        ubicacionesServicios(dataQuery, "nombre", elemento);

        dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=enfermedadesServicios';
        elemento = document.getElementById('lista_afecciones');
        con(dataQuery, 'afeccion_principal',elemento);

        dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=numRegistros';
        conAfeccionRegistros(dataQuery, 'registros');
        $('#helpServicio').html(valor);
    });
    $("#lista_afecciones").dblclick(function(){
        var fecha = get_dateRange();
        var egreso = document.getElementById('select_1').value;
        var estancia = document.getElementById('select_2').value;

        var SERV = $("#helpServicio").text();
        var valor = $(this).find(":selected").val();
        if (SERV!="NOMBRES"){
            $(".bd-example-modal-sm").modal("show");
            var cont = '<div class="list-group"><a class="list-group-item active" ALIGN=center>POR FAVOR SELECCIONE UNA OPCION</a>';
            cont += '<div class="alert alert-info" role="alert" ALIGN=center><a id="noverr" href="#" class="alert-link"> DESCRIBIR </a> SOLAMENTE A: <strong>'+valor+'</strong> </div>';
            cont += '<div class="alert alert-info" role="alert" ALIGN=center><a id="verr" href="#" class="alert-link"> VER </a> el servicio <strong>'+SERV+'</strong> para <strong>'+valor+'</strong></div>';
            cont += '<DIV ALIGN=center><button type="button" class="btn btn-link" data-dismiss="modal">Close</button></DIV></div>';
            $("#contenedorModalSM").html(cont);
            $("#verr").click(function (event) {
                event.preventDefault();
                $("#helpafecciones").text("NOMBRES");
                $("#container").hide();
                $("#barra").hide();
                $("#piramide").show();
                //$("#contenedorModalLG").html('<div id="piramide" style="min-width: 410px; max-width: 600px; height: 400px; margin: 0 auto"></div>');
                //estancia, enfermedad, egreso/ingreso,  servicio | FECHA
                dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso+ '*' + SERV + '|' + fecha + '&funcion=lugaresServicioEnfermedad';
                elemento = document.getElementById('lista_unidades');
                lugaresServicioEnfermedad(dataQuery, "nombre,total", elemento, valor + " en " +SERV);

                $(".bd-example-modal-lg").modal("show");
                //ubicacionesServicios(dataQuery, "nombre", elemento);
            });
            $("#noverr").click(function (event) {
                $("#container").show();
                $("#barra").show();
                $("#piramide").hide();
                event.preventDefault();
                grafoGeneral();           //Muestra el Grafo final
                dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=dataChart_afeccion';
                dataChart_afeccion(dataQuery, valor, fecha);

                dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=ubicacionesEnfermedades';
                elemento = document.getElementById('lista_unidades');
                ubicacionesServicios(dataQuery, "nombre", elemento);

                dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=servicios_enfermedades';
                elemento = document.getElementById('lista_servicios');
                con(dataQuery, 'servicio_egreso', elemento);

                dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=numRegistros_enfermedades';
                conAfeccionRegistros(dataQuery, 'registros');
            });
        }else {
            $('#helpafecciones').html(valor);
            grafoGeneral();           //Muestra el Grafo final
            dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=dataChart_afeccion';
            dataChart_afeccion(dataQuery, valor, fecha);

            dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=ubicacionesEnfermedades';
            elemento = document.getElementById('lista_unidades');
            ubicacionesServicios(dataQuery, "nombre", elemento);

            dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=servicios_enfermedades';
            elemento = document.getElementById('lista_servicios');
            con(dataQuery, 'servicio_egreso', elemento);

            dataQuery = 'valor=' + estancia + '*' + valor + '*' + egreso + '|' + fecha + '&funcion=numRegistros_enfermedades';
            conAfeccionRegistros(dataQuery, 'registros');
        }
        /*
         $(".bd-example-modal-sm").modal("show");
         $("#contenedorModalSM").html('<div class="list-group"><a href="#" class="list-group-item active">Seleccionar . . .</a><a href="#" id="1" class="optionsSM list-group-item list-group-item-action">Visualizacion por medio del "Mapa". . .</a><a href="#" id="2" class="optionsSM list-group-item list-group-item-action">Visualizacion por medio de "Graficos". . .</a><button type="button" class="btn btn-link" data-dismiss="modal">Close</button></div>');
         $(".optionsSM").click(function(event){
         var option = event.target.id
         event.preventDefault();
         if (option ==  "1"){
         grafoGeneral();           //Muestra el Grafo final
         dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=dataChart';
         chartData(dataQuery, valor, fecha);

         dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=ubicacionesServicios';
         elemento = document.getElementById('lista_unidades');
         ubicacionesServicios(dataQuery, "nombre", elemento);

         dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=enfermedadesServicios';
         elemento = document.getElementById('lista_afecciones');
         con(dataQuery, 'afeccion_principal',elemento);

         dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=numRegistros';
         conAfeccionRegistros(dataQuery, 'registros');
         $(".bd-example-modal-sm").modal("hide");
         }else if (option ==  "2"){
         //$(".bd-example-modal-sm").modal("hide");
         //grafoGeneral();           //Muestra el Grafo final
         //dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=dataChart';
         //chartData(dataQuery, valor, fecha);
         //dataQuery = 'valor='+estancia+'*'+valor+'*'+egreso+'|'+fecha+'&funcion=grafoGeneral';
         //chartGeneral(dataQuery, valor, fecha);
         }
         });*/

        /*
        $("#contenedorModalSM").html('<div class="list-group"><a href="#" class="list-group-item active">Seleccionar . . .</a><a href="#" id="seleccionCategoryEnfermedad1" class="list-group-item list-group-item-action">Ver datos de esta enfermedad respecto a los servicios</a><a href="#" id="seleccionCategoryEnfermedad2" class="seleccionCategoryEnfermedad list-group-item list-group-item-action">Ver solo datos de enfermedad. . .</a></div>');
        $(".bd-example-modal-sm").modal("show");
        var valor = $(this).find(":selected").val();
        $("#seleccionCategoryEnfermedad1").click(function(event){
            event.preventDefault();
        });
        $("#seleccionCategoryEnfermedad2").click(function(event){
            event.preventDefault();
            dataQuery = 'valor='+valor+'|'+fecha+'&funcion=dataChartEnfermedad';
            chartData(dataQuery, valor, fecha);
        });*/
    });
    $("#lista_unidades").dblclick(function(){
        var valor = $(this).find(":selected").val();
        verUnidades2(valor);
        var estancia = document.getElementById('select_2').value;
        var tipoServicio = document.getElementById('select_1').value;
        var fecha = $("#fecha").val();
        var dataQuery = 'valor=' + estancia + '* nombreServicio *' + tipoServicio + '*'+ valor +'*|' + fecha  + '&funcion=mapa3';
        var nombreServicio = "Registros en: "+valor+" en los años "+get_dateRange();
        mapa1(dataQuery, "nombre,total", nombreServicio);
    });

    // llenado de select DELEGACIONES.
    var elemento = document.getElementById('DELEGACIONES');//obtengo el elemento select
    elemento.length = namesDelegaciones.length;
    //  ya que asigne al elemento su tamaño lleno en cada lugar un valor con el for
    for (var i = 0; i < namesDelegaciones.length; i++) {
        elemento.options[i] =  new Option(namesDelegaciones[i]);
    }
    //  Detecto cada cambio en esa lista y mando el valor a la funcion showDelegacion
    $('#DELEGACIONES').on('change', function(){
        for (var i = 0; i < layersUnidades.length; i++) {
            layersUnidades[i].setVisible(false);
        }
        //  showDelegacion  me permite visualizar la delegacion en el mapa
        //  showDelegacion recibe el nombre de la delegacion.
        for (var i = 0; i < namesDelegaciones.length; i++) {
            map.getLayers().forEach(function(layer) {
                if (layer.get("name") == namesDelegaciones[i]){
                    layer.setVisible(false);
                }
            });
        }

        showDelegacion(this.value);
        var estancia = document.getElementById('select_2').value;
        var tipoServicio = document.getElementById('select_1').value;
        var fecha = $("#fecha").val();
        var dataQuery = 'valor=' + estancia + '* nombreServicio *' + tipoServicio + '*'+ this.value +'*|' + fecha  + '&funcion=mapa3';
        var nombreServicio = "Registros en: "+this.value+" en los años "+get_dateRange();
        mapa1(dataQuery, "nombre,total", nombreServicio);
    });

    $('#pruebaModal').click(function(){
        $('.bd-example-modal-lg').modal('show');
    });
    $('#pruebaModalSM').click(function(){
        $('.bd-example-modal-sm').modal('show');
    });

    $("#getLayers").click(function(){
        /*console.log("***********************************************************");
         map.getLayers().forEach(function(layer) {
         console.log("Nombre del layer: ", layer.get('name') + " y estoy visible: " + layer.get('visible'));
         });*/
        location.reload();
    });

});// termina document.ready