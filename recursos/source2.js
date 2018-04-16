function consulta(funcion, valor){
    $.ajax({
		url:'../controladores/afecciones.php',
		type:'POST',
		data:'valor='+valor+'&funcion='+funcion
	}).done(function(resp){
		var valores=eval(resp);
		alert(resp);
		/*html = '';
        for (var i = 0; i < valores.length; i++) {
            var temp = valores[i]["unidad"].split(",");
            html += '<button type="button" class="btn_lugar btn btn-link btn-xs" title="' + temp[1] + '" value="' + temp[1] + '">' + temp[0] + '</button>';
        }
		$("#2a").html(html);
        $(".btn_lugar").mouseenter(function(evento){
            //alert($(this).val());
            show_U(centrosAnalisar,$(this).val());
        });*/
	});
}
function load_map(id) {
    var centro = ol.proj.transform([-99.133535800, 19.301996300], 'EPSG:4326', 'EPSG:3857');
    var raster = new ol.layer.Tile({
        source: new ol.source.OSM()/*new ol.source.Stamen({
            layer: 'toner'
        })*/
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
            zoom: 15//9
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