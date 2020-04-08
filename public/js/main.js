var timeline = {};
var chart_cases = render_view(timeline, "confirmed", "date", "country-cases-chart", "#f6c23e");
var chart_deaths = render_view(timeline, "deaths", "date", "country-deaths-chart", "#e74a3b");
var chart_recovered = render_view(timeline, "recovered", "date", "country-recoveries-chart", "#1cc88a");

var isWorld = false;


$(document).ready(function () {
    fetchData();

    $('#countrychartdiv').css({
        "display": "none",
        "height": "0%"
    });


    $('#country_list').on("click", ".btnView", function () {

        var country_name = $(this).parent().parent().attr('country');
        var country_capital = $(this).parent().parent().attr('capital');
        var country_flag = $(this).parent().parent().attr('flag');
        var country_population = $(this).parent().parent().attr('population');
        var country_code = $(this).parent().parent().attr('countryCode');
        var cases = $(this).parent().parent().attr('cases');
        var deaths = $(this).parent().parent().attr('deaths');
        var recoveries = $(this).parent().parent().attr('recovered');

        console.log(cases);

        $("#country_cases").html(cases);
        $("#country_deaths").html(deaths);
        $("#country_recovered").html(recoveries);
        $('#country_name').html(country_name);
        $('#capital').html(country_capital);
        $('#population').html(new Intl.NumberFormat().format(country_population));
        $('#flag_img').attr('src', country_flag);

        if (country_name == "United States of America") {
            country_name = "US";
        }

        var country_timeline = timeline[country_name];
        $.each(country_timeline, function (key, value) {
            value['date'] = new Date(value['date']);
        });

        console.log(country_timeline);

        var data = {
            "total_cases": cases,
            "total_deaths": deaths,
            "total_recovered": recoveries
        };

        goToCountry(country_name, country_code, data, country_timeline);

    });
});


$('#back').on("click", function () {

    if (isWorld) {
        $('#toggleView').click();
        $('#toggleView').hide();
    } else {
        $('#toggleView').hide();
    }


    $("#main-row").animate({
        "left": "0%",
        // "opacity":"0"
    }, 500, "swing", function () {
        $("#country_list").css({
            "overflow-y": "auto"
        });
    });

    chart.goHome();

});



function goToCountry(countryName, countrycode, data, country_timeline) {



    $("#country_list").css({
        "overflow-y": "hidden"
    });

    $("#main-row").animate({
        "left": "-100%",
        // "opacity":"0"
    }, 500, "swing", function () {

        setTimeout(function () {

            country_pie = render_pie_chart("country-pie-chart", data);
            chart_cases.data = country_timeline;
            chart_deaths.data = country_timeline;
            chart_recovered.data = country_timeline;

        }, 1000);

    });


    if (isWorld) {
        $('#toggleView').click();
    }

    this.country_name = countryName;
    this.code = countrycode;

    var country = polygonSeries.getPolygonById(countrycode);
    polygonSeries.mapPolygons.each(function (polygon) {
        polygon.isActive = false;

    });

    country.isActive = true;
    chart.zoomToMapObject(country, getZoomLevel(country));


    viewCountry();

}





$('#toggleView').hide();
var selected_countries = new Map();

var chart = am4core.create("worldchartdiv", am4maps.MapChart);
var chart2 = am4core.create("countrychartdiv", am4maps.MapChart);

chart.geodata = am4geodata_worldHigh;

var activeCountryColor = am4core.color("#367B25");

chart.projection = new am4maps.projections.Miller();
chart2.projection = new am4maps.projections.Miller();

var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
polygonSeries.useGeodata = true;
polygonSeries.exclude = ["AQ"];


var polygonSeries2 = chart2.series.push(new am4maps.MapPolygonSeries());
polygonSeries2.useGeodata = true;


polygonSeries.mapPolygons.template.events.on("hit", function (ev) {
    chart.zoomToMapObject(ev.target);
});

polygonSeries2.mapPolygons.template.events.on("hit", function (ev) {
    chart2.zoomToMapObject(ev.target);
});


// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;
polygonTemplate.tooltipText = "{name}";
polygonTemplate.fill = am4core.color("#74B266");


var polygonTemplate2 = polygonSeries2.mapPolygons.template;
polygonTemplate2.tooltipText = "{name}";
polygonTemplate2.fill = am4core.color("#74B266");




// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = am4core.color("#367B25");

var hs2 = polygonTemplate2.states.create("hover");
hs2.properties.fill = am4core.color("#367B25");


var polygonActiveState = polygonTemplate.states.create("active")
polygonActiveState.properties.fill = activeCountryColor;



var polygonActiveState2 = polygonTemplate2.states.create("active")
polygonActiveState2.properties.fill = activeCountryColor;

// var label = chart.chartContainer.createChild(am4core.Label);
// label.text = "franceLow";
var country_name = "";
var code = "";



function getZoomLevel(mapPolygon) {
    var w = mapPolygon.polygon.bbox.width;
    var h = mapPolygon.polygon.bbox.width;
    // change 2 to smaller walue for a more close zoom
    return Math.min(chart.seriesWidth / (w * 1), chart.seriesHeight / (h * 1))
}


function viewCountry() {
    //chart2.goHome();

    $('#toggleView').hide();
    var countryName = camelCase(country_name.toLowerCase());

    if (country_name == "United States of America") {
        countryName = "usa";
    }


    if (!selected_countries.has(code)) {

        dynamicallyLoadScript("https://www.amcharts.com/lib/4/geodata/" + countryName + "Low.js");
        setTimeout(function () {
            //  var chart = am4core.create("chartdiv", am4maps.MapChart);




            try {

                var myvar = eval("am4geodata_" + countryName + "Low");
                chart2.geodata = myvar;
                $('#toggleView').show();
                selected_countries.set(code, code);
            } catch (e) {
                if (e instanceof ReferenceError) {
                    $('#toggleView').hide();
                } else {
                    printError(e, false);
                }
            }

        }, 1000);
    } else {
        $('#toggleView').show();
        var myvar = eval("am4geodata_" + countryName + "Low");
        chart2.geodata = myvar;
    }



}

function dynamicallyLoadScript(url) {
    var script = document.createElement("script");
    script.src = url;
    document.head.appendChild(script);
}

function camelCase(str) {
    return str
        .replace(/\s(.)/g, function (a) {
            return a.toUpperCase();
        })
        .replace(/\s/g, '')
        .replace(/^(.)/, function (b) {
            return b.toLowerCase();
        });
}

var isFirst = true;

$('#toggleView').on('click', function () {


    if (isWorld) {

        $('#toggleView').html("View Map");

        $('#worldchartdiv').css({
            "display": "block",
            "height": "75vh"
        })


        $('#countrychartdiv').css({
            "display": "none",
            "height": "0%"
        })

        isWorld = false;
        chart2.goHome();

    } else {

        $('#toggleView').html("View World")

        $('#worldchartdiv').css({
            "display": "none",
            "height": "0%"
        })

        $('#countrychartdiv').css({
            "display": "block",
            "height": "75vh"
        })


        if (isFirst == false) {
            chart2.goHome();
            //  chart2.zoomIn();
        }

        isFirst = false;
        isWorld = true;
    }

});


// Rendering pie chart

function render_pie_chart(div, data) {
    console.log(data);

    am4core.useTheme(am4themes_animated);
    var pie_chart = am4core.create(div, am4charts.PieChart);
    pie_chart.legend = new am4charts.Legend();
    pie_chart.innerRadius = am4core.percent(40);

    pie_chart.data = [{
        "title": "Cases",
        "value": data['total_cases'],
        "color": am4core.color("#f6c23e")
    }, {
        "title": "Death",
        "value": data['total_deaths'],
        "color": am4core.color("#e74a3b")
    }, {
        "title": "Recovered",
        "value": data['total_recovered'],
        "color": am4core.color("#1cc88a")
    }];

    var pieSeries = pie_chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "value";
    pieSeries.dataFields.category = "title";
    pieSeries.slices.template.propertyFields.fill = "color";
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.strokeWidth = 2;
    pieSeries.slices.template.strokeOpacity = 1;


    pieSeries.labels.template.disabled = true;
    pieSeries.ticks.template.disabled = true;

    return pie_chart;
}


// World cases chart


function render_view(data, left, bottom, div, color) {

    console.log(data);
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create(div, am4charts.XYChart);
    chart.paddingRight = 20;

    // Add data
    chart.data = data;

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.DateAxis());
    categoryAxis.startLocation = 0;
    categoryAxis.endLocation = 1;



    // Create value axis
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.baseValue = 0;

    // Create series
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = left;
    series.dataFields.dateX = bottom;
    series.stroke = am4core.color(color);
    series.strokeWidth = 2;
    series.tensionX = 1;

    // bullet is added because we add tooltip to a bullet for it to change color
    var bullet = series.bullets.push(new am4charts.Bullet());
    bullet.tooltipText = "{valueY}";

    series.tooltip.getFillFromObject = false;
    series.tooltip.background.fill = am4core.color(color);
    series.tooltip.label.fill = am4core.color("#fff");




    // Add scrollbar
    var scrollbarX = new am4charts.XYChartScrollbar();
    scrollbarX.series.push(series);
    chart.scrollbarX = scrollbarX;

    chart.cursor = new am4charts.XYCursor();

    //  console.log(chart);
    return chart;
}



function fetchData() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'GET',
        url: $('meta[name="country_fetch_data_url"]').attr('content'),
        timeout: 30000,
        dataType: 'json',
        success: function (data) {

            timeline = data['country_timeline'];

            console.log(timeline);

            $('.loader').animate({
                "opacity": "0",

            }, 500, "swing", function () {

                $('.loader').css({
                    "display": "none"
                });
                parseWorldDashboard(data['world']);

                $.each(data['world_timeline'], function (key, value) {
                    value['date'] = new Date(value['year']);
                });

                render_pie_chart("piechart", data['world']);
                render_view(data['world_timeline'], "cases", "date", "cases_chart", "#f6c23e");
                render_view(data['world_timeline'], "deaths", "date", "deaths_chart", "#e74a3b");
                render_view(data['world_timeline'], "recovered", "date", "recovered_chart", "#1cc88a");

                var countries = data['countries'];

                $.each(countries, function (key, value) {
                    renderRows(value);
                });

                $('#table').DataTable({
                    "paging": false,
                    "order": [],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }]
                });

            });

            $('.world_main').animate({
                "opacity": "1",
            }, 500, "swing", function () {

                $('.world_main').css({
                    "display": "block"
                });
            });
        },
        error: function (data) {
            $('.loader').html("");
            $('.loader').html("<h1 class = 'error text-danger'> ! </h1> <p class = 'text-danger'> Network Error Occured </p>");
        }
    });
}


function parseWorldDashboard(data) {
    $("#world_total_cases").text(data['total_cases']);
    $("#world_total_deaths").text(data['total_deaths']);
    $("#world_total_recoveries").text(data['total_recovered']);
}


function renderRows(country) {

    var country_name = country['country_name'];

    if (country['country_code'] === "US") {
        country_name = "USA";
    }

    $('#table tbody').append(
        "<tr " +
        "country='" + country['country_name'] + "'" +
        "flag='" + country['flag'] + "'" +
        "capital='" + country['capital'] + "'" +
        "population='" + country['population'] + "'" +
        "countryCode='" + country['country_code'] + "'" +
        "cases='" + country['cases'] + "'" +
        "deaths='" + country['deaths'] + "'" +
        "recovered='" + country['total_recovered'] + "' >" +
        "<td>" +
        country_name +
        "</td>" +
        "<td>" +
        country['cases'] +
        "</td>" +
        "<td class='hide-me'>" +
        country['active_cases'] +
        "</td>" +
        "<td class='hide-me'> " +
        country['deaths'] +
        "</td>" +
        "<td class='hide-me'>" +
        country['total_recovered'] +
        "</td>" +
        "<td>" +
        "<button class='btn btn-success btn-sm btnView'>View</button>" +
        "</td>" +
        "</tr>"
    )
}
