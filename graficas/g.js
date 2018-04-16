
	// Layers
	var layer = new ol.layer.Tile({ source: new ol.source.Stamen({ layer: 'toner' }) });
	var centro = ol.proj.transform([-99.133535800, 19.431996300], 'EPSG:4326', 'EPSG:3857');
	// The map
	var map = new ol.Map
		({	target: 'map',
			view: new ol.View
			({	zoom: 10,
				center: centro
			}),
			layers: [layer]
		});

	// ol.style.Chart
	var animation=false;
	var styleCache={};

	//alert(dato[2]['name_u']);
	function getFeatureStyle (feature, sel)
	{
		var k = $("#graph").val()+"-"+ $("#color").val()+"-"+(sel?"1-":"")+feature.get("data");
		var style = styleCache[k];
		if (!style)
		{	var radius = 15;
			// area proportional to data size: s=PI*r^2
			if ($("#graph").val()!="bar")
			{	radius = 8* Math.sqrt (feature.get("size") / Math.PI);
			}
			// Create chart style
			var c = $("#color").val();
			styleCache[k] = style = new ol.style.Style(
			{	image: new ol.style.Chart(
				{	type: $("#graph").val(),
					radius: (sel?1.2:1)*radius, 
					offsetY: $("#graph").val()=='pie' ? 0 : (sel?-1.2:-1)*feature.get("radius"),
					data: feature.get("data") || [10,30,20],
					colors: /,/.test(c) ? c.split(",") : c,
					rotateWithView: true,
					animation: animation,
					stroke: new ol.style.Stroke(
					{	color: $("#color").val()!="neon" ? "#fff":"#000",
						width: 2
					}),
				})
			});
		}
		style.getImage().setAnimation(animation);
		return [style];
	}


	// 30 random features with data: array of 4 values
	var ext = map.getView().calculateExtent(map.getSize());
	var features=[];
	var vector;
	function createFeatures(n_features){
		for (var i=0; i<n_features; ++i)
		{
		    var centro = ol.proj.transform([dato[i]['lon'], dato[i]['lat']], 'EPSG:4326', 'EPSG:3857');

			var n, nb=0, data=[];
			for (var k=0; k< dato[i]['valores'].length; k++)
			{
			    n = Math.round(10*Math.random());
				data.push(dato[i]['valores'][k]);
				nb += n;
			}
			features[i] = new ol.Feature(
				{	geometry: new ol.geom.Point(centro),    //  ubicacion
					data: data, //  dato por elemento
					size: 10   //  numero de elementos
				});
		}
		vector = new ol.layer.Vector(
		{	name: 'Vecteur',
			source: new ol.source.Vector({ features: features }),
			// y ordering
			renderOrder: ol.ordering.yOrdering(),
			style: function(f) { return getFeatureStyle(f); }
		})

		map.addLayer(vector);
	}
	var dato =[
		{'name_u': 'HOSPITAL PEDIATRICO AZCAPOTZALCO', 'lon': -99.1335358, 'lat': 19.4319963,'valores': [200,130,140,250]},
		{'name_u': 'HOSPITAL DE ESPECIALIDADES DR. BELISARIO DOMINGUEZ', 'lon': -99.06634550000001, 'lat': 19.3066971,'valores': [190,130,140,150]},
		{'name_u': 'CLINICA HOSPITAL DE ESPECIALIDADES TOXICOLOGICAS VENUSTIANO CARRANZA', 'lon': -99.06787489999999, 'lat': 19.4209332,'valores': [520,130,140,150]},
		{'name_u': 'HOSPITAL DE LA MUJER', 'lon': -99.17078240000001, 'lat': 19.450989, 'valores': [120,130,140,150]},
	];
    createFeatures(dato.length);
    dato[0]['nuevo_elemento'] = 10;
    alert(dato[0]);


	// Control Select 
	var select = new ol.interaction.Select({
            style: function(f) { return getFeatureStyle(f, true); }
          });
	map.addInteraction(select);

	select.getFeatures().on(['add','remove'], function(e)
	{	if (e.type=="add") $("#select").html("Selection data: "+e.element.get("data").toString());
		else $("#select").html("No selection");
	})
	// Animate function
	var listenerKey;
	function doAnimate()
	{	if (listenerKey) return;
		var start = new Date().getTime();
		var duration = 1000;
		animation = 0;
		listenerKey = vector.on('precompose', function(event)
		{	var frameState = event.frameState;
			var elapsed = frameState.time - start;
			if (elapsed > duration) 
			{	ol.Observable.unByKey(listenerKey);
				listenerKey = null;
				animation = false;
			}	
			else
			{	animation = ol.easing.easeOut (elapsed / duration);
				frameState.animate = true;
			}
			vector.changed();
		});
		// Force redraw
		vector.changed();
		//map.renderSync();
	}

	doAnimate();