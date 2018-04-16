var centrosAnalisar=[];

var blur = document.getElementById('blur');
var radius = document.getElementById('radius');

var vector3 = new ol.layer.Heatmap({
  source: new ol.source.Vector({
    //url: 'https://openlayers.org/en/v3.20.1/examples/data/kml/2012_Earthquakes_Mag5.kml',
    url:  'fuente.xml',
    format: new ol.format.KML({
      extractStyles: false
    })
  }),
  blur: parseInt(blur.value, 10),
  radius: parseInt(radius.value, 10)
});


function mostrartodo(){
  alert(centrosAnalisar);
}
var centro = ol.proj.transform([-99.133535800, 19.301996300], 'EPSG:4326', 'EPSG:3857');
    var raster2 = new ol.layer.Tile({
        source: new ol.source.OSM()
      });
      var raster = new ol.layer.Tile({
        source: new ol.source.Stamen({
          layer: 'toner'
        })
      });
      var map = new ol.Map({
        controls: ol.control.defaults().extend([
          new ol.control.FullScreen({
            source: 'fullscreen'
          })
        ]),
        layers: [raster],
        controls: ol.control.defaults({
          attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
            collapsible: false
          })
        }),
        target: document.getElementById('map'),
        view: new ol.View({
          center: centro,
          zoom: 10
        })
      });
      /*var vector1 = new ol.layer.Vector({
              source: new ol.source.Vector({
                url: '../kml/estados.kml',
                format: new ol.format.KML()
                //url:'mapa_municipios_de_mexico.geojson',
                //format: new ol.format.GeoJSON()
              })
          });
      var vector2 = new ol.layer.Vector({
                source: new ol.source.Vector({
                  url: '../kml/municipios_df.kml',
                  format: new ol.format.KML()
                  //url:'mapa_municipios_de_mexico.geojson',
                  //format: new ol.format.GeoJSON()
                })
          });
      map.addLayer(vector1);
      map.addLayer(vector2);*/
function words_nube(valor){
  $.ajax({
    url:'../controladores/afecciones.php',
    type:'POST',
    data:'valor='+valor+'&boton=words_nube'
  }).done(function(resp){
    alert(resp);
    var valores=eval(resp);
    html='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script><script src="jquery.awesomeCloud-0.2.min.js"></script>';
    for (var i = 0; i < valores.length; i++) {
      html+='<span data-weight="'+valores[i]['conteo_afeccion_principal']+'">'+valores[i]['afeccion_principal']+'</span>';
    }
    $("#wordcloud2").html(html);
  });
}
function lugares(valor)
{
        $.ajax({
          url:'../controladores/afecciones.php',
          type:'POST',
          data:'valor='+valor+'&boton=ubicaciones'
        }).done(function(resp){
          var valores=eval(resp);
          for (var i = 0; i < valores.length; i++) {
            longitud=valores[i]["longitud"];
            latitud =valores[i]["latitud"];
            nombre=valores[i]["nombre"];
            direccion=valores[i]["direccion"];
            
          var centro = ol.proj.transform([longitud, parseFloat(latitud)], 'EPSG:4326', 'EPSG:3857');
          
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
              src: 'Antiseptic Cream-50.png'
            }))
          });

          iconFeature.setStyle(iconStyle);

          var vectorSource = new ol.source.Vector({
            features: [iconFeature]
          });

          var vectorLayer = new ol.layer.Vector({
            source: vectorSource
          });
          
          zoomslider = new ol.control.ZoomSlider();
          map.addControl(zoomslider);


          var element = document.getElementById('popup');

          var popup = new ol.Overlay({
            element: element,
            positioning: 'bottom-center',
            stopEvent: false,
            offset: [0, -50]
          });
          map.addOverlay(popup);
          map.addLayer(vectorLayer);

        }
        // display popup on click
          map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel,
                function(feature) {
                  return feature;
                });
            if (feature) {
              var coordinates = feature.getGeometry().getCoordinates();
              popup.setPosition(coordinates);
              $(element).popover({
                'placement': 'top',
                'html': true,
                'content': feature.get('name')
              });
              var place =feature.get('name');
              centrosAnalisar.push(place);
              alert(feature.get('name'));////////////////////////////////////////////////////alert
              //$(element).popover('show');
            } else {
              $(element).popover('destroy');
            }
          });

          // change mouse cursor when over marker
          map.on('pointermove', function(e) {
            if (e.dragging) {
              $(element).popover('destroy');
              return;
            }
            var pixel = map.getEventPixel(e.originalEvent);
            var hit = map.hasFeatureAtPixel(pixel);
            map.getTarget().style.cursor = hit ? 'pointer' : '';
          });
          });
}
function lista_afeccionn(valor)
{
  var element = document.getElementById('fecha').value;
  var res = element.substring(0,10);
  var res2 = element.substring(13,23);
  values= valor.split(',');  
  var datos = values[0]+','+res+','+res2+','+values[2];

  $.ajax({
    url:'../controladores/afecciones.php',
    type:'POST',
    data:'valor='+datos+'&boton=buscar'
  }).done(function(resp){
    var valores=eval(resp);
    html='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"><link rel="stylesheet" href="estilos.css">';
    html+='<table  class="table-striped table-bordered table-hover table-condensed">';
    html+='<tr class="active"><th><button class="btn btn-info btn-lg btn-block" >ENFERMEDAD</button></th><th><button class="btn btn-info btn-lg btn-block">UNIDAD</button></th></tr>';
    for (var i = 0; i < valores.length; i++) {
      html+='<ul class="nav nav-pills nav-stacked"><li class="active"><a href="#"><span class="badge pull-right">'+valores[i]["EGRESO"]+'</span>'+valores[i]["afeccion_principal"]+'</a></li></ul>';
      //html+='<tr title="'+valores[i]["sexo"]+','+valores[i]["EGRESO"]+'" class="success"><td>'+valores[i]["afeccion_principal"]+'</td><td>'+valores[i]["NOMBRE"]+'</td></tr>';
    }
    html+='</table>';
    $("#tabla").html(html);
  });
}
function lista_afeccion(valor)
{

  var element = document.getElementById('fecha').value;
  var res = element.substring(0,10);
  var res2 = element.substring(13,23);
  values= valor.split(',');  
  var datos = values[0]+','+res+','+res2+','+values[2];
  var uno='buscar';
  if (values[2]=='AMBOS') {
    uno='buscar2';
  }
  $.ajax({
    url:'../controladores/afecciones.php',
    type:'POST',
    data:'valor='+datos+'&boton='+uno
  }).done(function(resp){
    alert(resp);
    var valores=eval(resp);
    html='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"><link rel="stylesheet" href="estilos.css">';
    html+='<ul class="list-group">';
    html+='<li class="list-group-item active">ENFERMEDAD</li>';
    for (var i = 0; i < valores.length; i++) {
      html+='<li class="list-group-item" title=" FECHA DE EGRESO: '+valores[i]["egreso"]+'"> <span class="badge">SEXO: '+valores[i]["sexo"]+','+valores[i]["conteo_afeccion_principal"]+' casos</span>'+valores[i]["afeccion_principal"]+'</li>';
    }
    html+='</ul>';
    $("#tabla").html(html);
  });
}