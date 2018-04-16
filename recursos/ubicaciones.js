var layersUnidades = [];
function mapa1(dataQuery, nameField, namePiramide){
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

        var names = nameField.split(",");
        for (var i = 0; i < valores.length; i++) {
            data.push([valores[i][names[0]], parseInt(valores[i][names[1]])])
        }
    }).always(function() {
        $(".statuss").html('<img src="../recursos/imagenes/checked.png" />');
        crearPiramide(data,namePiramide);
        $(".bd-example-modal-lg").modal("show");
    });
}
function crearPiramide(data1, name){
    $("#container").hide();
    $("#barra").hide();
    $("#piramide").show();
    Highcharts.chart('piramide', {
        chart: {
            type: 'pyramid'
        },
        title: {
            text: name,
            x: -50
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                },
                center: ['40%', '50%'],
                width: '80%'
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'TOTAL DE REGISTROS',
            data: data1
        }]
    });
}
function lugares(valor)
{
        $.ajax({
          url:'../controladores/afecciones.php',
          type:'POST',
          data:'valor=0&funcion=ubicaciones'
        }).done(function(resp){
          var valores=eval(resp);
          for (var i = 0; i < valores.length; i++) {
            longitud=valores[i]["longitud"];
            latitud =valores[i]["latitud"];
            nombre=valores[i]["nombre"];
            direccion=valores[i]["direccion"];
            
          var centro = ol.proj.transform([parseFloat(longitud), parseFloat(latitud)], 'EPSG:4326', 'EPSG:3857');
          
          var iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(centro),
            name: nombre,
            population: 4000,
            rainfall: 500
          });

          var iconStyle = new ol.style.Style({
            image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
              anchor: [0.5, 46],
              anchorXUnits: 'fraction',
              anchorYUnits: 'pixels',
              src: 'hospital_location.png'
            }))
          });

          iconFeature.setStyle(iconStyle);

          var vectorSource = new ol.source.Vector({
            features: [iconFeature]
          });

          var vectorLayer = new ol.layer.Vector({
            name: nombre,
            source: vectorSource
          });
          /*
          zoomslider = new ol.control.ZoomSlider();
          map.addControl(zoomslider);*/

          map.addLayer(vectorLayer);
          vectorLayer.setVisible(true);
          layersUnidades.push(vectorLayer);
        }
        
});

        // display popup on click
          map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel,
                function(feature, layer) {
                  return layer;
                });
            if (feature) {
              name = feature.get('name');
              if (name != 'estados') {
                if($("#helpServicio").text() != "NOMBRES"){
                  var nombreServicio = $("#helpServicio").text();
                  var estancia = document.getElementById('select_2').value;
                  var tipoServicio = document.getElementById('select_1').value;
                  var fecha = $("#fecha").val();
                  var dataQuery = 'valor=' + estancia + '*' + nombreServicio + '*' + tipoServicio + '*'+ name +'*|' + fecha  + '&funcion=mapa1';
                    mapa1(dataQuery, "nombre,total", nombreServicio);
                }else if($("#helpafecciones").text() != "NOMBRES"){
                    var nombreServicio = $("#helpServicio").text();
                    var estancia = document.getElementById('select_2').value;
                    var tipoServicio = document.getElementById('select_1').value;
                    var enfermedad = document.getElementById('lista_afecciones').value;
                    var fecha = $("#fecha").val();
                    var dataQuery = 'valor=' + estancia + '*'+ enfermedad +'*' + tipoServicio + '*'+ name +'*|' + fecha  + '&funcion=mapa2';
                    mapa1(dataQuery, "nombre,total", "Registros con la enfermedad: ");
                }else{
                    //var nombreServicio = $("#helpServicio").text();
                    var estancia = document.getElementById('select_2').value;
                    var tipoServicio = document.getElementById('select_1').value;
                    var fecha = $("#fecha").val();
                    var dataQuery = 'valor=' + estancia + '* nombreServicio *' + tipoServicio + '*'+ name +'*|' + fecha  + '&funcion=mapa3';
                    mapa1(dataQuery, "nombre,total", "Registros en: "+ name);
                }
              }

            }
          });

          // change mouse cursor when over marker
          map.on('pointermove', function(e) {
            var pixel = map.getEventPixel(e.originalEvent);
            var hit = map.hasFeatureAtPixel(pixel);
            map.getTarget().style.cursor = hit ? 'pointer' : '';
          });
}