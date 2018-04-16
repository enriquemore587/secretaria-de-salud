    var unidad;
    function buscarHospitales(valor)
    {
        alert('a');
        $.ajax({
            url:'../controladores/afecciones.php',
            type:'POST',
            data:'valor='+valor+'&boton=hospital'
        }).done(function(resp){
            alert(resp);
            var valores=eval(resp);
            hacer(valores);
            var afecion="";
            var unidad="";
            var conteo="";
            for (var i = 0; i < valores.length; i++) {
                if (i== valores.length-1) {
                    afecion+=valores[i]["affecion_principal"];
                    unidad +=valores[i]["nombre"];
                    conteo+=valores[i]["conteo_nombre_afeccion_principal"];
                    break;
                }
                afecion+=valores[i]["affecion_principal"]+",";
                unidad +=valores[i]["nombre"]+",";
                conteo+=valores[i]["conteo_nombre_afeccion_principal"]+",";
            }
            var categorias =afecion.split(",");
            var categorias_unidad =unidad.split(",");
            alert(conteo);
            
            $(function()
        {
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'UNIDADES DE SALUD'
                },
                subtitle: {
                    text: 'CIUDAD DE MEXICO'
                },
                xAxis: {
                    categories: categorias,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Rainfall (mm)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: categorias_unidad[0],
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                }, {
                    name: categorias_unidad[1],
                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                }, {
                    name: categorias_unidad[2],
                    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                }, {
                    name: categorias_unidad[3],
                    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

                },{
                    name: categorias_unidad[4],
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                }]
                
            });
        });



        });
    }
    