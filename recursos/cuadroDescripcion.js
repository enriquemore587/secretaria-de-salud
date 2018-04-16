


function grafoGeneral() {
    var data = {
            'hospital 1': {
                'enfermedad 1': {
                    'Injuries': '69.2',
                    'Noncommunicable diseases': '670.5',
                    'Communicable & other Group I': '343.5',
                    'popo': '346.2'
                }
            },
            'Europe': {
                'Germany': {
                    'Injuries': '23.0',
                    'Communicable & other Group I': '21.6',
                    'Noncommunicable diseases': '365.1'
                }
            },
            'Africa': {
                'Niger': {
                    'Injuries': '97.6',
                    'Communicable & other Group I': '740.0',
                    'Noncommunicable diseases': '649.1'
                }
            },
            'Americas': {
                'Mexico': {
                    'Injuries': '63.2',
                    'Communicable & other Group I': '57.0',
                    'Noncommunicable diseases': '468.3'
                }
            },
            'Eastern Mediterranean': {
                'Kuwait': {
                    'Communicable & other Group I': '82.5',
                    'Injuries': '25.4',
                    'Noncommunicable diseases': '406.3'
                }
            },
            'Western Pacific': {
                'Fiji': {
                    'Noncommunicable diseases': '804.0',
                    'Injuries': '64.0',
                    'Communicable & other Group I': '105.2'
                }
            }
        },
        points = [],
        regionP,
        regionVal,
        regionI = 0,
        countryP,
        countryI,
        causeP,
        causeI,
        region,
        country,
        cause,
        causeName = {
            'Communicable & other Group I': 'Communicable diseases',
            'Noncommunicable diseases': 'Non-communicable diseases',
            'Injuries': 'Injuries', 'popo': 'caca'
        };

    for (region in data) {
        if (data.hasOwnProperty(region)) {
            regionVal = 0;
            regionP = {
                id: 'id_' + regionI,
                name: region,
                color: Highcharts.getOptions().colors[regionI]
            };
            countryI = 0;
            for (country in data[region]) {
                if (data[region].hasOwnProperty(country)) {
                    countryP = {
                        id: regionP.id + '_' + countryI,
                        name: country,
                        parent: regionP.id
                    };
                    points.push(countryP);
                    causeI = 0;
                    for (cause in data[region][country]) {
                        if (data[region][country].hasOwnProperty(cause)) {
                            causeP = {
                                id: countryP.id + '_' + causeI,
                                name: causeName[cause],
                                parent: countryP.id,
                                value: Math.round(+data[region][country][cause])
                            };
                            regionVal += causeP.value;
                            points.push(causeP);
                            causeI = causeI + 1;
                        }
                    }
                    countryI = countryI + 1;
                }
            }
            regionP.value = Math.round(regionVal / countryI);
            points.push(regionP);
            regionI = regionI + 1;
        }
    }
    Highcharts.chart('container', {
        series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            allowDrillToNode: true,
            animationLimit: 1000,
            dataLabels: {
                enabled: false
            },
            levelIsConstant: false,
            levels: [{
                level: 1,
                dataLabels: {
                    enabled: true
                },
                borderWidth: 3
            }],
            data: points
        }],
        subtitle: {
            text: 'TESE'
        },
        title: {
            text: 'Salud CDMX'
        }
    });
}
function createDescriptionChart(ar1, ar2, ar3, ar4){
    var diccionarioNames={};
    ar3.forEach(function (p1, p2, p3) {
        var key = p1;
        diccionarioNames[key] = p1;
    });
    //console.log(diccionarioNames);
    var diccionario = {};
    ar1.forEach(function (p1, p2, p3) {
        if(p2 < 570){
            var k1 = p1;
            if (diccionario[k1] == undefined){
                var dic = {};
                var key = ar2[p2];
                var key2 = ar3[p2];

                var subDic = {}
                subDic[key2] = parseInt(ar4[p2]);
                dic[key] = subDic;

                diccionario[k1] = dic;
            }else{
                var k2 = ar2[p2], k3 = ar3[p2];
                if(diccionario[k1][k2] != undefined){
                    if(diccionario[k1][k2][k3] == undefined){
                        diccionario[k1][k2][k3] = parseInt(ar4[p2]);
                    }else {
                        diccionario[k1][k2][k3] += parseInt(ar4[p2]);
                    }
                }else{
                    var subDic = {};
                    subDic[k3] = parseInt(ar4[p2]);
                    diccionario[k1][k2] = subDic;
                }
            }
        }
    });
    return {'data': diccionario, 'names': diccionarioNames};
}
function grafoGeneral2(datas) {
    var data = datas['data'],
        points = [],
        regionP,
        regionVal,
        regionI = 0,
        countryP,
        countryI,
        causeP,
        causeI,
        region,
        country,
        cause,
        causeName = datas['names'];

    for (region in data) {
        if (data.hasOwnProperty(region)) {
            regionVal = 0;
            regionP = {
                id: 'id_' + regionI,
                name: region,
                color: Highcharts.getOptions().colors[regionI]
            };
            countryI = 0;
            for (country in data[region]) {
                if (data[region].hasOwnProperty(country)) {
                    countryP = {
                        id: regionP.id + '_' + countryI,
                        name: country,
                        parent: regionP.id
                    };
                    points.push(countryP);
                    causeI = 0;
                    for (cause in data[region][country]) {
                        if (data[region][country].hasOwnProperty(cause)) {
                            causeP = {
                                id: countryP.id + '_' + causeI,
                                name: causeName[cause],
                                parent: countryP.id,
                                value: Math.round(+data[region][country][cause])
                            };
                            regionVal += causeP.value;
                            points.push(causeP);
                            causeI = causeI + 1;
                        }
                    }
                    countryI = countryI + 1;
                }
            }
            regionP.value = Math.round(regionVal / countryI);
            points.push(regionP);
            regionI = regionI + 1;
        }
    }

    Highcharts.chart('container', {
        series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            allowDrillToNode: true,
            animationLimit: 1000,
            dataLabels: {
                enabled: false
            },
            levelIsConstant: false,
            levels: [{
                level: 1,
                dataLabels: {
                    enabled: true
                },
                borderWidth: 3
            }],
            data: points
        }],
        subtitle: {
            text: 'TESE'
        },
        title: {
            text: 'Salud CDMX'
        }
    });
}
//grafoGeneral2(createDescriptionChart(a1,a2,a3,a4));