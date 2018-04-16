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
            {name: 'AVULSION DE OJO',data: genera(50)},
            {name: 'OTRO PESO BAJO AL NACER',data: genera(90)},
            {name: 'INFECCION LOCAL DE LA PIEL Y DEL TEJIDO SUBCUTANEO, NO ESPECIFICADA',data: genera(170)}
        );

        $(function () {
            Highcharts.chart('linea', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'ENFERMEDADES'
                },
                subtitle: {
                    text: 'CDMX'
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
                        text: 'No. casos'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} egresos</b></td></tr>',
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
                series: unidades.datos
            });
        });