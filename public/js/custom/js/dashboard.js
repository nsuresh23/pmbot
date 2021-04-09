/*Dashboard Init*/

"use strict";

/*****Ready function start*****/
$(document).ready(function() {
    $('#statement').DataTable({
        "bFilter": false,
        "bLengthChange": false,
        "bPaginate": false,
        "bInfo": false,
    });
});
/*****Ready function end*****/

/*****Load function start*****/
// $(window).on("load",function(){
// 	window.setTimeout(function(){
// 		$.toast({
// 			heading: 'Welcome to Goofy',
// 			text: 'Use the predefined ones, or specify a custom position object.',
// 			position: 'bottom-left',
// 			loaderBg:'#f8b32d',
// 			icon: '',
// 			hideAfter: 3500,
// 			stack: 6
// 		});
// 	}, 3000);
// });
/*****Load function* end*****/


/*****E-Charts function start*****/
var echartsConfig = function() {
        if ($('#e_chart_1').length > 0) {
            var eChart_1 = echarts.init(document.getElementById('e_chart_1'));
            var seriesData = [{
                    name: '2011',
                    type: 'bar',
                    data: [320, 332, 301, 334, 390, 330, 320, 334, 390, 330, 320, 301]
                },

                {
                    name: '2012',
                    type: 'bar',
                    data: [320, 332, 301, 334, 390, 330, 320, 334, 390, 330, 320, 301]
                }
            ];
            var option = {
                color: ['#0FC5BB', '#92F2EF', '#D0F6F5'],
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(33,33,33,1)',
                    borderRadius: 0,
                    padding: 10,
                    axisPointer: {
                        type: 'cross',
                        label: {
                            backgroundColor: 'rgba(33,33,33,1)'
                        }
                    },
                    textStyle: {
                        color: '#fff',
                        fontStyle: 'normal',
                        fontWeight: 'normal',
                        fontFamily: "'Open Sans', sans-serif",
                        fontSize: 12
                    }
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    showTitle: false,
                    feature: {
                        mark: { show: true },
                        magicType: { show: true, type: ['line', 'bar', 'stack', 'tiled'] },
                        restore: { show: true },
                    }
                },
                grid: {
                    left: '3%',
                    right: '10%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{
                    // type : 'category',
                    // data : ['2011','2012','2013','2014','2015','2016','2017'],
                    // axisLine: {
                    // 	show:false
                    // },
                    // axisLabel: {
                    // 	textStyle: {
                    // 		color: '#878787',
                    // 		fontFamily: "'Open Sans', sans-serif",
                    // 		fontSize: 12
                    // 	}
                    // },
                    type: 'category',
                    // data : [
                    //     { key: 'Jan', label: 'January' },
                    //     { key: 'Feb', label: 'February'},
                    //     { key: 'Mar', label: 'March' },
                    //     { key: 'Apr', label: 'April' },
                    //     { key: 'May', label: 'March' },
                    //     { key: 'Jun', label: 'June' },
                    //     { key: 'Jul', label: 'July' },
                    //     { key: 'Aug', label: 'August' },
                    //     { key: 'Sep', label: 'September'},
                    //     { key: 'Oct', label: 'October' },
                    //     { key: 'Nov', label: 'November' },
                    //     { key: 'Dec', label: 'December' }
                    // ],
                    data: ['January', 'February', 'March', 'April', 'March', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    // axisLabel: {
                    //     // force to display all labels
                    //     interval: 0,
                    //     formatter: function(d) {
                    //         return d.label;
                    //     }
                    // }
                    axisTick: {
                        alignWithLabel: true
                    },
                }],
                yAxis: [{
                    type: 'value',
                    axisLine: {
                        show: false
                    },
                    axisLabel: {
                        textStyle: {
                            color: '#878787',
                            fontFamily: "'Open Sans', sans-serif",
                            fontSize: 12
                        }
                    },
                    splitLine: {
                        show: false,
                    }
                }],
                dataZoom: [{
                    type: 'slider',
                    height: 8,
                    // top: 290,
                    // bottom: 0,
                    borderColor: 'transparent',
                    backgroundColor: '#e2e2e2',
                    handleIcon: 'M10.7,11.9H9.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4h1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7v-1.2h6.6z M13.3,22H6.7v-1.2h6.6z M13.3,19.6H6.7v-1.2h6.6z', // jshint ignore:line
                    handleSize: 20,
                    handleStyle: {
                        shadowBlur: 6,
                        shadowOffsetX: 1,
                        shadowOffsetY: 2,
                        shadowColor: '#aaa'
                    }
                }, {
                    type: 'inside',
                }],
                // series : [
                // 	{
                // 		name:'2011',
                // 		type:'bar',
                // 		data:[320, 332, 301, 334, 390, 330, 320, 334, 390, 330, 320, 301]
                // 	},

                // 	{
                // 		name:'2012',
                // 		type:'bar',
                // 		stack: 'st1',
                // 		data:[320, 332, 301, 334, 390, 330, 320, 334, 390, 330, 320, 301]
                // 	}
                // 	// {
                // 	// 	name:'2',
                // 	// 	type:'line',
                // 	// 	stack: 'st1',
                // 	// 	data:[120, 132, 101, 134, 90, 230, 210]
                // 	// },
                // 	// {
                // 	// 	name:'2',
                // 	// 	type:'bar',
                // 	// 	stack: 'st1',
                // 	// 	data:[220, 182, 191, 234, 290, 330, 310]
                // 	// }
                // ]
                series: seriesData
            };

            eChart_1.setOption(option);
            eChart_1.resize();
        }
        if ($('#e_chart_2').length > 0) {
            var eChart_2 = echarts.init(document.getElementById('e_chart_2'));
            var option1 = {
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(33,33,33,1)',
                    borderRadius: 0,
                    padding: 10,
                    axisPointer: {
                        type: 'cross',
                        label: {
                            backgroundColor: 'rgba(33,33,33,1)'
                        }
                    },
                    textStyle: {
                        color: '#fff',
                        fontStyle: 'normal',
                        fontWeight: 'normal',
                        fontFamily: "'Open Sans', sans-serif",
                        fontSize: 12
                    }
                },
                yAxis: {
                    type: 'value',
                    axisTick: {
                        show: false
                    },
                    axisLine: {
                        show: false,
                        lineStyle: {
                            color: '#fff',
                        }
                    },
                    splitLine: {
                        show: false,
                    },
                },
                xAxis: [{
                        type: 'category',
                        axisTick: {
                            show: false
                        },
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: '#fff',
                            }
                        },
                        data: ['Dt1', 'Dt2', 'Dt3']
                    }, {
                        type: 'category',
                        axisLine: {
                            show: false
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        splitArea: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        },
                        data: ['Dt1', 'Dt2', 'Dt3']
                    },

                ],
                series: [{
                        name: 'Appoinment1',
                        type: 'bar',
                        xAxisIndex: 1,

                        itemStyle: {
                            normal: {
                                show: true,
                                color: '#0FC5BB',
                                barBorderRadius: 0,
                                borderWidth: 0,
                                borderColor: '#fff',
                            }
                        },
                        barWidth: '20%',
                        data: [1000, 1000, 1000]
                    }, {
                        name: 'Appoinment2',
                        type: 'bar',
                        xAxisIndex: 1,

                        itemStyle: {
                            normal: {
                                show: true,
                                color: '#0FC5BB',
                                barBorderRadius: 0,
                                borderWidth: 0,
                                borderColor: '#fff',
                            }
                        },
                        barWidth: '30%',
                        barGap: '100%',
                        data: [1000, 1000, 1000]
                    }, {
                        name: 'Appoinment3',
                        type: 'line',
                        itemStyle: {
                            normal: {
                                show: true,
                                color: '#0FC5BB',
                                barBorderRadius: 0,
                                borderWidth: 0,
                                borderColor: '#fff',
                            }
                        },
                        label: {
                            normal: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#fff'
                                }
                            }
                        },
                        barWidth: '20%',
                        data: [398, 419, 452]
                    }, {
                        name: 'Appoinment4',
                        type: 'bar',
                        barWidth: '30%',
                        itemStyle: {
                            normal: {
                                show: true,
                                color: '#92F2EF',
                                barBorderRadius: 0,
                                borderWidth: 0,
                                borderColor: '#fff',
                            }
                        },
                        label: {
                            normal: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#fff'
                                }
                            }
                        },
                        barGap: '100%',
                        data: [425, 437, 484]
                    }

                ]
            };

            eChart_2.setOption(option1);
            eChart_2.resize();
        }
        if ($('#e_chart_3').length > 0) {
            var eChart_3 = echarts.init(document.getElementById('e_chart_3'));
            var colors = ['#007153', '#92F2EF'];
            var option3 = {
                tooltip: {
                    backgroundColor: 'rgba(33,33,33,1)',
                    borderRadius: 0,
                    padding: 10,
                    textStyle: {
                        color: '#fff',
                        fontStyle: 'normal',
                        fontWeight: 'normal',
                        fontFamily: "'Open Sans', sans-serif",
                        fontSize: 12
                    }
                },
                series: [{
                    name: '',
                    type: 'pie',
                    radius: ['20%', '60%'],
                    color: ['#0FC5BB', '#0FC5BB', '#0FC5BB', '#92F2EF'],
                    label: {
                        normal: {
                            formatter: '{b}\n{d}%'
                        },

                    },
                    data: [
                        { value: 435, name: '' },
                        { value: 679, name: '' },
                        { value: 848, name: '' },
                        { value: 348, name: '' },
                    ]
                }]
            };
            eChart_3.setOption(option3);
            eChart_3.resize();
        }
    }
    /*****E-Charts function end*****/

/*****Sparkline function start*****/
var sparklineLogin = function() {
        if ($('#sparkline_1').length > 0) {
            $("#sparkline_1").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                type: 'line',
                width: '100%',
                height: '35',
                lineColor: '#0FC5BB',
                fillColor: '#0FC5BB',
                minSpotColor: '#0FC5BB',
                maxSpotColor: '#0FC5BB',
                spotColor: '#0FC5BB',
                highlightLineColor: '#0FC5BB',
                highlightSpotColor: '#0FC5BB'
            });
        }
    }
    /*****Sparkline function end*****/

/*****Resize function start*****/
var sparkResize, echartResize;
$(window).on("resize", function() {
    /*Sparkline Resize*/
    clearTimeout(sparkResize);
    sparkResize = setTimeout(sparklineLogin, 200);

    /*E-Chart Resize*/
    clearTimeout(echartResize);
    echartResize = setTimeout(echartsConfig, 200);
}).resize();
/*****Resize function end*****/

/*****Function Call start*****/
sparklineLogin();
echartsConfig();
/*****Function Call end*****/

// $(document).on('click', '#financialTab', function(e) {

//     e.preventDefault();

//     /*Sparkline Resize*/
// 	clearTimeout(sparkResize);
// 	sparkResize = setTimeout(sparklineLogin, 200);

// 	/*E-Chart Resize*/
// 	clearTimeout(echartResize);
// 	echartResize = setTimeout(echartsConfig, 200);

//     $('#financial').show();

// });

$(document).on('click', '.dashboard-job-tabs', function(e) {
    $('.dashboard-job-panel').collapse("show");
});

$(document).on('click', '.dashboard-task-tabs', function(e) {
    $('.dashboard-task-panel').collapse("show");
});

$(document).on('click', '.new-job-btn', function(e) {

    e.preventDefault();

    if ($('.new-job-modal').attr('class') != undefined) {

        $('.job-add-form').trigger('reset');

        $(".job-pm-empcode").select2().val(null);
        $('.job-pm-empcode').select2().trigger('change');

        $('.new-job-modal').modal('show');

    }

});

function jobAdd(postUrl, params, modalSelector) {

    if (postUrl != undefined && postUrl != '') {

        /* AJAX call to email item info */

        var type = 'error';

        var message = '';

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            if (response.redirectTo != undefined && response.redirectTo != '') {

                window.location = response.redirectTo;

            }


        });

        $(modalSelector).modal('hide');

        return d.promise();


    }
}

$(document).on('click', '.job-add-submit-btn', function(e) {

    if ($('.job-isbn').attr('class') == undefined || $('.job-isbn').val() == '') {

        return true;

    }

    if ($('.job-pm-empcode').attr('class') == undefined || $('.job-pm-empcode').val() == '') {

        return true;

    }

    if ($('.job-due-date').attr('class') == undefined || $('.job-due-date').val() == '') {

        return true;

    }

    e.preventDefault();

    // var postUrl = $('.job-add-form').attr('action');

    // var params = $('.job-add-form').serialize();

    // jobAdd(postUrl, params, '.new-job-modal');

    $('.job-add-form').submit();

});

$(document).on('shown.bs.tab', '#overviewTab', function(e) {

    if ($('.membersTab').attr('class') != undefined) {

        $('.membersTab').hide();

    }

    // var dataUrl = $('.jobOverviewTab').attr('data-member-job-count-url');

    // var empcode = 'overview';

    // if (dataUrl != undefined && dataUrl != "") {

    //     getMemberJobCount(dataUrl, empcode);

    // }


});

$(document).on('shown.bs.tab', '#taskCalendarTab', function(e) {

    var taskCalendarElement = $('.task-calendar').fullCalendar({

        header: {
            left: 'prev,next today',
            center: 'title',
            // right: 'month,agendaWeek,agendaDay'
            right: ''
        },
        // selectable: true,
        // editable: true,
        // droppable: true, // this allows things to be dropped onto the calendar
        // eventLimit: true, // allow "more" link when too many events
        eventBackgroundColor: '#f8b32d',
        displayEventTime: false,
        eventRender: function(event, taskCalendarElement) {
            taskCalendarElement.find('.fc-title').html(taskCalendarElement.find('.fc-title').text());
        },
        eventClick: function(event, jsEvent, view) {
            var date = moment(event.start).format('YYYY-MM-DD');
            var gridSelector = ".taskCalendarGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                $(gridSelector).attr('data-task-date', date);

                getTaskTableList(gridSelector);

                $('.task-calendar').fullCalendar('select', date);

                $('.taskCalendarGrid .jsgrid-grid-body').slimscroll({
                    height: '380px',
                });

            }


        }
    });

    taskCalendarElement.find('.fc-today-button').click(function() {

        var postUrl = $('.task-calendar').attr('data-post-url');

        var date = moment($('.task-calendar').fullCalendar('getDate')).format('YYYY-MM-DD');

        taskCalendar(postUrl, date);

        var gridSelector = ".taskCalendarGrid";

        var dataUrl = $(gridSelector).attr('data-list-url');

        if (dataUrl != undefined && dataUrl != "") {

            $(gridSelector).attr('data-task-date', date);

            getTaskTableList(gridSelector);

            $('.task-calendar').fullCalendar('select', date);

            $('.taskCalendarGrid .jsgrid-grid-body').slimscroll({
                height: '380px',
            });

        }

    });

    if ($('.task-calendar').attr('class') != undefined) {

        if ($('.task-calendar').attr('data-post-url') != undefined && $('.task-calendar').attr('data-post-url') != '') {

            var postUrl = $('.task-calendar').attr('data-post-url');

            var date = moment($('.task-calendar').fullCalendar('getDate')).format('YYYY-MM-DD');

            taskCalendar(postUrl, date);

            var gridSelector = ".taskCalendarGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                $(gridSelector).attr('data-task-date', date);

                getTaskTableList(gridSelector);

                $('.task-calendar').fullCalendar('select', date);

                $('.taskCalendarGrid .jsgrid-grid-body').slimscroll({
                    height: '380px',
                });

            }

        }
    }

});

$(document).on('click', '.fc-prev-button', function() {

    var postUrl = $('.task-calendar').attr('data-post-url');

    var date = moment($('.task-calendar').fullCalendar('getDate')).format('YYYY-MM-DD');

    taskCalendar(postUrl, date);

    var gridSelector = ".taskCalendarGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-task-date', date);

        getTaskTableList(gridSelector);

        $('.task-calendar').fullCalendar('select', date);

        $('.taskCalendarGrid .jsgrid-grid-body').slimscroll({
            height: '380px',
        });

    }

});

$(document).on('click', '.fc-next-button', function() {

    var postUrl = $('.task-calendar').attr('data-post-url');

    var date = moment($('.task-calendar').fullCalendar('getDate')).format('YYYY-MM-DD');

    taskCalendar(postUrl, date);

    var gridSelector = ".taskCalendarGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-task-date', date);

        getTaskTableList(gridSelector);

        $('.task-calendar').fullCalendar('select', date);

        $('.taskCalendarGrid .jsgrid-grid-body').slimscroll({
            height: '380px',
        });

    }

});

function taskCalendar(postUrl, date) {

    if (postUrl != undefined && postUrl != '' && date != undefined && date != '') {

        var params = {};

        params.day = moment(date, 'YYYY/MM/DD').format('DD');
        params.month = moment(date, 'YYYY/MM/DD').format('MM');
        params.year = moment(date, 'YYYY/MM/DD').format('YYYY');

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                $('.task-calendar').fullCalendar('removeEvents');

                $('.task-calendar').fullCalendar('addEventSource', response.data, true);

            } else {

                d.resolve();

            }

        });

        return d.promise();


    }
}

function eventCalendar() {

    $('.event-calendar-block').hide();
    $('.event-calendar-form-block').hide();

    var postUrl = $('#eventCalendarTab').attr('data-event-calendar-get-url');

    if (postUrl != undefined && postUrl != '') {

        var params = {};

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != undefined && response.data != '') {

                    if ('calendar_link' in response.data && response.data.calendar_link != '') {

                        $('.event-calendar-frame').attr('src', response.data.calendar_link);

                        $('.event-calendar-block').show();

                    }

                    if ('calendar_link' in response.data && (response.data.calendar_link == null || response.data.calendar_link == '')) {

                        $('.event-calendar-form-block').show();

                    }

                }

            } else {

                d.resolve();

            }

        });

        return d.promise();

    }

}

$(document).on('shown.bs.tab', '#eventCalendarTab', function(e) {

    eventCalendar();

});

$(document).on('click', '.event-calendar-save-btn', function() {

    var postUrl = $('.event-calendar-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        var params = {};

        var type = 'error';

        var message = '';

        params.calendar_link = $('#event-calendar-link').val();

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            eventCalendar();

            // $('#eventCalendarTab a[href="#eventCalendar"]').trigger('click');

            // $('#eventCalendarTab').trigger('click');

        });

        return d.promise();

    }

});

$('#emailReviewTab').hide();
