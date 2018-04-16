 var blur = document.getElementById('blur');
var radius = document.getElementById('radius');

      var vector3 = new ol.layer.Heatmap({
        source: new ol.source.Vector({
          url: 'fuente.xml',
          format: new ol.format.KML({
            extractStyles: false
          })
        }),
        blur: parseInt(blur.value, 10),
        radius: parseInt(radius.value, 10)
      });

      vector3.getSource().on('addfeature', function(event) {
        // 2012_Earthquakes_Mag5.kml stores the magnitude of each earthquake in a
        // standards-violating <magnitude> tag in each Placemark.  We extract it from
        // the Placemark's name instead.
        var name = event.feature.get('name');
        var magnitude = parseFloat(name.substr(2));
        event.feature.set('weight', magnitude - 5);
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
        layers: [raster,vector3],
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


      blur.addEventListener('input', function() {
        vector3.setBlur(parseInt(blur.value, 10));
      });

      radius.addEventListener('input', function() {
        vector3.setRadius(parseInt(radius.value, 10));
      });