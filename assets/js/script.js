/**
 * Created by blues on 7/9/14.
 */
$(document).ready(function(){
    /*
    Chart theme
     */
    Highcharts.theme = {
        colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
            "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
        chart: {
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                stops: [
                    [0, '#2a2a2b'],
                    [1, '#3e3e40']
                ]
            },
            style: {
                fontFamily: "'Unica One', sans-serif"
            },
            plotBorderColor: '#606063'
        },
        title: {
            style: {
                color: '#E0E0E3',
                textTransform: 'uppercase',
                fontSize: '20px'
            }
        },
        subtitle: {
            style: {
                color: '#E0E0E3',
                textTransform: 'uppercase'
            }
        },
        xAxis: {
            gridLineColor: '#707073',
            labels: {
                style: {
                    color: '#E0E0E3'
                }
            },
            lineColor: '#707073',
            minorGridLineColor: '#505053',
            tickColor: '#707073',
            title: {
                style: {
                    color: '#A0A0A3'

                }
            }
        },
        yAxis: {
            gridLineColor: '#707073',
            labels: {
                style: {
                    color: '#E0E0E3'
                }
            },
            lineColor: '#707073',
            minorGridLineColor: '#505053',
            tickColor: '#707073',
            tickWidth: 1,
            title: {
                style: {
                    color: '#A0A0A3'
                }
            }
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.85)',
            style: {
                color: '#F0F0F0'
            }
        },
        plotOptions: {
            series: {
                dataLabels: {
                    color: '#B0B0B3'
                },
                marker: {
                    lineColor: '#333'
                }
            },
            boxplot: {
                fillColor: '#505053'
            },
            candlestick: {
                lineColor: 'white'
            },
            errorbar: {
                color: 'white'
            }
        },
        legend: {
            itemStyle: {
                color: '#E0E0E3'
            },
            itemHoverStyle: {
                color: '#FFF'
            },
            itemHiddenStyle: {
                color: '#606063'
            }
        },
        credits: {
            style: {
                color: '#666'
            }
        },
        labels: {
            style: {
                color: '#707073'
            }
        },

        drilldown: {
            activeAxisLabelStyle: {
                color: '#F0F0F3'
            },
            activeDataLabelStyle: {
                color: '#F0F0F3'
            }
        },

        navigation: {
            buttonOptions: {
                symbolStroke: '#DDDDDD',
                theme: {
                    fill: '#505053'
                }
            }
        },

        // scroll charts
        rangeSelector: {
            buttonTheme: {
                fill: '#505053',
                stroke: '#000000',
                style: {
                    color: '#CCC'
                },
                states: {
                    hover: {
                        fill: '#707073',
                        stroke: '#000000',
                        style: {
                            color: 'white'
                        }
                    },
                    select: {
                        fill: '#000003',
                        stroke: '#000000',
                        style: {
                            color: 'white'
                        }
                    }
                }
            },
            inputBoxBorderColor: '#505053',
            inputStyle: {
                backgroundColor: '#333',
                color: 'silver'
            },
            labelStyle: {
                color: 'silver'
            }
        },

        navigator: {
            handles: {
                backgroundColor: '#666',
                borderColor: '#AAA'
            },
            outlineColor: '#CCC',
            maskFill: 'rgba(255,255,255,0.1)',
            series: {
                color: '#7798BF',
                lineColor: '#A6C7ED'
            },
            xAxis: {
                gridLineColor: '#505053'
            }
        },

        scrollbar: {
            barBackgroundColor: '#808083',
            barBorderColor: '#808083',
            buttonArrowColor: '#CCC',
            buttonBackgroundColor: '#606063',
            buttonBorderColor: '#606063',
            rifleColor: '#FFF',
            trackBackgroundColor: '#404043',
            trackBorderColor: '#404043'
        },

        // special colors for some of the
        legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
        background2: '#505053',
        dataLabelsColor: '#B0B0B3',
        textColor: '#C0C0C0',
        contrastTextColor: '#F0F0F3',
        maskColor: 'rgba(255,255,255,0.3)'
    };
    //Apply the theme
    Highcharts.setOptions(Highcharts.theme);
    /*
    End theme setting
     */

    var char_option = {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Product sale chart',
            x: -20
        },
        subtitle: {
            text: 'Số lượng bán được của sản phẩm theo tháng',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Số lượng'
            },
            allowDecimals: false
        },
        tooltip: {
            valueSuffix: ' sản phẩm'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Product',
            data: []
        }]
    }

    $('.blur-background').hide();
    var oldestYear = 0;
    var oldestMonth = 0;
    var curMonth = 0;
    var curYear = 0;
    var pid = 0;
    $('.stat').click(function(){
        pid = $(this).closest('span').find('.product-id').text();
        $('.blur-background').show();
        $.ajax({
            url: base_url + "admin/stat/get_first_date",
            data: { pro: pid },
            type: "POST",
            dataType: "JSON",
            error: function(error){
                alert(JSON.stringify(error));
            }
        }).done(function(data){
                if(data.status == 'no result'){
                    $('#stat-chart').html('<div class="no-product">Không có dữ liệu cho sản phẩm này!</div>');
                } else {
                    oldestYear = data['year'];
                    oldestMonth = data['month'];
                    dateObj = new Date();
                    curMonth = dateObj.getUTCMonth();
//                    var day = dateObj.getUTCDate();
                    curYear = dateObj.getUTCFullYear();
                    year = curYear;
                    $("#stat-select-month").html('');
                    $("#stat-select-year").html('');
                    while(oldestYear <= year){
                        var o = new Option(year, year);
                        $(o).html(year);
                        $("#stat-select-year").append(o);
                        year--;
                    }
                    var f = curMonth + 1;
                    while(f >= 1){
                        var o = new Option(f, f);
                        $(o).html(f);
                        $("#stat-select-month").append(o);
                        f--;
                    }

                    var day_array = [];
                    for(var i = 1; i <= new Date($("#stat-select-year").val(), $("#stat-select-month").val(), 0).getDate(); i++){
                        day_array.push(i);
                    }

                    var value_array = [];
                    for(var i = 1; i <= new Date($("#stat-select-year").val(), $("#stat-select-month").val(), 0).getDate(); i++){
                        value_array.push(i * 1);
                    }

                    stat_month_ajax(pid, $("#stat-select-year").val(), $("#stat-select-month").val(), day_array);
                }
        });
    });
    $('.stat-close-btn').click(function(){
        $('#stat-chart').html('');
        $('.blur-background').hide();
    });

    function stat_month_ajax(pro, myYear, myMonth, day_array){
        char_option.xAxis['categories'] = day_array;
        $.ajax({
            url: base_url + "admin/stat/get_stat_for_a_month",
            data: { pro: pro, year: myYear, month: myMonth },
            type: "POST",
            error: function(error){
                alert(JSON.stringify(error));
            }
        }).done(function(data_this_month){
                char_option.series[0].data = data_this_month;
                $('#stat-chart').highcharts(char_option);
            });
    };

    $("#stat-select-year").change(function(){
        $("#stat-select-month").html('');
        var chosen = $("#stat-select-year").val();
        var o = new Option('Chọn tháng', 0);
        $("#stat-select-month").append(o);
        if(chosen == oldestYear){
            var f = 12;
            while(oldestMonth <= f){
                var o = new Option(f, f);
                $("#stat-select-month").append(o);
                f--;
            }
        } else if(chosen == curYear){
            var f = curMonth + 1;
            while(f >= 1){
                var o = new Option(f, f);
                $("#stat-select-month").append(o);
                f--;
            }
        } else {
            var f = 12;
            while(f >= 1){
                var o = new Option(f, f);
                $("#stat-select-month").append(o);
                f--;
            }
        }
    })

    $("#stat-select-month").click(function(){
        var day_array = [];
        if($("#stat-select-month").val() == 0){
            $('#stat-chart').html('<div class="no-product">Hãy chọn 1 tháng để xem thống kê</div>');
        } else {
            for(var i = 1; i <= new Date($("#stat-select-year").val(), $("#stat-select-month").val(), 0).getDate(); i++){
                day_array.push(i);
            }
            stat_month_ajax(pid, $("#stat-select-year").val(), $("#stat-select-month").val(), day_array);
        }
    });


});