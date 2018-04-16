//
/*
* numMaximo = 7000
*
* Nunidades = 3
*
* unidades = [  a[700,123, 90],
*               b[300, 564,922],
*               c[150, 387,400]
* ]
* */
function genera(numero)
        {
            var numeros=[];
            for (var i = 10; i > 0; i--) {
                numeros.push(numero/i);
            }
            return numeros;
        }
        var unidades = {
        'datos': []
        };
        unidades.datos.push
        (
            {name: 'AVULSION DE OJO',data: [1,50,6,10,20,1,1,2,22,33]}
        );
        unidades.datos.push({name: 'OTRO PESO BAJO AL NACER',data: genera(150)});
        unidades.datos.push({name: 'INFECCION LOCAL DE LA PIEL Y DEL TEJIDO SUBCUTANEO, NO ESPECIFICADA',data: genera(300)});

        function graficar(dataset){
            $(function () {
                Highcharts.chart('barra', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: dataset.tema
                    },
                    subtitle: {
                        text: dataset.date
                    },
                    xAxis: {
                        categories: [
                            'ENERO',
                            'FEBRERO',
                            'MARZO',
                            'ABRIL',
                            'MAYO',
                            'JUNIO',
                            'JULIO',
                            'AGOSTO',
                            'SEPTIEMBRE',
                            'OCTUBRE',
                            'NOVIEMBRE',
                            'DICIEMBRE'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'No. Registros'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y} Registro(s)</b></td></tr>',
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
                    series: dataset.datos
                });
            });
        }
        //graficar(unidades)