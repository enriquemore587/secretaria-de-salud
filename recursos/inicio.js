/**
 * Created by enrique on 9/02/17.
 */
var centro, raster, vector1,vector2, map ;
var centrosAnalisar=[];
function unidades_salud(valor){
    $.ajax({
		url:'../controladores/afecciones.php',
		type:'POST',
		data:'valor='+valor+'&boton=unidades_salud'
	}).done(function(resp){
		var valores=eval(resp);
		html = '';
        for (var i = 0; i < valores.length; i++) {
            var temp = valores[i]["unidad"].split(",");
            html += '<button type="button" class="btn_lugar btn btn-link btn-xs" title="' + temp[1] + '" value="' + temp[1] + '">' + temp[0] + '</button>';
        }
		$("#2a").html(html);
        $(".btn_lugar").mouseenter(function(evento){
            //alert($(this).val());
            show_U(centrosAnalisar,$(this).val());
        });
	});
}
function add_Layer(layer){
    map.addLayer(layer);
}
function show_U(arr, name_layers){
    for(var i = 0; i < arr.length; i++){
        if (arr[i].get('name').includes(name_layers) || name_layers.includes(arr[i].get('name'))){
            //alert(2);
            arr[i].setVisible(true);
        } else {
            arr[i].setVisible(false);
        }
    }
    /*arr.forEach(function(layer){
        if (layer.get('name') == name_layers) {

            layer.setVisible(true);
        } else {
            layer.setVisible(false);
        }
    });*/

}
function lugares(valor, icono){
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
              //centrosAnalisar.push(iconFeature.get('name'));
              var iconStyle = new ol.style.Style({
                image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                  anchor: [0.5, 46],
                  anchorXUnits: 'fraction',
                  anchorYUnits: 'pixels',
                  src: icono
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
              centrosAnalisar.push(vectorLayer);
              add_Layer(vectorLayer);
              vectorLayer.setVisible(true);
              }
        });
    //unidades_salud();
}




function inicio(valor){
	$.ajax({
		url:'../controladores/afecciones.php',
		type:'POST',
		data:'valor='+valor+'&boton=inicio'
	}).done(function(resp){
		var valores=eval(resp);
		html='<div class="list-group" STYLE="background: #D8CEF6"><a href="#" class="list-group-item"><h3>DESCRIPCION DE LA INFORMACION<small>UNIDADES DE SALUD</small></h3></a>';
        for (var i = 0; i < valores.length; i++) {
			html+='<a class="list-group-item"><span class="badge">Total de: '+valores[i]["nombre"]+' </span>UNIDADES DE SALUD</a>';
			html+='<a class="list-group-item"><span class="badge">Total de: '+valores[i]["derechohabiencia"]+'</span>DERECHOHABIENCIA</a>';
			html+='<a class="list-group-item"><span class="badge">Total de: '+valores[i]["servicio_ingreso"]+' </span>SERVICIOS</a>';
			html+='<a class="list-group-item"><span class="badge">Total de: '+valores[i]["afeccion_principal"]+' </span>ENFERMEDADES</a>';
			html+='<a class="list-group-item"><span class="badge">Total de: '+valores[i]["causa_externa"]+' </span>CAUSAS EXTERNAS</a>';
		}
		html+='</div>';
		$("#informacion").html(html);
	});
}
function load_map(id) {
    var centro = ol.proj.transform([-99.133535800, 19.301996300], 'EPSG:4326', 'EPSG:3857');
    var raster = new ol.layer.Tile({
        source: new ol.source.Stamen({
            layer: 'toner'
        })
    });
    vector1 = new ol.layer.Vector({
              name: 'estados',
              source: new ol.source.Vector({
                url: '../kml/estados.kml',
                format: new ol.format.KML()
                //url:'mapa_municipios_de_mexico.geojson',
                //format: new ol.format.GeoJSON()
              })
    });
    vector2 = new ol.layer.Vector({
        name: 'municipios',
        source: new ol.source.Vector({
            url: '../kml/municipios_df.kml',
            format: new ol.format.KML()

        })
    });
    map = new ol.Map({
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
        target: document.getElementById(id),
        view: new ol.View({
            center: centro,
            zoom: 9
        })
    });
    add_Layer(vector1);
    add_Layer(vector2);

        var element = document.getElementById('popup');

          var popup = new ol.Overlay({
            element: element,
            positioning: 'bottom-center',
            stopEvent: false,
            offset: [0, -50]
          });
          map.addOverlay(popup);
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
              var place = feature.get('name');
              alert(feature.get('name'));

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
}
$(document).ready(function () {
    inicio();
    load_map('map');
    //lugares('valor', 'Antiseptic Cream-50.png');
});