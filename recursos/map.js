function load_map(id) 
{
    var centro = ol.proj.transform([-99.133535800, 19.301996300], 'EPSG:4326', 'EPSG:3857');
    var raster2 = new ol.layer.Tile({
        name: 'tema',
        source: new ol.source.OSM()
      });
      var raster = new ol.layer.Tile({
        name: 'tema2',
        source: new ol.source.Stamen({
          layer: 'toner'
        })
      });
      // creando un logo en el mapa para redirigirlo a mi FB.com
    var logoElement = document.createElement('a');
    logoElement.href = 'https://www.facebook.com/mo.re.528';
    logoElement.target = '_blank';

    var logoImage = document.createElement('img');
    logoImage.src = 'tese.ico';

    logoElement.appendChild(logoImage);
    // fin de . . . . . .
    // creando un logo en el mapa para redirigirlo a mi FB.com
    map = new ol.Map({
        controls: ol.control.defaults().extend([
            new ol.control.FullScreen()
        ]),
        layers: [raster2],
        /*controls: ol.control.defaults({
            attributionOptions: /** @type {olx.control.AttributionOptions} */ /*({
                collapsible: false
            })
        }),*/
        target: document.getElementById(id),
        view: new ol.View({
            center: centro,
            zoom: 14
        }),// redireccion de el logo....
        logo: logoElement
    });

    vector1 = new ol.layer.Vector({
              source: new ol.source.Vector({
                url: '../kml/estados.kml',
                format: new ol.format.KML()
                //url:'mapa_municipios_de_mexico.geojson',
                //format: new ol.format.GeoJSON()
              })
          });
    vector1.set('name', 'estados');
    vector2 = new ol.layer.Vector({
                name: 'municipios',
                source: new ol.source.Vector({

                  url: '../kml/muni.kml',
                  format: new ol.format.KML()
                  //url:'mapa_municipios_de_mexico.geojson',
                  //format: new ol.format.GeoJSON()
                })
          });
      map.addLayer(vector1);
      //map.addLayer(vector2);
      var sub11 = new ol.control.Bar  (
        {
          toggleOne: true,
          controls:
          [ new ol.control.TextButton(
              { html:namesDelegaciones[0],
                handleClick: function(b) { showDelegacion(namesDelegaciones[0]);/*info("Button 2.1 clicked"); */} 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[1],
                handleClick: function(b) { showDelegacion(namesDelegaciones[1]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[2],
                handleClick: function(b) { showDelegacion(namesDelegaciones[2]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[3],
                handleClick: function(b) { showDelegacion(namesDelegaciones[3]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[4],
                handleClick: function(b) { showDelegacion(namesDelegaciones[4]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[5],
                handleClick: function(b) { showDelegacion(namesDelegaciones[5]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[6],
                handleClick: function(b) { showDelegacion(namesDelegaciones[6]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[7],
                handleClick: function(b) { showDelegacion(namesDelegaciones[7]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[8],
                handleClick: function(b) { showDelegacion(namesDelegaciones[8]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[9],
                handleClick: function(b) { showDelegacion(namesDelegaciones[9]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[10],
                handleClick: function(b) { showDelegacion(namesDelegaciones[10]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[11],
                handleClick: function(b) { showDelegacion(namesDelegaciones[11]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[12],
                handleClick: function(b) { showDelegacion(namesDelegaciones[12]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[13],
                handleClick: function(b) { showDelegacion(namesDelegaciones[13]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[14],
                handleClick: function(b) { showDelegacion(namesDelegaciones[14]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              { html:namesDelegaciones[15],
                handleClick: function(b) { showDelegacion(namesDelegaciones[15]);/*info("Button 2.2 clicked");*/ } 
              }),
            new ol.control.TextButton(
              {
               html:"------------------------------------------------------------------Todos------------------------------------------------------------------",
                handleClick: function(b) { showDelegacion(0);/*info("Button 2.2 clicked");*/ } 
              })
          ]
        });
      map.addControl ( sub11 );
      sub11.setVisible(false);
}

// funcion para crear cada punto del poligono
// y recibe un arreglo de cordenadas
// retorna el poligono completo
function point(coordenadas){//coordenadas [1231,123123]
  final = [ ];
  for (var i = 0; i < coordenadas.length; i++) {
    var punto = ol.proj.transform(coordenadas[i], 'EPSG:4326', 'EPSG:3857'); 
    final.push(punto);
  }
  return final;
}

function createFeature(arrayDelegaciones){
  
  layersDelegaciones = [];
  for (i = 0; i < arrayDelegaciones.length; i++){
    // obtengo el nombre de la delegacion.
    nombre = namesDelegaciones[i];

    //  creamos el poligono con la conversion que necesita OL3
    //  retorna el poligono creado en forma de arreglo.
    var cordenadasNuevas = point(arrayDelegaciones[i]);

    // creo mi figura geometrica (poligono) recibe cordenadas en formato:
    //  [[x,y],[x,y],[x,y]]  ya transformadas en la funcion point.
    var f = new ol.Feature(
      new ol.geom.Polygon([cordenadasNuevas])
      );
    

    //Creo mi vector con las especificaciones
    var vector = new ol.layer.Image( {
      name: nombre,
      source: new ol.source.ImageVector (
        { 
          source: new ol.source.Vector(),
          style: new ol.style.Style
          (
            {
              stroke: new ol.style.Stroke({ width:4, color:[51,102,153] }),
              fill: new ol.style.Fill({ color:[45,210,255,.4] })
            }
          )
        })
    });

    vector.getSource().getSource().addFeature(f);
    
    //  agrego a mi arreglo un diccionario
    layersDelegaciones.push(vector);
  }
  
  return layersDelegaciones;
}

function createFeature2(arrayDelegaciones, validadas, posicion){////////no borrar amenos de saber que esta realiza el marcado de delegaciones por cant. regist.

    layersDelegaciones = [];
    for (i = 0; i < validadas.length; i++){
        // obtengo el nombre de la delegacion.
        nombre = namesDelegaciones[i];
        //  creamos el poligono con la conversion que necesita OL3
        //  retorna el poligono creado en forma de arreglo.
        var cordenadasNuevas = point(arrayDelegaciones[parseInt(posicion[i])]);

        // creo mi figura geometrica (poligono) recibe cordenadas en formato:
        //  [[x,y],[x,y],[x,y]]  ya transformadas en la funcion point.
        var f = new ol.Feature(
            new ol.geom.Polygon([cordenadasNuevas])
        );


        //Creo mi vector con las especificaciones
        var vector = new ol.layer.Image( {
            name: nombre,
            source: new ol.source.ImageVector (
                {
                    source: new ol.source.Vector(),
                    style: new ol.style.Style
                    (
                        {
                            stroke: new ol.style.Stroke({ width:4, color:[51,102,153] }),
                            fill: new ol.style.Fill({ color:[40,40,153,i*0.09] })
                        }
                    )
                })
        });

        vector.getSource().getSource().addFeature(f);
        map.addLayer(vector);
        vector.setVisible(true);
        //  agrego a mi arreglo un diccionario
        //layersDelegaciones.push(vector);
    }

    //return layersDelegaciones;
}
var preDelegaciones = [figura1, figura2, figura3, figura4, figura5, figura6, figura7, figura8, figura9, figura10, figura11, figura12, figura13, figura14, figura15, figura16];
delegaciones = createFeature(preDelegaciones);

function showDelegacion(name){

  map.getLayers().forEach(function(layer) {
    if (layer.get('name') == name) {
      layer.setVisible(true);
    }
  });
}
function loadDelegacion(){
  for (var i = 0; i < delegaciones.length; i++) {
      map.addLayer(delegaciones[i]);
      delegaciones[i].setVisible(false);
  }

}
function deleteDelegacion(name){
  console.log("***********************************************************");
  map.getLayers().forEach(function(layer) {
    //alert( layer.get('name'));
    if (layer.get("name")==name) {
      console.log("yes");
      map.removeLayer(layer);
    }
    else{
      console.log("Nombre del layer: ", layer.get('name') + " y estoy visible: " + layer.get('visible'));
    }
  });
}

function verUnidades(names){
    for (var i = 0; i < layersUnidades.length; i++) {
        layersUnidades[i].setVisible(false);
    }
    console.log("***********************************************************");
    //names = ['HOSPITAL PEDIATRICO AZCAPOTZALCO', 'HOSPITAL DE LA MUJER'];
    map.getLayers().forEach(function(layer) {
        for (var i = 0; i < names.length; i++) {
            if (names[i] == layer.get("name")) {
                layer.setVisible(true);
                console.log(layer.get("name"));
            }
        }
    });
}

function verUnidades2(unidad){
    for (var i = 0; i < layersUnidades.length; i++) {
        layersUnidades[i].setVisible(false);
    }
    //names = ['HOSPITAL PEDIATRICO AZCAPOTZALCO', 'HOSPITAL DE LA MUJER'];
    map.getLayers().forEach(function(layer) {
            if (unidad == layer.get("name")){
                layer.setVisible(true);
                //alert("existe");
                //console.log("-------------------------------------------------");
                //console.log("se encontro: "+ layer.get("name"));
            }
    });

}
// INICIO PARA DESCARGAR IMAGEN DEL MAPA
document.getElementById('export-png').addEventListener('click', function() {
    map.once('postcompose', function(event) {
        var canvas = event.context.canvas;
        if (navigator.msSaveBlob) {
            navigator.msSaveBlob(canvas.msToBlob(), 'MAPA DE DE SALUD EN LA CDMX.png');
        } else {
            canvas.toBlob(function(blob) {
                saveAs(blob, 'MAPA DE DE SALUD EN LA CDMX.png');
            });
        }
    });
    map.renderSync();
});
// FIN....... PARA DESCARGAR IMAGEN DEL MAPA