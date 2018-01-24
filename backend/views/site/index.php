<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        if (!$.isFunction($.fn.dxChart))
            $(".dx-warning").removeClass('hidden');
    });
</script>

<script type="text/javascript">
    var sample_notification;

    jQuery(document).ready(function ($)
    {

        // Notifications
        window.clearTimeout(sample_notification);

        var notification = setTimeout(function ()
        {
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right toast-default",
                "toastClass": "black",
                "onclick": null,
                "showDuration": "100",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.info("", "Welcome to Sales Invoice System", opts);
        }, 3800);

        if (!$.isFunction($.fn.dxChart))
            return;

        // Charts
        var xenonPalette = ['#68b828', '#7c38bc', '#0e62c7', '#fcd036', '#4fcdfc', '#00b19d', '#ff6264', '#f7aa47'];

        // Pageviews Visitors Chart
        var i = 0,
                line_chart_data_source = [
                    {id: ++i, part1: 4, part2: 2},
                    {id: ++i, part1: 5, part2: 3},
                    {id: ++i, part1: 5, part2: 3},
                    {id: ++i, part1: 4, part2: 2},
                    {id: ++i, part1: 3, part2: 1},
                    {id: ++i, part1: 3, part2: 2},
                    {id: ++i, part1: 5, part2: 3},
                    {id: ++i, part1: 7, part2: 4},
                    {id: ++i, part1: 9, part2: 5},
                    {id: ++i, part1: 7, part2: 4},
                    {id: ++i, part1: 7, part2: 3},
                    {id: ++i, part1: 11, part2: 6},
                    {id: ++i, part1: 10, part2: 8},
                    {id: ++i, part1: 9, part2: 7},
                    {id: ++i, part1: 8, part2: 7},
                    {id: ++i, part1: 8, part2: 7},
                    {id: ++i, part1: 8, part2: 7},
                    {id: ++i, part1: 8, part2: 6},
                    {id: ++i, part1: 15, part2: 5},
                    {id: ++i, part1: 10, part2: 5},
                    {id: ++i, part1: 9, part2: 6},
                    {id: ++i, part1: 9, part2: 3},
                    {id: ++i, part1: 8, part2: 5},
                    {id: ++i, part1: 8, part2: 4},
                    {id: ++i, part1: 9, part2: 5},
                    {id: ++i, part1: 8, part2: 6},
                    {id: ++i, part1: 8, part2: 5},
                    {id: ++i, part1: 7, part2: 6},
                    {id: ++i, part1: 7, part2: 5},
                    {id: ++i, part1: 6, part2: 5},
                    {id: ++i, part1: 7, part2: 6},
                    {id: ++i, part1: 7, part2: 5},
                    {id: ++i, part1: 8, part2: 5},
                    {id: ++i, part1: 6, part2: 5},
                    {id: ++i, part1: 5, part2: 4},
                    {id: ++i, part1: 5, part2: 3},
                    {id: ++i, part1: 6, part2: 3},
                ];

        $("#pageviews-visitors-chart").dxChart({
            dataSource: line_chart_data_source,
            commonSeriesSettings: {
                argumentField: "id",
                point: {visible: true, size: 5, hoverStyle: {size: 7, border: 0, color: 'inherit'}},
                line: {width: 1, hoverStyle: {width: 1}}
            },
            series: [
                {valueField: "part1", name: "Pageviews", color: "#68b828"},
                {valueField: "part2", name: "Visitors", color: "#eeeeee"},
            ],
            legend: {
                position: 'inside',
                paddingLeftRight: 5
            },
            commonAxisSettings: {
                label: {
                    visible: false
                },
                grid: {
                    visible: true,
                    color: '#f9f9f9'
                }
            },
            valueAxis: {
                max: 25
            },
            argumentAxis: {
                valueMarginsEnabled: false
            },
        });



        // Server Uptime Chart
        var bar1_data_source = [
            {year: 1, europe: 10, americas: 0, africa: 5},
            {year: 2, europe: 20, americas: 5, africa: 15},
            {year: 3, europe: 30, americas: 10, africa: 15},
            {year: 4, europe: 40, americas: 15, africa: 30},
            {year: 5, europe: 30, americas: 10, africa: 20},
            {year: 6, europe: 20, americas: 5, africa: 10},
            {year: 7, europe: 10, americas: 15, africa: 0},
            {year: 8, europe: 20, americas: 25, africa: 8},
            {year: 9, europe: 30, americas: 35, africa: 16},
            {year: 10, europe: 40, americas: 45, africa: 24},
            {year: 11, europe: 50, americas: 40, africa: 32},
        ];

        $("#server-uptime-chart").dxChart({
            dataSource: [
                {id: ++i, sales: 1},
                {id: ++i, sales: 2},
                {id: ++i, sales: 3},
                {id: ++i, sales: 4},
                {id: ++i, sales: 5},
                {id: ++i, sales: 4},
                {id: ++i, sales: 5},
                {id: ++i, sales: 6},
                {id: ++i, sales: 7},
                {id: ++i, sales: 6},
                {id: ++i, sales: 5},
                {id: ++i, sales: 4},
                {id: ++i, sales: 5},
                {id: ++i, sales: 4},
                {id: ++i, sales: 4},
                {id: ++i, sales: 3},
                {id: ++i, sales: 4},
            ],

            series: {
                argumentField: "id",
                valueField: "sales",
                name: "Sales",
                type: "bar",
                color: '#7c38bc'
            },
            commonAxisSettings: {
                label: {
                    visible: false
                },
                grid: {
                    visible: false
                }
            },
            legend: {
                visible: false
            },
            argumentAxis: {
                valueMarginsEnabled: true
            },
            valueAxis: {
                max: 12
            },
            equalBarWidth: {
                width: 11
            }
        });



        // Average Sales Chart
        var doughnut1_data_source = [
            {region: "Asia", val: 4119626293},
            {region: "Africa", val: 1012956064},
            {region: "Northern America", val: 344124520},
            {region: "Latin America and the Caribbean", val: 590946440},
            {region: "Europe", val: 727082222},
            {region: "Oceania", val: 35104756},
            {region: "Oceania 1", val: 727082222},
            {region: "Oceania 3", val: 727082222},
            {region: "Oceania 4", val: 727082222},
            {region: "Oceania 5", val: 727082222},
        ], timer;

        $("#sales-avg-chart div").dxPieChart({
            dataSource: doughnut1_data_source,
            tooltip: {
                enabled: false,
                format: "millions",
                customizeText: function () {
                    return this.argumentText + "<br/>" + this.valueText;
                }
            },
            size: {
                height: 90
            },
            legend: {
                visible: false
            },
            series: [{
                    type: "doughnut",
                    argumentField: "region"
                }],
            palette: ['#5e9b4c', '#6ca959', '#b9f5a6'],
        });



        // Pageview Stats
        $('#pageviews-stats').dxBarGauge({
            startValue: -50,
            endValue: 50,
            baseValue: 0,
            values: [-21.3, 14.8, -30.9, 45.2],
            label: {
                customizeText: function (arg) {
                    return arg.valueText + '%';
                }
            },
            //palette: 'ocean',
            palette: ['#68b828', '#7c38bc', '#0e62c7', '#fcd036', '#4fcdfc', '#00b19d', '#ff6264', '#f7aa47'],
            margin: {
                top: 0
            }
        });

        var firstMonth = {
            dataSource: getFirstMonthViews(),
            argumentField: 'month',
            valueField: '2014',
            type: 'area',
            showMinMax: true,
            lineColor: '#68b828',
            minColor: '#68b828',
            maxColor: '#7c38bc',
            showFirstLast: false,
        },
                secondMonth = {
                    dataSource: getSecondMonthViews(),
                    argumentField: 'month',
                    valueField: '2014',
                    type: 'splinearea',
                    lineColor: '#68b828',
                    minColor: '#68b828',
                    maxColor: '#7c38bc',
                    pointSize: 6,
                    showMinMax: true,
                    showFirstLast: false
                },
                thirdMonth = {
                    dataSource: getThirdMonthViews(),
                    argumentField: 'month',
                    valueField: '2014',
                    type: 'splinearea',
                    lineColor: '#68b828',
                    minColor: '#68b828',
                    maxColor: '#7c38bc',
                    pointSize: 6,
                    showMinMax: true,
                    showFirstLast: false
                };

        function getFirstMonthViews() {
            return [{month: 1, 2014: 7341},
                {month: 2, 2014: 7016},
                {month: 3, 2014: 7202},
                {month: 4, 2014: 7851},
                {month: 5, 2014: 7481},
                {month: 6, 2014: 6532},
                {month: 7, 2014: 6498},
                {month: 8, 2014: 7191},
                {month: 9, 2014: 7596},
                {month: 10, 2014: 8057},
                {month: 11, 2014: 8373},
                {month: 12, 2014: 8636}];
        }
        ;

        function getSecondMonthViews() {
            return [{month: 1, 2014: 189742},
                {month: 2, 2014: 181623},
                {month: 3, 2014: 205351},
                {month: 4, 2014: 245625},
                {month: 5, 2014: 261319},
                {month: 6, 2014: 192786},
                {month: 7, 2014: 194752},
                {month: 8, 2014: 207017},
                {month: 9, 2014: 212665},
                {month: 10, 2014: 233580},
                {month: 11, 2014: 231503},
                {month: 12, 2014: 232824}];
        }
        ;

        function getThirdMonthViews() {
            return [{month: 1, 2014: 398},
                {month: 2, 2014: 422},
                {month: 3, 2014: 431},
                {month: 4, 2014: 481},
                {month: 5, 2014: 551},
                {month: 6, 2014: 449},
                {month: 7, 2014: 442},
                {month: 8, 2014: 482},
                {month: 9, 2014: 517},
                {month: 10, 2014: 566},
                {month: 11, 2014: 630},
                {month: 12, 2014: 737}];
        }
        ;


        $('.first-month').dxSparkline(firstMonth);
        $('.second-month').dxSparkline(secondMonth);
        $('.third-month').dxSparkline(thirdMonth);


        // Realtime Network Stats
        var i = 0,
                rns_values = [130, 150],
                rns2_values = [39, 50],
                realtime_network_stats = [];

        for (i = 0; i <= 100; i++)
        {
            realtime_network_stats.push({id: i, x1: between(rns_values[0], rns_values[1]), x2: between(rns2_values[0], rns2_values[1])});
        }

        $("#realtime-network-stats").dxChart({
            dataSource: realtime_network_stats,
            commonSeriesSettings: {
                type: "area",
                argumentField: "id"
            },
            series: [
                {valueField: "x1", name: "Packets Sent", color: '#7c38bc', opacity: .4},
                {valueField: "x2", name: "Packets Received", color: '#000', opacity: .5},
            ],
            legend: {
                verticalAlignment: "bottom",
                horizontalAlignment: "center"
            },
            commonAxisSettings: {
                label: {
                    visible: false
                },
                grid: {
                    visible: true,
                    color: '#f5f5f5'
                }
            },
            legend: {
                visible: false
            },
            argumentAxis: {
                valueMarginsEnabled: false
            },
            valueAxis: {
                max: 500
            },
            animation: {
                enabled: false
            }
        }).data('iCount', i);

        $('#network-realtime-gauge').dxCircularGauge({
            scale: {
                startValue: 0,
                endValue: 200,
                majorTick: {
                    tickInterval: 50
                }
            },
            rangeContainer: {
                palette: 'pastel',
                width: 3,
                ranges: [
                    {startValue: 0, endValue: 50, color: "#7c38bc"},
                    {startValue: 50, endValue: 100, color: "#7c38bc"},
                    {startValue: 100, endValue: 150, color: "#7c38bc"},
                    {startValue: 150, endValue: 200, color: "#7c38bc"},
                ],
            },
            value: 140,
            valueIndicator: {
                offset: 10,
                color: '#7c38bc',
                type: 'triangleNeedle',
                spindleSize: 12
            }
        });

        setInterval(function () {
            networkRealtimeChartTick(rns_values, rns2_values);
        }, 1000);
        setInterval(function () {
            networkRealtimeGaugeTick();
        }, 2000);
        setInterval(function () {
            networkRealtimeMBupdate();
        }, 3000);



        // CPU Usage Gauge
        $("#cpu-usage-gauge").dxCircularGauge({
            scale: {
                startValue: 0,
                endValue: 100,
                majorTick: {
                    tickInterval: 25
                }
            },
            rangeContainer: {
                palette: 'pastel',
                width: 3,
                ranges: [
                    {startValue: 0, endValue: 25, color: "#68b828"},
                    {startValue: 25, endValue: 50, color: "#68b828"},
                    {startValue: 50, endValue: 75, color: "#68b828"},
                    {startValue: 75, endValue: 100, color: "#d5080f"},
                ],
            },
            value: between(30, 90),
            valueIndicator: {
                offset: 10,
                color: '#68b828',
                type: 'rectangleNeedle',
                spindleSize: 12
            }
        });


        // Resize charts
        $(window).on('xenon.resize', function ()
        {
            $("#pageviews-visitors-chart").data("dxChart").render();
            $("#server-uptime-chart").data("dxChart").render();
            $("#realtime-network-stats").data("dxChart").render();

            $('.first-month').data("dxSparkline").render();
            $('.second-month').data("dxSparkline").render();
            $('.third-month').data("dxSparkline").render();
        });

    });

    function networkRealtimeChartTick(min_max, min_max2)
    {
        var $ = jQuery,
                i = 0;

        if ($('#realtime-network-stats').length == 0)
            return;

        var chart_data = $('#realtime-network-stats').dxChart('instance').option('dataSource');

        var count = $('#realtime-network-stats').data('iCount');

        $('#realtime-network-stats').data('iCount', count + 1);

        chart_data.shift();
        chart_data.push({id: count + 1, x1: between(min_max[0], min_max[1]), x2: between(min_max2[0], min_max2[1])});

        $('#realtime-network-stats').dxChart('instance').option('dataSource', chart_data);
    }

    function networkRealtimeGaugeTick()
    {
        if (jQuery('#network-realtime-gauge').length == 0)
            return;

        var nr_gauge = jQuery('#network-realtime-gauge').dxCircularGauge('instance');

        nr_gauge.value(between(50, 200));
    }

    function networkRealtimeMBupdate()
    {
        var $el = jQuery("#network-mbs-packets");

        if ($el.length == 0)
            return;

        var options = {
            useEasing: true,
            useGrouping: true,
            separator: ',',
            decimal: '.',
            prefix: '',
            suffix: 'mb/s'
        },
                cntr = new countUp($el[0], parseFloat($el.text().replace('mb/s')), parseFloat(between(10, 25) + 1 / between(15, 30)), 2, 1.5, options);

        cntr.start();
    }

    function between(randNumMin, randNumMax)
    {
        var randInt = Math.floor((Math.random() * ((randNumMax + 1) - randNumMin)) + randNumMin);

        return randInt;
    }
</script>
<div class="row">
    <div class="col-sm-3">

        <div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
            <div class="xe-icon">
                <i class="linecons-cloud"></i>
            </div>
            <div class="xe-label">
                <strong class="num">99.9%</strong>
                <span>Server uptime</span>
            </div>
        </div>

        <div class="xe-widget xe-counter xe-counter-purple" data-count=".num" data-from="1" data-to="117" data-suffix="k" data-duration="3" data-easing="false">
            <div class="xe-icon">
                <i class="linecons-user"></i>
            </div>
            <div class="xe-label">
                <strong class="num">117k</strong>
                <span>Users Total</span>
            </div>
        </div>

        <div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
            <div class="xe-icon">
                <i class="linecons-camera"></i>
            </div>
            <div class="xe-label">
                <strong class="num">2,470</strong>
                <span>New Daily Photos</span>
            </div>
        </div>

    </div>
    <div class="col-sm-6">

        <div class="chart-item-bg">
            <div class="chart-label">
                <div class="h3 text-secondary text-bold" data-count="this" data-from="0.00" data-to="14.85" data-suffix="%" data-duration="1">14.85%</div>
                <span class="text-medium text-muted">More visitors</span>
            </div>
            <div id="pageviews-visitors-chart" style="height: 298px;" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxc dxc-chart" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;touch-action:pan-x pan-y pinch-zoom;-ms-touch-action:pan-x pan-y pinch-zoom;" direction="ltr" width="534" height="298" onclick="void(0)"><rect x="0" y="0" width="534" height="298" transform="translate(0,0)" fill="gray" opacity="0.0001"></rect><defs><clipPath id="DevExpress_2"><rect x="0" y="0" width="534" height="298" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_3"><rect x="0" y="0" width="534" height="298" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_4"><rect x="0" y="0" width="534" height="298" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_5"><rect x="0" y="0" width="534" height="298" transform="translate(0,0)"></rect></clipPath><pattern id="DevExpress_6" width="5" height="5" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="5" height="5" transform="translate(0,0)" fill="#68b828" opacity="0.75"></rect><path d="M 2.5 -2.5 L -2.5 2.5 M 0 5 L 5 0 M 7.5 2.5 L 2.5 7.5" stroke-width="2" stroke="#68b828" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_7" width="5" height="5" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="5" height="5" transform="translate(0,0)" fill="#68b828" opacity="0.5"></rect><path d="M 2.5 -2.5 L -2.5 2.5 M 0 5 L 5 0 M 7.5 2.5 L 2.5 7.5" stroke-width="2" stroke="#68b828" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_8" width="5" height="5" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="5" height="5" transform="translate(0,0)" fill="#eeeeee" opacity="0.75"></rect><path d="M 2.5 -2.5 L -2.5 2.5 M 0 5 L 5 0 M 7.5 2.5 L 2.5 7.5" stroke-width="2" stroke="#eeeeee" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_9" width="5" height="5" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="5" height="5" transform="translate(0,0)" fill="#eeeeee" opacity="0.5"></rect><path d="M 2.5 -2.5 L -2.5 2.5 M 0 5 L 5 0 M 7.5 2.5 L 2.5 7.5" stroke-width="2" stroke="#eeeeee" transform="translate(0,0)"></path></pattern></defs><g class="dxc-background"></g><g class="dxc-strips-group"><g class="dxc-arg-strips" clip-path="url(#DevExpress_3)"></g><g class="dxc-val-strips" clip-path="url(#DevExpress_3)"></g></g><g class="dxc-grids-group"><g class="dxc-val-grid"><path d="M 0 298 L 534 298" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 267 L 534 267" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 235 L 534 235" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 204 L 534 204" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 173 L 534 173" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 141 L 534 141" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 110 L 534 110" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 78 L 534 78" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 47 L 534 47" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 0 16 L 534 16" transform="translate(0,0.5)" stroke="#f9f9f9" stroke-width="1"></path></g><g class="dxc-arg-grid"><path d="M 59 298 L 59 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 134 298 L 134 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 208 298 L 208 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 282 298 L 282 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 356 298 L 356 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 430 298 L 430 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path><path d="M 504 298 L 504 0" transform="translate(0.5,0)" stroke="#f9f9f9" stroke-width="1"></path></g></g><g class="dxc-axes-group"><g class="dxc-arg-axis" clip-path="url(#DevExpress_2)"><g class="dxc-arg-elements"></g><g class="dxc-arg-line"></g><g class="dxc-arg-title"></g></g><g class="dxc-val-axis" clip-path="url(#DevExpress_2)"><g class="dxc-val-elements"></g><g class="dxc-val-line"></g><g class="dxc-val-title"></g></g></g><g class="dxc-constant-lines-group"><g class="dxc-arg-constant-lines"></g><g class="dxc-val-constant-lines"></g></g><g class="dxc-strips-labels-group"><g class="dxc-arg-axis-labels"></g><g class="dxc-val-axis-labels"></g></g><g class="dxc-border"></g><g class="dxc-series-group"><g class="dxc-series"><g class="dxc-elements" stroke="#68b828" stroke-width="1" clip-path="url(#DevExpress_4)"><path d="M 0 256 L 15 246 L 30 246 L 45 256 L 59 267 L 74 267 L 89 246 L 104 225 L 119 204 L 134 225 L 148 225 L 163 183 L 178 193 L 193 204 L 208 214 L 223 214 L 237 214 L 252 214 L 267 141 L 282 193 L 297 204 L 312 204 L 326 214 L 341 214 L 356 204 L 371 214 L 386 214 L 401 225 L 415 225 L 430 235 L 445 225 L 460 225 L 475 214 L 490 235 L 504 246 L 519 246 L 534 235" transform="translate(0.5,0.5)" stroke-width="1"></path></g><g fill="#68b828" stroke="#68b828" stroke-width="0" r="2.5" visibility="visible" class="dxc-markers" opacity="1" clip-path=""><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(193,204)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(297,204)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(0,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(15,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(30,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(45,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(59,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(74,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(89,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(104,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(119,204)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(134,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(148,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(163,183)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(178,193)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(208,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(223,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(237,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(252,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(267,141)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(282,193)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(312,204)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(326,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(341,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(356,204)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(371,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(386,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(401,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(415,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(430,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(445,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(460,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(475,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(490,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(504,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(519,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(534,235)"></circle></g><g class="dxc-error-bars" stroke="#000000" stroke-width="2" opacity="1" stroke-linecap="square" clip-path="url(#DevExpress_5)" transform="translate(0,0)"></g><g fill="gray" opacity="0.001" stroke="gray" class="dxc-trackers" clip-path="url(#DevExpress_4)"><path d="M 0 256 L 15 246 L 30 246 L 45 256 L 59 267 L 74 267 L 89 246 L 104 225 L 119 204 L 134 225 L 148 225 L 163 183 L 178 193 L 193 204 L 208 214 L 223 214 L 237 214 L 252 214 L 267 141 L 282 193 L 297 204 L 312 204 L 326 214 L 341 214 L 356 204 L 371 214 L 386 214 L 401 225 L 415 225 L 430 235 L 445 225 L 460 225 L 475 214 L 490 235 L 504 246 L 519 246 L 534 235" transform="translate(0,0)" stroke-width="20" fill="none"></path></g></g><g class="dxc-series"><g class="dxc-elements" stroke="#eeeeee" stroke-width="1" clip-path="url(#DevExpress_4)"><path d="M 0 277 L 15 267 L 30 267 L 45 277 L 59 288 L 74 277 L 89 267 L 104 256 L 119 246 L 134 256 L 148 267 L 163 235 L 178 214 L 193 225 L 208 225 L 223 225 L 237 225 L 252 235 L 267 246 L 282 246 L 297 235 L 312 267 L 326 246 L 341 256 L 356 246 L 371 235 L 386 246 L 401 235 L 415 246 L 430 246 L 445 235 L 460 246 L 475 246 L 490 246 L 504 256 L 519 267 L 534 267" transform="translate(0.5,0.5)" stroke-width="1"></path></g><g fill="#eeeeee" stroke="#eeeeee" stroke-width="0" r="2.5" visibility="visible" class="dxc-markers" opacity="1" clip-path=""><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(0,277)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(15,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(30,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(45,277)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(59,288)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(74,277)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(89,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(104,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(119,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(134,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(148,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(163,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(178,214)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(193,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(208,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(223,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(237,225)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(252,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(267,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(282,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(297,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(312,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(326,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(341,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(356,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(371,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(386,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(401,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(415,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(430,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(445,235)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(460,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(475,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(490,246)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(504,256)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(519,267)"></circle><circle cx="0" cy="0" r="2.5" stroke-width="0" transform="translate(534,267)"></circle></g><g class="dxc-error-bars" stroke="#000000" stroke-width="2" opacity="1" stroke-linecap="square" clip-path="url(#DevExpress_5)" transform="translate(0,0)"></g><g fill="gray" opacity="0.001" stroke="gray" class="dxc-trackers" clip-path="url(#DevExpress_4)"><path d="M 0 277 L 15 267 L 30 267 L 45 277 L 59 288 L 74 277 L 89 267 L 104 256 L 119 246 L 134 256 L 148 267 L 163 235 L 178 214 L 193 225 L 208 225 L 223 225 L 237 225 L 252 235 L 267 246 L 282 246 L 297 235 L 312 267 L 326 246 L 341 256 L 356 246 L 371 235 L 386 246 L 401 235 L 415 246 L 430 246 L 445 235 L 460 246 L 475 246 L 490 246 L 504 256 L 519 267 L 534 267" transform="translate(0,0)" stroke-width="20" fill="none"></path></g></g></g><g class="dxc-labels-group"><g class="dxc-labels" visibility="hidden" clip-path="url(#DevExpress_4)" transform="translate(0,0)" opacity="1"></g><g class="dxc-labels" visibility="hidden" clip-path="url(#DevExpress_4)" transform="translate(0,0)" opacity="1"></g></g><g class="dxc-crosshair-cursor"></g><g class="dxc-legend" clip-path="url(#DevExpress_2)" transform="translate(0,0)"><g transform="translate(445,25)"><rect x="-5" y="-15" width="84" height="74" transform="translate(0,0)" fill="#ffffff" class="dxc-border"></rect><rect x="0" y="0" width="12" height="12" transform="translate(0,3)" fill="#68b828"></rect><text x="0" y="0" transform="translate(19,14)" style="fill:#767676;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;font-size:12px;cursor:default;" text-anchor="start">Pageviews</text><rect x="0" y="0" width="12" height="12" transform="translate(0,29)" fill="#eeeeee"></rect><text x="0" y="0" transform="translate(21,40)" style="fill:#767676;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;font-size:12px;cursor:default;" text-anchor="start">Visitors</text></g></g></svg></div>
        </div>

    </div>
    <div class="col-sm-3">

        <div class="chart-item-bg">
            <div class="chart-label chart-label-small">
                <div class="h4 text-purple text-bold" data-count="this" data-from="0.00" data-to="95.8" data-suffix="%" data-duration="1.5">95.8%</div>
                <span class="text-small text-upper text-muted">Current Server Uptime</span>
            </div>
            <div id="server-uptime-chart" style="height: 134px;" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxc dxc-chart" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;touch-action:pan-x pan-y pinch-zoom;-ms-touch-action:pan-x pan-y pinch-zoom;" direction="ltr" width="252" height="134" onclick="void(0)"><rect x="0" y="0" width="252" height="134" transform="translate(0,0)" fill="gray" opacity="0.0001"></rect><defs><clipPath id="DevExpress_11"><rect x="0" y="0" width="252" height="134" transform="translate(0,0)"></rect></clipPath><pattern id="DevExpress_12" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.75"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_13" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.5"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern><clipPath id="DevExpress_14"><rect x="0" y="0" width="252" height="134" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_15"><rect x="0" y="0" width="252" height="134" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_16"><rect x="0" y="0" width="252" height="134" transform="translate(0,0)"></rect></clipPath><pattern id="DevExpress_51" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.75"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_52" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.5"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern></defs><g class="dxc-background"></g><g class="dxc-strips-group"><g class="dxc-arg-strips" clip-path="url(#DevExpress_14)"></g><g class="dxc-val-strips" clip-path="url(#DevExpress_14)"></g></g><g class="dxc-grids-group"><g class="dxc-val-grid"></g><g class="dxc-arg-grid"></g></g><g class="dxc-axes-group"><g class="dxc-arg-axis" clip-path="url(#DevExpress_11)"><g class="dxc-arg-elements"></g><g class="dxc-arg-line"></g><g class="dxc-arg-title"></g></g><g class="dxc-val-axis" clip-path="url(#DevExpress_11)"><g class="dxc-val-elements"></g><g class="dxc-val-line"></g><g class="dxc-val-title"></g></g></g><g class="dxc-constant-lines-group"><g class="dxc-arg-constant-lines"></g><g class="dxc-val-constant-lines"></g></g><g class="dxc-strips-labels-group"><g class="dxc-arg-axis-labels"></g><g class="dxc-val-axis-labels"></g></g><g class="dxc-border"></g><g class="dxc-series-group"><g class="dxc-series"><g fill="#7c38bc" stroke="#7c38bc" stroke-width="0" class="dxc-markers" opacity="1" clip-path="" transform="translate(0,0) scale(1,1)"><rect x="211" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="201" y="104" width="11" height="30" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="70" y="104" width="11" height="30" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="60" y="114" width="11" height="20" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="191" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="100" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="80" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="170" y="84" width="11" height="50" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="49" y="124" width="11" height="10" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="90" y="84" width="11" height="50" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="110" y="84" width="11" height="50" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="120" y="74" width="11" height="60" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="130" y="65" width="11" height="69" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="140" y="74" width="11" height="60" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="150" y="84" width="11" height="50" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="160" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect><rect x="180" y="94" width="11" height="40" transform="translate(0,0)" rx="0" ry="0" stroke-width="0"></rect></g><g class="dxc-error-bars" stroke="#000000" stroke-width="2" opacity="1" stroke-linecap="square" clip-path="url(#DevExpress_16)" transform="translate(0,0)"></g></g></g><g class="dxc-labels-group"><g class="dxc-labels" visibility="hidden" clip-path="url(#DevExpress_15)" transform="translate(0,0)" opacity="1"></g></g><g class="dxc-crosshair-cursor"></g><g class="dxc-legend" clip-path="url(#DevExpress_11)"></g></svg></div>
        </div>

        <div class="chart-item-bg">
            <div class="chart-label chart-label-small">
                <div class="h4 text-secondary text-bold" data-count="this" data-from="0.00" data-to="320.45" data-decimal="," data-duration="2">320,45</div>
                <span class="text-small text-upper text-muted">Avg. of Sales</span>
            </div>
            <div id="sales-avg-chart" style="height: 134px; position: relative;">
                <div style="position: absolute; top: 25px; right: 0; left: 40%; bottom: 0" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxc dxc-chart" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" direction="ltr" width="151" height="90" onclick="void(0)"><rect x="0" y="0" width="151" height="90" transform="translate(0,0)" fill="gray" opacity="0.0001"></rect><defs><clipPath id="DevExpress_18"><rect x="0" y="0" width="151" height="90" transform="translate(0,0)"></rect></clipPath><pattern id="DevExpress_19" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#5e9b4c" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#5e9b4c" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_20" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#5e9b4c" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#5e9b4c" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_21" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#6ca959" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#6ca959" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_22" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#6ca959" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#6ca959" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_23" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#b9f5a6" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#b9f5a6" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_24" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#b9f5a6" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#b9f5a6" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_25" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#90cd7e" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#90cd7e" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_26" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#90cd7e" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#90cd7e" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_27" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#9edb8b" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#9edb8b" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_28" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#9edb8b" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#9edb8b" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_29" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#a0dc8d" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#a0dc8d" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_30" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#a0dc8d" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#a0dc8d" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_31" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#2c691a" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#2c691a" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_32" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#2c691a" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#2c691a" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_33" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#3a7727" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#3a7727" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_34" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#3a7727" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#3a7727" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_35" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#87c374" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#87c374" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_36" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#87c374" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#87c374" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_37" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#5e9b4c" opacity="0.75"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#5e9b4c" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_38" width="10" height="10" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="10" height="10" transform="translate(0,0)" fill="#5e9b4c" opacity="0.5"></rect><path d="M 5 -5 L -5 5 M 0 10 L 10 0 M 15 5 L 5 15" stroke-width="4" stroke="#5e9b4c" transform="translate(0,0)"></path></pattern></defs><g class="dxc-legend" clip-path="url(#DevExpress_18)"></g><g class="dxc-series-group"><g class="dxc-series"><g class="dxc-markers"><path d="M 35.15945 65.92201 A 45.00000 45.00000 0 0 0 120.00000 45.00000 L 97.00000 45.00000 A 22.00000 22.00000 0 0 1 55.52240 55.22854 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#5e9b4c" stroke="#ffffff" stroke-width="0"></path><path d="M 30.64878 37.38626 A 45.00000 45.00000 0 0 0 35.15945 65.92201 L 55.52240 55.22854 A 22.00000 22.00000 0 0 1 53.31718 41.27773 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#6ca959" stroke="#ffffff" stroke-width="0"></path><path d="M 33.41417 27.80643 A 45.00000 45.00000 0 0 0 30.64878 37.38626 L 53.31718 41.27773 A 22.00000 22.00000 0 0 1 54.66915 36.59425 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#b9f5a6" stroke="#ffffff" stroke-width="0"></path><path d="M 42.79855 13.56647 A 45.00000 45.00000 0 0 0 33.41417 27.80643 L 54.66915 36.59425 A 22.00000 22.00000 0 0 1 59.25707 29.63250 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#90cd7e" stroke="#ffffff" stroke-width="0"></path><path d="M 60.48863 2.40399 A 45.00000 45.00000 0 0 0 42.79855 13.56647 L 59.25707 29.63250 A 22.00000 22.00000 0 0 1 67.90555 24.17528 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#9edb8b" stroke="#ffffff" stroke-width="0"></path><path d="M 61.45707 2.08626 A 45.00000 45.00000 0 0 0 60.48863 2.40399 L 67.90555 24.17528 A 22.00000 22.00000 0 0 1 68.37901 24.01995 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#a0dc8d" stroke="#ffffff" stroke-width="0"></path><path d="M 82.32163 0.59962 A 45.00000 45.00000 0 0 0 61.45707 2.08626 L 68.37901 24.01995 A 22.00000 22.00000 0 0 1 78.57946 23.29315 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#2c691a" stroke="#ffffff" stroke-width="0"></path><path d="M 101.60421 8.70653 A 45.00000 45.00000 0 0 0 82.32163 0.59962 L 78.57946 23.29315 A 22.00000 22.00000 0 0 1 88.00650 27.25653 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#3a7727" stroke="#ffffff" stroke-width="0"></path><path d="M 115.13844 24.65534 A 45.00000 45.00000 0 0 0 101.60421 8.70653 L 88.00650 27.25653 A 22.00000 22.00000 0 0 1 94.62324 35.05372 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#87c374" stroke="#ffffff" stroke-width="0"></path><path d="M 120.00000 45.00000 A 45.00000 45.00000 0 0 0 115.13844 24.65534 L 94.62324 35.05372 A 22.00000 22.00000 0 0 1 97.00000 45.00000 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#5e9b4c" stroke="#ffffff" stroke-width="0"></path></g></g></g><g class="dxc-labels-group"><g class="dxc-labels" visibility="hidden" transform="translate(0,0)" opacity="1"></g></g></svg></div>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-sm-6">

        <div class="chart-item-bg">
            <div id="pageviews-stats" style="height: 320px; padding: 20px 0;" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxg dxbg-bar-gauge" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" direction="ltr" width="534" height="280"><defs></defs><g class="dxbg-bars"><path d="M 349.73149 242.73149 A 117.00000 117.00000 0 1 0 184.26851 242.73149 L 196.64288 230.35712 A 99.50000 99.50000 0 1 1 337.35712 230.35712 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#e0e0e0"></path><path d="M 267.00000 43.00000 A 117.00000 117.00000 0 0 0 168.31223 97.15317 L 183.07322 106.55334 A 99.50000 99.50000 0 0 1 267.00000 60.50000 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#68b828"></path><path d="M 267 60.5 L 267 23" transform="translate(0,0) rotate(-57.50999999999999,267,160)" stroke-width="2" stroke="#68b828"></path><text x="126.13797002365754" y="85.49741799134398" transform="translate(0,0)" style="font-size:16px;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;cursor:default;fill:#68b828;" text-anchor="middle">-21.3%</text><path d="M 334.52870 227.52870 A 95.50000 95.50000 0 1 0 199.47130 227.52870 L 211.84567 215.15433 A 78.00000 78.00000 0 1 1 322.15433 215.15433 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#e0e0e0"></path><path d="M 328.33513 86.79992 A 95.50000 95.50000 0 0 0 267.00000 64.50000 L 267.00000 82.00000 A 78.00000 78.00000 0 0 1 317.09571 100.21355 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#7c38bc"></path><path d="M 267 82 L 267 23" transform="translate(0,0) rotate(39.96000000000001,267,160)" stroke-width="2" stroke="#7c38bc"></path><text x="374.2561930804896" y="50.91285457315003" transform="translate(0,0)" style="font-size:16px;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;cursor:default;fill:#7c38bc;" text-anchor="middle">14.8%</text><path d="M 319.32590 212.32590 A 74.00000 74.00000 0 1 0 214.67410 212.32590 L 227.04847 199.95153 A 56.50000 56.50000 0 1 1 306.95153 199.95153 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#e0e0e0"></path><path d="M 267.00000 86.00000 A 74.00000 74.00000 0 0 0 193.48597 151.53314 L 210.87105 153.53544 A 56.50000 56.50000 0 0 1 267.00000 103.50000 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#0e62c7"></path><path d="M 267 103.5 L 267 23" transform="translate(0,0) rotate(-83.43,267,160)" stroke-width="2" stroke="#0e62c7"></path><text x="101.09672066661904" y="149.24591549557468" transform="translate(0,0)" style="font-size:16px;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;cursor:default;fill:#0e62c7;" text-anchor="middle">-30.9%</text><path d="M 304.12311 197.12311 A 52.50000 52.50000 0 1 0 229.87689 197.12311 L 242.25126 184.74874 A 35.00000 35.00000 0 1 1 291.74874 184.74874 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#e0e0e0"></path><path d="M 311.50309 187.85184 A 52.50000 52.50000 0 0 0 267.00000 107.50000 L 267.00000 125.00000 A 35.00000 35.00000 0 0 1 296.66873 178.56789 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#fcd036"></path><path d="M 267 125 L 267 23" transform="translate(0,0) rotate(122.04000000000002,267,160)" stroke-width="2" stroke="#fcd036"></path><text x="408.56221532620884" y="246.50108659345554" transform="translate(0,0)" style="font-size:16px;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;cursor:default;fill:#fcd036;" text-anchor="middle">45.2%</text></g><g class="dxg-tracker" stroke="none" stroke-width="0" fill="#000000" opacity="0.0001"><path d="M 267.00000 43.00000 A 117.00000 117.00000 0 0 0 168.31223 97.15317 L 183.07322 106.55334 A 99.50000 99.50000 0 0 1 267.00000 60.50000 Z" transform="translate(0,0)" stroke-linejoin="round"></path><path d="M 328.33513 86.79992 A 95.50000 95.50000 0 0 0 267.00000 64.50000 L 267.00000 82.00000 A 78.00000 78.00000 0 0 1 317.09571 100.21355 Z" transform="translate(0,0)" stroke-linejoin="round"></path><path d="M 267.00000 86.00000 A 74.00000 74.00000 0 0 0 193.48597 151.53314 L 210.87105 153.53544 A 56.50000 56.50000 0 0 1 267.00000 103.50000 Z" transform="translate(0,0)" stroke-linejoin="round"></path><path d="M 311.50309 187.85184 A 52.50000 52.50000 0 0 0 267.00000 107.50000 L 267.00000 125.00000 A 35.00000 35.00000 0 0 1 296.66873 178.56789 Z" transform="translate(0,0)" stroke-linejoin="round"></path></g></svg></div>

            <div class="chart-entry-view">
                <div class="chart-entry-label">
                    Pageviews
                </div>
                <div class="chart-entry-value">
                    <div class="sparkline first-month dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxsl dxsl-sparkline" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" pointer-events="visible" direction="ltr" width="208" height="30"><defs></defs><g class="dxsl-series"><g class="dxc-series"><g class="dxc-elements" stroke="none" fill="#68b828" opacity="0.2"><path d="M 5 9 L 23 10 L 41 10 L 59 8 L 77 9 L 95 11 L 113 11 L 131 10 L 149 9 L 167 8 L 185 7 L 203 6 L 203 27 L 185 27 L 167 27 L 149 27 L 131 27 L 113 27 L 95 27 L 77 27 L 59 27 L 41 27 L 23 27 L 5 27 Z" transform="translate(0,0)"></path></g><g class="dxc-borders" stroke="#68b828" stroke-width="2"><path d="M 5 9 L 23 10 L 41 10 L 59 8 L 77 9 L 95 11 L 113 11 L 131 10 L 149 9 L 167 8 L 185 7 L 203 6" transform="translate(0,0)" stroke-width="2"></path></g><g fill="#ffffff" stroke="#ffffff" stroke-width="2" r="3" visibility="hidden" class="dxc-markers" opacity="1" clip-path=""><circle cx="0" cy="0" r="3" fill="#ffffff" stroke="#68b828" stroke-width="2" visibility="visible" transform="translate(113,11)"></circle><circle cx="0" cy="0" r="3" fill="#ffffff" stroke="#7c38bc" stroke-width="2" visibility="visible" transform="translate(203,6)"></circle></g><g class="dxc-error-bars" opacity="1" stroke-linecap="square" transform="translate(0,0)"></g></g></g></svg></div>
                </div>
            </div>

            <div class="chart-entry-view">
                <div class="chart-entry-label">
                    Visitors
                </div>
                <div class="chart-entry-value">
                    <div class="sparkline second-month dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxsl dxsl-sparkline" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" pointer-events="visible" direction="ltr" width="208" height="30"><defs></defs><g class="dxsl-series"><g class="dxc-series"><g class="dxc-elements" stroke="none" fill="#68b828" opacity="0.2"><path d="M 5 11 C 5 11 14 11 23 11 C 32 11 35 10.666666666666666 41 10 C 47 9.333333333333334 53 7.666666666666667 59 7 C 65 6.333333333333333 68 6 77 6 C 86 6 86 11 95 11 C 104 11 104 10 113 10 C 122 10 122 10 131 10 C 140 10 143 9.333333333333334 149 9 C 155 8.666666666666666 158 8 167 8 C 176 8 176 8 185 8 C 194 8 203 8 203 8 C 203 8 203 24 203 24 C 203 24 194 24 185 24 C 176 24 176 24 167 24 C 158 24 155 24 149 24 C 143 24 140 24 131 24 C 122 24 122 24 113 24 C 104 24 104 24 95 24 C 86 24 86 24 77 24 C 68 24 65 24 59 24 C 53 24 47 24 41 24 C 35 24 32 24 23 24 C 14 24 5 24 5 24 Z" transform="translate(0,0)"></path></g><g class="dxc-borders" stroke="#68b828" stroke-width="2"><path d="M 5 11 C 5 11 14 11 23 11 C 32 11 35 10.666666666666666 41 10 C 47 9.333333333333334 53 7.666666666666667 59 7 C 65 6.333333333333333 68 6 77 6 C 86 6 86 11 95 11 C 104 11 104 10 113 10 C 122 10 122 10 131 10 C 140 10 143 9.333333333333334 149 9 C 155 8.666666666666666 158 8 167 8 C 176 8 176 8 185 8 C 194 8 203 8 203 8" transform="translate(0,0)" stroke-width="2"></path></g><g fill="#ffffff" stroke="#ffffff" stroke-width="2" r="4" visibility="hidden" class="dxc-markers" opacity="1" clip-path=""><circle cx="0" cy="0" r="4" fill="#ffffff" stroke="#68b828" stroke-width="2" visibility="visible" transform="translate(23,11)"></circle><circle cx="0" cy="0" r="4" fill="#ffffff" stroke="#7c38bc" stroke-width="2" visibility="visible" transform="translate(77,6)"></circle></g><g class="dxc-error-bars" opacity="1" stroke-linecap="square" transform="translate(0,0)"></g></g></g></svg></div>
                </div>
            </div>

            <div class="chart-entry-view">
                <div class="chart-entry-label">
                    Converted Sales
                </div>
                <div class="chart-entry-value">
                    <div class="sparkline third-month dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxsl dxsl-sparkline" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" pointer-events="visible" direction="ltr" width="208" height="30"><defs></defs><g class="dxsl-series"><g class="dxc-series"><g class="dxc-elements" stroke="none" fill="#68b828" opacity="0.2"><path d="M 5 14 C 5 14 14 14 23 14 C 32 14 35 13.333333333333334 41 13 C 47 12.666666666666666 53 12.5 59 12 C 65 11.5 68 10 77 10 C 86 10 86 13 95 13 C 104 13 104 13 113 13 C 122 13 125 12.333333333333334 131 12 C 137 11.666666666666666 143 11.333333333333334 149 11 C 155 10.666666666666666 161 10.5 167 10 C 173 9.5 179 8.666666666666666 185 8 C 191 7.333333333333333 203 6 203 6 C 203 6 203 24 203 24 C 203 24 191 24 185 24 C 179 24 173 24 167 24 C 161 24 155 24 149 24 C 143 24 137 24 131 24 C 125 24 122 24 113 24 C 104 24 104 24 95 24 C 86 24 86 24 77 24 C 68 24 65 24 59 24 C 53 24 47 24 41 24 C 35 24 32 24 23 24 C 14 24 5 24 5 24 Z" transform="translate(0,0)"></path></g><g class="dxc-borders" stroke="#68b828" stroke-width="2"><path d="M 5 14 C 5 14 14 14 23 14 C 32 14 35 13.333333333333334 41 13 C 47 12.666666666666666 53 12.5 59 12 C 65 11.5 68 10 77 10 C 86 10 86 13 95 13 C 104 13 104 13 113 13 C 122 13 125 12.333333333333334 131 12 C 137 11.666666666666666 143 11.333333333333334 149 11 C 155 10.666666666666666 161 10.5 167 10 C 173 9.5 179 8.666666666666666 185 8 C 191 7.333333333333333 203 6 203 6" transform="translate(0,0)" stroke-width="2"></path></g><g fill="#ffffff" stroke="#ffffff" stroke-width="2" r="4" visibility="hidden" class="dxc-markers" opacity="1" clip-path=""><circle cx="0" cy="0" r="4" fill="#ffffff" stroke="#68b828" stroke-width="2" visibility="visible" transform="translate(5,14)"></circle><circle cx="0" cy="0" r="4" fill="#ffffff" stroke="#7c38bc" stroke-width="2" visibility="visible" transform="translate(203,6)"></circle></g><g class="dxc-error-bars" opacity="1" stroke-linecap="square" transform="translate(0,0)"></g></g></g></svg></div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-6">

        <div class="chart-item-bg">
            <div class="chart-label">
                <div id="network-mbs-packets" class="h1 text-purple text-bold" data-count="this" data-from="0.00" data-to="21.05" data-suffix="mb/s" data-duration="1">21.03mb/s</div>
                <span class="text-small text-muted text-upper">Download Speed</span>
            </div>
            <div class="chart-right-legend">
                <div id="network-realtime-gauge" style="width: 170px; height: 140px" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxg dxg-circular-gauge" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" direction="ltr" width="170" height="140"><defs></defs><g class="dxg-range-container"><path d="M 41.57766 59.01388 A 47.00000 47.00000 0 0 0 51.76598 110.23402 L 53.88730 108.11270 A 44.00000 44.00000 0 0 1 44.34930 60.16193 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#7c38bc" class="dxg-range dxg-range-0"></path><path d="M 85.00000 30.00000 A 47.00000 47.00000 0 0 0 41.57766 59.01388 L 44.34930 60.16193 A 44.00000 44.00000 0 0 1 85.00000 33.00000 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#7c38bc" class="dxg-range dxg-range-1"></path><path d="M 128.42234 59.01388 A 47.00000 47.00000 0 0 0 85.00000 30.00000 L 85.00000 33.00000 A 44.00000 44.00000 0 0 1 125.65070 60.16193 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#7c38bc" class="dxg-range dxg-range-2"></path><path d="M 118.23402 110.23402 A 47.00000 47.00000 0 0 0 128.42234 59.01388 L 125.65070 60.16193 A 44.00000 44.00000 0 0 1 116.11270 108.11270 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#7c38bc" class="dxg-range dxg-range-3"></path></g><g class="dxg-scale"><g class="dxg-major-ticks" fill="#ffffff"><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(-135,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(-67.5,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(67.5,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(135,85,77)"></path></g><g class="dxg-labels" text-anchor="middle" style="fill:#a8a8a8;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;font-size:12px;cursor:default;"><text x="40.92367730603853" y="130.08326112068522" transform="translate(0,0)">0</text><text x="24.331910698425503" y="55.97752659917389" transform="translate(0,0)">50</text><text x="85" y="14" transform="translate(0,0)">100</text><text x="148.7476877432788" y="55.97752659917389" transform="translate(0,0)">150</text><text x="133.79036790187178" y="130.08326112068522" transform="translate(0,0)">200</text></g></g><g class="dxg-value-indicator" fill="#7c38bc" transform="translate(0,0) rotate(-39.150000000000006,85,77)"><path d="M 83 77 L 85 43 L 87 77 Z" transform="translate(0,0)"></path><circle cx="85" cy="77" r="6" class="dxg-spindle-border"></circle><circle cx="85" cy="77" r="5" class="dxg-spindle-hole" fill="#ffffff"></circle></g><g class="dxg-tracker" stroke="none" stroke-width="0" fill="#000000" opacity="0.0001"><path d="M 75 43 L 75 77 L 95 77 L 95 43 Z" transform="translate(0,0) rotate(-39.150000000000006,85,77)"></path></g></svg></div>
            </div>
            <div id="realtime-network-stats" style="height: 320px" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxc dxc-chart" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;touch-action:pan-x pan-y pinch-zoom;-ms-touch-action:pan-x pan-y pinch-zoom;" direction="ltr" width="534" height="320" onclick="void(0)"><rect x="0" y="0" width="534" height="320" transform="translate(0,0)" fill="gray" opacity="0.0001"></rect><defs><clipPath id="DevExpress_41"><rect x="0" y="0" width="534" height="320" transform="translate(0,0)"></rect></clipPath><pattern id="DevExpress_42" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.75"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_43" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#7c38bc" opacity="0.5"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#7c38bc" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_44" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#000" opacity="0.75"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#000" transform="translate(0,0)"></path></pattern><pattern id="DevExpress_45" width="6" height="6" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="6" height="6" transform="translate(0,0)" fill="#000" opacity="0.5"></rect><path d="M 3 -3 L -3 3 M 0 6 L 6 0 M 9 3 L 3 9" stroke-width="2" stroke="#000" transform="translate(0,0)"></path></pattern><clipPath id="DevExpress_46"><rect x="0" y="0" width="534" height="320" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_47"><rect x="0" y="0" width="534" height="320" transform="translate(0,0)"></rect></clipPath><clipPath id="DevExpress_48"><rect x="0" y="0" width="534" height="320" transform="translate(0,0)"></rect></clipPath></defs><g class="dxc-background"></g><g class="dxc-strips-group"><g class="dxc-arg-strips" clip-path="url(#DevExpress_46)"></g><g class="dxc-val-strips" clip-path="url(#DevExpress_46)"></g></g><g class="dxc-grids-group"><g class="dxc-val-grid"><path d="M 0 320 L 534 320" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 290 L 534 290" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 259 L 534 259" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 229 L 534 229" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 198 L 534 198" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 168 L 534 168" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 137 L 534 137" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 107 L 534 107" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 76 L 534 76" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 46 L 534 46" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 0 15 L 534 15" transform="translate(0,0.5)" stroke="#f5f5f5" stroke-width="1"></path></g><g class="dxc-arg-grid"><path d="M 0 320 L 0 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 53 320 L 53 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 107 320 L 107 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 160 320 L 160 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 214 320 L 214 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 267 320 L 267 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 320 320 L 320 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 374 320 L 374 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 427 320 L 427 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 481 320 L 481 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path><path d="M 534 320 L 534 0" transform="translate(0.5,0)" stroke="#f5f5f5" stroke-width="1"></path></g></g><g class="dxc-axes-group"><g class="dxc-arg-axis" clip-path="url(#DevExpress_41)"><g class="dxc-arg-elements"></g><g class="dxc-arg-line"></g><g class="dxc-arg-title"></g></g><g class="dxc-val-axis" clip-path="url(#DevExpress_41)"><g class="dxc-val-elements"></g><g class="dxc-val-line"></g><g class="dxc-val-title"></g></g></g><g class="dxc-constant-lines-group"><g class="dxc-arg-constant-lines"></g><g class="dxc-val-constant-lines"></g></g><g class="dxc-strips-labels-group"><g class="dxc-arg-axis-labels"></g><g class="dxc-val-axis-labels"></g></g><g class="dxc-border"></g><g class="dxc-series-group"><g class="dxc-series"><g class="dxc-elements" stroke="none" fill="#7c38bc" opacity="0.4" clip-path="url(#DevExpress_47)"><path d="M 0 232 L 5 240 L 11 231 L 16 234 L 21 240 L 27 230 L 32 236 L 37 230 L 43 238 L 48 240 L 53 237 L 59 232 L 64 236 L 69 233 L 75 240 L 80 232 L 85 240 L 91 238 L 96 237 L 101 232 L 107 241 L 112 236 L 117 236 L 123 237 L 128 232 L 134 239 L 139 232 L 144 234 L 150 240 L 155 232 L 160 238 L 166 239 L 171 239 L 176 240 L 182 235 L 187 236 L 192 233 L 198 236 L 203 230 L 208 232 L 214 238 L 219 238 L 224 232 L 230 237 L 235 232 L 240 236 L 246 240 L 251 231 L 256 236 L 262 238 L 267 230 L 272 229 L 278 237 L 283 229 L 288 239 L 294 237 L 299 229 L 304 233 L 310 230 L 315 229 L 320 230 L 326 241 L 331 240 L 336 238 L 342 238 L 347 229 L 352 230 L 358 238 L 363 229 L 368 230 L 374 236 L 379 234 L 384 232 L 390 241 L 395 237 L 401 230 L 406 231 L 411 233 L 417 235 L 422 240 L 427 238 L 433 239 L 438 233 L 443 232 L 449 238 L 454 238 L 459 229 L 465 233 L 470 238 L 475 240 L 481 236 L 486 241 L 491 234 L 497 233 L 502 229 L 507 229 L 513 229 L 518 236 L 523 233 L 529 230 L 534 239 L 534 320 L 529 320 L 523 320 L 518 320 L 513 320 L 507 320 L 502 320 L 497 320 L 491 320 L 486 320 L 481 320 L 475 320 L 470 320 L 465 320 L 459 320 L 454 320 L 449 320 L 443 320 L 438 320 L 433 320 L 427 320 L 422 320 L 417 320 L 411 320 L 406 320 L 401 320 L 395 320 L 390 320 L 384 320 L 379 320 L 374 320 L 368 320 L 363 320 L 358 320 L 352 320 L 347 320 L 342 320 L 336 320 L 331 320 L 326 320 L 320 320 L 315 320 L 310 320 L 304 320 L 299 320 L 294 320 L 288 320 L 283 320 L 278 320 L 272 320 L 267 320 L 262 320 L 256 320 L 251 320 L 246 320 L 240 320 L 235 320 L 230 320 L 224 320 L 219 320 L 214 320 L 208 320 L 203 320 L 198 320 L 192 320 L 187 320 L 182 320 L 176 320 L 171 320 L 166 320 L 160 320 L 155 320 L 150 320 L 144 320 L 139 320 L 134 320 L 128 320 L 123 320 L 117 320 L 112 320 L 107 320 L 101 320 L 96 320 L 91 320 L 85 320 L 80 320 L 75 320 L 69 320 L 64 320 L 59 320 L 53 320 L 48 320 L 43 320 L 37 320 L 32 320 L 27 320 L 21 320 L 16 320 L 11 320 L 5 320 L 0 320 Z" transform="translate(0,0)"></path></g><g fill="#7c38bc" stroke="#7c38bc" stroke-width="0" r="6" visibility="hidden" class="dxc-markers" opacity="1" clip-path=""></g><g class="dxc-error-bars" stroke="#000000" stroke-width="2" opacity="1" stroke-linecap="square" clip-path="url(#DevExpress_48)" transform="translate(0,0)"></g><g fill="gray" opacity="0.001" stroke="gray" class="dxc-trackers" clip-path="url(#DevExpress_47)"><path d="M 0 232 L 5 240 L 11 231 L 16 234 L 21 240 L 27 230 L 32 236 L 37 230 L 43 238 L 48 240 L 53 237 L 59 232 L 64 236 L 69 233 L 75 240 L 80 232 L 85 240 L 91 238 L 96 237 L 101 232 L 107 241 L 112 236 L 117 236 L 123 237 L 128 232 L 134 239 L 139 232 L 144 234 L 150 240 L 155 232 L 160 238 L 166 239 L 171 239 L 176 240 L 182 235 L 187 236 L 192 233 L 198 236 L 203 230 L 208 232 L 214 238 L 219 238 L 224 232 L 230 237 L 235 232 L 240 236 L 246 240 L 251 231 L 256 236 L 262 238 L 267 230 L 272 229 L 278 237 L 283 229 L 288 239 L 294 237 L 299 229 L 304 233 L 310 230 L 315 229 L 320 230 L 326 241 L 331 240 L 336 238 L 342 238 L 347 229 L 352 230 L 358 238 L 363 229 L 368 230 L 374 236 L 379 234 L 384 232 L 390 241 L 395 237 L 401 230 L 406 231 L 411 233 L 417 235 L 422 240 L 427 238 L 433 239 L 438 233 L 443 232 L 449 238 L 454 238 L 459 229 L 465 233 L 470 238 L 475 240 L 481 236 L 486 241 L 491 234 L 497 233 L 502 229 L 507 229 L 513 229 L 518 236 L 523 233 L 529 230 L 534 239 L 534 320 L 529 320 L 523 320 L 518 320 L 513 320 L 507 320 L 502 320 L 497 320 L 491 320 L 486 320 L 481 320 L 475 320 L 470 320 L 465 320 L 459 320 L 454 320 L 449 320 L 443 320 L 438 320 L 433 320 L 427 320 L 422 320 L 417 320 L 411 320 L 406 320 L 401 320 L 395 320 L 390 320 L 384 320 L 379 320 L 374 320 L 368 320 L 363 320 L 358 320 L 352 320 L 347 320 L 342 320 L 336 320 L 331 320 L 326 320 L 320 320 L 315 320 L 310 320 L 304 320 L 299 320 L 294 320 L 288 320 L 283 320 L 278 320 L 272 320 L 267 320 L 262 320 L 256 320 L 251 320 L 246 320 L 240 320 L 235 320 L 230 320 L 224 320 L 219 320 L 214 320 L 208 320 L 203 320 L 198 320 L 192 320 L 187 320 L 182 320 L 176 320 L 171 320 L 166 320 L 160 320 L 155 320 L 150 320 L 144 320 L 139 320 L 134 320 L 128 320 L 123 320 L 117 320 L 112 320 L 107 320 L 101 320 L 96 320 L 91 320 L 85 320 L 80 320 L 75 320 L 69 320 L 64 320 L 59 320 L 53 320 L 48 320 L 43 320 L 37 320 L 32 320 L 27 320 L 21 320 L 16 320 L 11 320 L 5 320 L 0 320 Z" transform="translate(0,0)" stroke-width="0"></path></g></g><g class="dxc-series"><g class="dxc-elements" stroke="none" fill="#000" opacity="0.5" clip-path="url(#DevExpress_47)"><path d="M 0 296 L 5 290 L 11 296 L 16 296 L 21 293 L 27 293 L 32 294 L 37 292 L 43 293 L 48 291 L 53 294 L 59 292 L 64 290 L 69 296 L 75 294 L 80 296 L 85 296 L 91 292 L 96 290 L 101 290 L 107 294 L 112 290 L 117 296 L 123 294 L 128 296 L 134 292 L 139 294 L 144 294 L 150 294 L 155 295 L 160 290 L 166 293 L 171 292 L 176 291 L 182 294 L 187 295 L 192 290 L 198 296 L 203 290 L 208 293 L 214 293 L 219 292 L 224 290 L 230 291 L 235 290 L 240 296 L 246 292 L 251 291 L 256 296 L 262 290 L 267 293 L 272 291 L 278 291 L 283 294 L 288 296 L 294 291 L 299 290 L 304 294 L 310 290 L 315 295 L 320 294 L 326 291 L 331 294 L 336 291 L 342 290 L 347 294 L 352 292 L 358 296 L 363 294 L 368 290 L 374 293 L 379 291 L 384 296 L 390 294 L 395 290 L 401 296 L 406 290 L 411 294 L 417 295 L 422 291 L 427 290 L 433 296 L 438 294 L 443 294 L 449 294 L 454 293 L 459 294 L 465 294 L 470 294 L 475 294 L 481 294 L 486 294 L 491 291 L 497 292 L 502 292 L 507 290 L 513 292 L 518 296 L 523 291 L 529 293 L 534 296 L 534 320 L 529 320 L 523 320 L 518 320 L 513 320 L 507 320 L 502 320 L 497 320 L 491 320 L 486 320 L 481 320 L 475 320 L 470 320 L 465 320 L 459 320 L 454 320 L 449 320 L 443 320 L 438 320 L 433 320 L 427 320 L 422 320 L 417 320 L 411 320 L 406 320 L 401 320 L 395 320 L 390 320 L 384 320 L 379 320 L 374 320 L 368 320 L 363 320 L 358 320 L 352 320 L 347 320 L 342 320 L 336 320 L 331 320 L 326 320 L 320 320 L 315 320 L 310 320 L 304 320 L 299 320 L 294 320 L 288 320 L 283 320 L 278 320 L 272 320 L 267 320 L 262 320 L 256 320 L 251 320 L 246 320 L 240 320 L 235 320 L 230 320 L 224 320 L 219 320 L 214 320 L 208 320 L 203 320 L 198 320 L 192 320 L 187 320 L 182 320 L 176 320 L 171 320 L 166 320 L 160 320 L 155 320 L 150 320 L 144 320 L 139 320 L 134 320 L 128 320 L 123 320 L 117 320 L 112 320 L 107 320 L 101 320 L 96 320 L 91 320 L 85 320 L 80 320 L 75 320 L 69 320 L 64 320 L 59 320 L 53 320 L 48 320 L 43 320 L 37 320 L 32 320 L 27 320 L 21 320 L 16 320 L 11 320 L 5 320 L 0 320 Z" transform="translate(0,0)"></path></g><g fill="#000" stroke="#000" stroke-width="0" r="6" visibility="hidden" class="dxc-markers" opacity="1" clip-path=""></g><g class="dxc-error-bars" stroke="#000000" stroke-width="2" opacity="1" stroke-linecap="square" clip-path="url(#DevExpress_48)" transform="translate(0,0)"></g><g fill="gray" opacity="0.001" stroke="gray" class="dxc-trackers" clip-path="url(#DevExpress_47)"><path d="M 0 296 L 5 290 L 11 296 L 16 296 L 21 293 L 27 293 L 32 294 L 37 292 L 43 293 L 48 291 L 53 294 L 59 292 L 64 290 L 69 296 L 75 294 L 80 296 L 85 296 L 91 292 L 96 290 L 101 290 L 107 294 L 112 290 L 117 296 L 123 294 L 128 296 L 134 292 L 139 294 L 144 294 L 150 294 L 155 295 L 160 290 L 166 293 L 171 292 L 176 291 L 182 294 L 187 295 L 192 290 L 198 296 L 203 290 L 208 293 L 214 293 L 219 292 L 224 290 L 230 291 L 235 290 L 240 296 L 246 292 L 251 291 L 256 296 L 262 290 L 267 293 L 272 291 L 278 291 L 283 294 L 288 296 L 294 291 L 299 290 L 304 294 L 310 290 L 315 295 L 320 294 L 326 291 L 331 294 L 336 291 L 342 290 L 347 294 L 352 292 L 358 296 L 363 294 L 368 290 L 374 293 L 379 291 L 384 296 L 390 294 L 395 290 L 401 296 L 406 290 L 411 294 L 417 295 L 422 291 L 427 290 L 433 296 L 438 294 L 443 294 L 449 294 L 454 293 L 459 294 L 465 294 L 470 294 L 475 294 L 481 294 L 486 294 L 491 291 L 497 292 L 502 292 L 507 290 L 513 292 L 518 296 L 523 291 L 529 293 L 534 296 L 534 320 L 529 320 L 523 320 L 518 320 L 513 320 L 507 320 L 502 320 L 497 320 L 491 320 L 486 320 L 481 320 L 475 320 L 470 320 L 465 320 L 459 320 L 454 320 L 449 320 L 443 320 L 438 320 L 433 320 L 427 320 L 422 320 L 417 320 L 411 320 L 406 320 L 401 320 L 395 320 L 390 320 L 384 320 L 379 320 L 374 320 L 368 320 L 363 320 L 358 320 L 352 320 L 347 320 L 342 320 L 336 320 L 331 320 L 326 320 L 320 320 L 315 320 L 310 320 L 304 320 L 299 320 L 294 320 L 288 320 L 283 320 L 278 320 L 272 320 L 267 320 L 262 320 L 256 320 L 251 320 L 246 320 L 240 320 L 235 320 L 230 320 L 224 320 L 219 320 L 214 320 L 208 320 L 203 320 L 198 320 L 192 320 L 187 320 L 182 320 L 176 320 L 171 320 L 166 320 L 160 320 L 155 320 L 150 320 L 144 320 L 139 320 L 134 320 L 128 320 L 123 320 L 117 320 L 112 320 L 107 320 L 101 320 L 96 320 L 91 320 L 85 320 L 80 320 L 75 320 L 69 320 L 64 320 L 59 320 L 53 320 L 48 320 L 43 320 L 37 320 L 32 320 L 27 320 L 21 320 L 16 320 L 11 320 L 5 320 L 0 320 Z" transform="translate(0,0)" stroke-width="0"></path></g></g></g><g class="dxc-labels-group"><g class="dxc-labels" visibility="hidden" clip-path="url(#DevExpress_47)" transform="translate(0,0)"></g><g class="dxc-labels" visibility="hidden" clip-path="url(#DevExpress_47)" transform="translate(0,0)"></g></g><g class="dxc-crosshair-cursor"></g><g class="dxc-legend" clip-path="url(#DevExpress_41)"></g></svg></div>
        </div>

        <div class="chart-item-bg">
            <div class="chart-label">
                <div id="network-mbs-packets" class="h1 text-secondary text-bold" data-count="this" data-from="0.00" data-to="67.35" data-suffix="%" data-duration="1.5">67.35%</div>
                <span class="text-small text-muted text-upper">CPU Usage</span>

                <p class="text-medium" style="width: 50%; margin-top: 10px">Sentiments two occasional affronting solicitude travelling and one contrasted. Fortune day out married parties.</p>
            </div>
            <div id="other-stats" style="min-height: 183px">
                <div id="cpu-usage-gauge" style="width: 170px; height: 140px; position: absolute; right: 20px; top: 20px" class="dx-visibility-change-handler"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" fill="none" stroke="none" stroke-width="0" class="dxg dxg-circular-gauge" style="line-height:normal;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);display:block;overflow:hidden;" direction="ltr" width="170" height="140"><defs></defs><g class="dxg-range-container"><path d="M 41.57766 59.01388 A 47.00000 47.00000 0 0 0 51.76598 110.23402 L 53.88730 108.11270 A 44.00000 44.00000 0 0 1 44.34930 60.16193 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#68b828" class="dxg-range dxg-range-0"></path><path d="M 85.00000 30.00000 A 47.00000 47.00000 0 0 0 41.57766 59.01388 L 44.34930 60.16193 A 44.00000 44.00000 0 0 1 85.00000 33.00000 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#68b828" class="dxg-range dxg-range-1"></path><path d="M 128.42234 59.01388 A 47.00000 47.00000 0 0 0 85.00000 30.00000 L 85.00000 33.00000 A 44.00000 44.00000 0 0 1 125.65070 60.16193 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#68b828" class="dxg-range dxg-range-2"></path><path d="M 118.23402 110.23402 A 47.00000 47.00000 0 0 0 128.42234 59.01388 L 125.65070 60.16193 A 44.00000 44.00000 0 0 1 116.11270 108.11270 Z" transform="translate(0,0)" stroke-linejoin="round" fill="#d5080f" class="dxg-range dxg-range-3"></path></g><g class="dxg-scale"><g class="dxg-major-ticks" fill="#ffffff"><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(-135,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(-67.5,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(67.5,85,77)"></path><path d="M 84 28 L 86 28 L 86 33 L 84 33 Z" transform="translate(0,0) rotate(135,85,77)"></path></g><g class="dxg-labels" text-anchor="middle" style="fill:#a8a8a8;font-family:'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;font-weight:400;font-size:12px;cursor:default;"><text x="40.92367730603853" y="130.08326112068522" transform="translate(0,0)">0</text><text x="24.331910698425503" y="55.97752659917389" transform="translate(0,0)">25</text><text x="85" y="14" transform="translate(0,0)">50</text><text x="145.6680893015745" y="55.97752659917389" transform="translate(0,0)">75</text><text x="133.79036790187178" y="130.08326112068522" transform="translate(0,0)">100</text></g></g><g class="dxg-value-indicator" fill="#68b828" transform="translate(0,0) rotate(29.69999999999999,85,77)"><path d="M 84 77 L 84 43 L 86 43 L 86 77 Z" transform="translate(0,0)"></path><circle cx="85" cy="77" r="6" class="dxg-spindle-border"></circle><circle cx="85" cy="77" r="5" class="dxg-spindle-hole" fill="#ffffff"></circle></g><g class="dxg-tracker" stroke="none" stroke-width="0" fill="#000000" opacity="0.0001"><path d="M 75 43 L 75 77 L 95 77 L 95 43 Z" transform="translate(0,0) rotate(29.69999999999999,85,77)"></path></g></svg></div>
            </div>
        </div>

    </div>
</div>