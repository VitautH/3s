$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    /*
     * Choose employee
     */
    $("#daily_choose_employee").change(function (e) {
        var employee_id = $(this).val();
        $.cookie("employee_id", employee_id);
        location.reload();
    });


    // date daily timesheet
    var d = new Date();
    var monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    $('.current_day').text(d.getDate());
    $('.current_month').text(monthNames[d.getMonth()]);
    $('.current_year').text(d.getFullYear());

    var current_week_range = $('.week_range:last').text();
    $('.week_range:last').addClass('current_week_range');
    var week_range_html = '<td><a href="javascript:void(0)" data-date="' + current_week_range + '" class="week_range">current week</a></td>';

    $('.week_range_list').append(week_range_html);

    currentDateHidden(d);


    // datepicker daily timesheet
    $('.calend').datepicker({
        weekStart: 1,
        todayHighlight: true
    });

    $('.calend').datepicker()
        .on('changeDate', function (res) {
            $('.current_day').text(res.date.getDate());
            $('.current_month').text(monthNames[res.date.getMonth()]);
            $('.current_year').text(res.date.getFullYear());
            currentDateHidden(res.date);
            var current_date = $('.current_date_hidden').text();
            var table_daily_timesheet = $('#table_daily_timesheet');
            ajaxWait();
            $.get('/admin/timesheet/' + current_date, function (res) {
                table_daily_timesheet.children().remove();
                ajaxWaitDelete();
                if (!res.error) {

                    res.forEach(function (elem) {

                        if (elem.note == null) {
                            elem.note = '';
                        }
                        if (elem.billable) {
                            billable_icon_class = 'billable_icon';
                        } else {
                            billable_icon_class = '';
                        }

                        var table_daily_html = '<tr data-id="' + elem.id + '">+' +
                            '<td class="first_cell_daily"><input class="checkbox_daily_item" data-id="' + elem.id + '"  type="checkbox"></td>' +
                            '<td class="project_time">' + minutesToHrsView(elem.duration) + '</td>' +
                            '<td class="project_task" data-task_id="' + elem.task_id + '">' + elem.task + '</td>' +
                            '<td class="project_client" data-client_id="' + elem.client_id + '">' + elem.client + '</td>' +
                            '<td class="project_project" data-project_id="' + elem.project_id + '">' + elem.project + '</td>' +
                            '<td class="text_note">' + elem.note + '</td>' +
                            '<td>' +
                            '<i class="fa fa-usd ' + billable_icon_class + '" data-id="' + elem.id + '"  aria-hidden="true"></i></td></tr>';

                        table_daily_timesheet.append(table_daily_html);

                    });

                }
                $('.daily_timesheet_total-time span').text(totalTime());
            })
        });

    $('#billable_check').click(function () {
        $(this).toggleClass("btn-secondary");
    });

    // checkboxes daily timesheet
    $('#select_all').click(function () {
        var delete_all = $("#delete_all");

        if ($(this).prop('checked') == true) {
            $('.checkbox_daily_item').prop('checked', true);
            delete_all.addClass("delete_active");
        } else {
            $('.checkbox_daily_item').prop('checked', false);
            delete_all.removeClass("delete_active");
        }

    });

    $('#delete_all').click(function () {
        var delete_all = $('#delete_all');
        var select_all = $('#select_all');
        if ($(this).hasClass('delete_active')) {
            if (confirm('Do you want to delete it?')) {
                var ids_to_delete = [];
                $('body').find('.checkbox_daily_item:checked').each(function () {
                    ids_to_delete.push(this.getAttribute("data-id"));
                });

                $.post('/admin/timesheet/delete', {id: ids_to_delete}, function (res) {
                    if (res.success) {
                        ids_to_delete.forEach(function (id) {
                            $('#table_daily_timesheet tr[data-id="' + id + '"]').remove();
                        });
                        select_all.prop('checked', false);
                        delete_all.removeClass('delete_active');
                        $('.daily_timesheet_total-time span').text(totalTime());
                    }
                    updateWeeklyTimesheet();
                });
            } else {
                select_all.prop('checked', false);
                $('.checkbox_daily_item').prop('checked', false);
                delete_all.removeClass('delete_active');
            }
        }

    });

    $('body').on('click', '.checkbox_daily_item', function () {
        $('#select_all').prop('checked', false);
        var delete_all = $("#delete_all");

        if ($(this).prop('checked') == true) {
            delete_all.addClass("delete_active");
        } else {
            delete_all.removeClass("delete_active");
            $('.checkbox_daily_item').each(function (i, el) {

                if (el.checked == true) {
                    delete_all.addClass("delete_active");
                    return;
                }

            });
        }

    });

    $('input[name="time"]').keyup(function () {
        var input_time = $('input[name="time"]');

        if ($(this).attr('data-type') == 'hrs') {
            var time = input_time.val().split(':');

            if (input_time.val().indexOf(":") < 0) {
                input_time.val("0:00");
            }

            if (time[1].length > 2) {
                time[1] = time[1].slice(0, -1);
                input_time.val(time[0] + ":" + time[1]);
            }

            if (time[1] > 59) {
                time[1] = 59;
                input_time.val(time[0] + ":" + time[1])
            }
        } else {
            $(this).val($(this).val().replace(/\D/, ''));
        }

    });

    // save daily time
    $("#daily_timesheet_form").submit(function (e) {
        e.preventDefault();
        var data = [];
        var billable_time_input = $("#billable_time_input");

        if ($('input[name="time"]').attr('data-type') == 'min') {
            data['time'] = $('input[name="time"]').val();

            if (isNaN(data['time'])) {
                errorMsg('Enter the numerical value of time!');
                billable_time_input.val('0');
                return false;
            }

            if (data['time'] < 1) {
                errorMsg('Enter a positive numeric time value!');
                billable_time_input.val('0');
                return false;
            }

            data['time'] = minutesToHrsView(data['time']);
        } else {
            data['time'] = $('input[name="time"]').val();
            var buf_arr = data['time'].split(':');

            if (isNaN(buf_arr[0]) || isNaN(buf_arr[1])) {
                errorMsg('Enter the numerical value of time!');
                billable_time_input.val('0:00');
                return false;
            }

            if (buf_arr[0] < 1 && buf_arr[1] < 1) {
                errorMsg('Enter a positive numeric time value!');
                billable_time_input.val('0:00');
                return false;
            }

            if (buf_arr[1].length > 2) {
                buf_arr[1] = buf_arr[1].slice(0, 2);

                if (parseInt(buf_arr[0]) < 1 && parseInt(buf_arr[1]) < 1) {
                    errorMsg('Enter the time in the correct format!');
                    billable_time_input.val('0:00');
                    return false;
                }

                data['time'] = data['time'].substring(0, data['time'].length - 1);
            }

            if (parseInt(buf_arr[0]) < 10) {
                data['time'] = data['time'].slice(1);
            }

            if (parseInt(buf_arr[0]) < 1) {
                data['time'] = '0' + data['time'];
            } else {
                data['time'] = buf_arr[0] + ":" + buf_arr[1];
            }
        }

        if ($("#billable_check").hasClass('btn-secondary')) {
            data['billable'] = 1;
        } else {
            data['billable'] = 0;
        }

        data['task_id'] = $('select[name="task"]').val();
        data['task'] = $('select[name="task"] option:selected').text();

        data['client_id'] = $('select[name="client"]').val();
        data['client'] = $('select[name="client"] option:selected').text();

        data['project_id'] = $('select[name="project"]').val();
        data['project'] = $('select[name="project"] option:selected').text();

        data['note'] = $("#billable_textarea").val();

        if (!data['task_id'] || !data['client_id'] || !data['project_id']) {
            errorMsg('All fields must be filled in!');
            return false;
        }
        ajaxWait();
        var url = "/admin/timesheet";
        if ($('#save_daily_time').attr('data-edit')) {
            var edit_id = $('#save_daily_time').attr('data-edit');
            url += '/update/' + edit_id;
        }
        // ajax request insert daily time sheet data
        $.post(url, {
            project_id: data['project_id'],
            task_id: data['task_id'],
            client_id: data['client_id'],
            duration: (parseInt(data['time'].split(":")[0]) * 60 + (parseInt(data['time'].split(":")[1]))),
            date: $('.current_date_hidden').text(),
            billable: data['billable'],
            note: data['note']
        }, function (res) {

            if ($("#billable_check").hasClass('btn-secondary')) {
                billable_icon_class = 'billable_icon';
            } else {
                billable_icon_class = '';
            }

            if (edit_id) {
                $('#save_daily_time').removeAttr('data-edit');
                var project_task = '.project_task';
                var project_client = '.project_client';
                var project_project = '.project_project';
                var fa_usd = '.fa-usd';
                var project_row = $('tr[data-id="' + edit_id + '"]');

                project_row.find('.project_time').text(data['time']);
                project_row.find(project_task).attr('data-task_id', data['task_id']);
                project_row.find(project_task).text(data['task']);

                project_row.find(project_client).attr('data-client_id', data['client_id']);
                project_row.find(project_client).text(data['client']);

                project_row.find(project_project).attr('data-project_id', data['project_id']);
                project_row.find(project_project).text(data['project']);

                project_row.find('.text_note').text(data['note']);

                if (!data['billable']) {
                    project_row.find(fa_usd).removeClass('billable_icon');
                } else {
                    project_row.find(fa_usd).addClass('billable_icon');
                }

            } else {
                var table_daily_html = '<tr data-id="' + res.last_id + '">+' +
                    '<td class="first_cell_daily"><input class="checkbox_daily_item" data-id="' + res.last_id + '"  type="checkbox"></td>' +
                    '<td class="project_time">' + data['time'] + '</td>' +
                    '<td class="project_task" data-task_id="' + data['task_id'] + '">' + data['task'] + '</td>' +
                    '<td class="project_client" data-client_id="' + data['client_id'] + '">' + data['client'] + '</td>' +
                    '<td class="project_project" data-project_id="' + data['project_id'] + '">' + data['project'] + '</td>' +
                    '<td class="text_note">' + data['note'] + '</td>' +
                    '<td><a data-id="' + res.last_id + '" id="edit_daily_timesheet" href="javascript:void(0)">Edit</a>' +
                    '<i class="fa fa-usd ' + billable_icon_class + '" data-id="' + res.last_id + '"  aria-hidden="true"></i></td></tr>';

                $('#table_daily_timesheet').append(table_daily_html);
            }
            updateWeeklyTimesheet();
            var time = totalTime();
            $('.daily_timesheet_total-time span').text(time);
        });
        // end ajax request

        $('span.active_time_type').removeClass('active_time_type');
        $(".time_type span:first").addClass('active_time_type');
        $('input[name="time"]').attr('data-type', 'hrs');
        $("#billable_textarea").val('');
        $(this)[0].reset();
    });

    $('body').on('click', '.fa-usd', function () {
        var id = $(this).attr('data-id');
        if ($(this).hasClass('billable_icon')) {
            var billable = 0;
        } else {
            var billable = 1;
        }

        $.post('/admin/timesheet/billable', {id: id, billable: billable}, function () {
        });
        $(this).toggleClass('billable_icon');

    });

    $("button[type='reset']").click(function () {
        $('#hrs_type').trigger('click');
        $("#billable_textarea").val('');
    });

    $(".time_type span").click(function () {

        var time = $('#billable_time_input').val();
        if ($(this).text() == 'MIN') {
            if (time.indexOf(":") < 0) {
                return;
            }
            time = time.split(':');
            $('input[name="time"]').attr('data-type', 'min');
            $('input[name="time"]').val((parseInt(time[0]) * 60) + (parseInt(time[1])));
        } else if ($(this).text() == 'HRS') {
            if (time.indexOf(":") > 0) {
                return;
            }
            $('input[name="time"]').attr('data-type', 'hrs');
            $('input[name="time"]').val(minutesToHrsView(time));
        }
        $('span.active_time_type').removeClass('active_time_type');
        $(this).addClass('active_time_type');
    });

    // count total time in daily timesheet
    $('.daily_timesheet_total-time span').text(totalTime());

    // timesheet datepicker range
    $("#datepicker_range_timesheet").datepicker({
        format: "dd/mm/yyyy"
    });

    $('#datepicker_range_timesheet input[name="start"]').datepicker()
        .on('changeDate', function () {
            ajaxWait();
            updateRangeTimesheet();
        });

    $('#datepicker_range_timesheet input[name="end"]').datepicker()
        .on('changeDate', function () {
            updateRangeTimesheet();
        });


    // if a user is inactive more than 24 hrs - logout
    var idle_time = 0;
    $(this).mousemove(function () {
        idle_time = 0;
    });
    $(this).keypress(function () {
        idle_time = 0;
    });
    setInterval(timerLogout, 1000 * 60 * 60);

    $('body').on('click', '#edit_daily_timesheet', function (e) {
        e.preventDefault();
        var attr_id = $(this).attr('data-id');
        var project_time = $('tr[data-id="' + attr_id + '"]').find('.project_time').text();
        var project_task = $('tr[data-id="' + attr_id + '"]').find('.project_task').attr('data-task_id');
        var project_client = $('tr[data-id="' + attr_id + '"]').find('.project_client').attr('data-client_id');
        var project_project = $('tr[data-id="' + attr_id + '"]').find('.project_project').attr('data-project_id');
        var text_note = $('tr[data-id="' + attr_id + '"]').find('.text_note').text();

        var billable = $('tr[data-id="' + attr_id + '"]').find('.fa-usd').hasClass('billable_icon') ? true : false;
        var billable_check = $('#billable_check');

        if (!billable) {
            billable_check.removeClass('btn-secondary');
        } else {
            billable_check.addClass('btn-secondary');
        }

        $('#hrs_type').trigger('click');
        $("#billable_time_input").val(project_time);
        $('select[name="task"]').val(project_task);
        $('select[name="client"]').val(project_client);
        $('select[name="project"]').val(project_project);
        $("#billable_textarea").val(text_note);

        $('#save_daily_time').attr('data-edit', attr_id)
    });


    weeklyProjectsSum();

    $("body").on('click', '.week_range', function (e) {
        e.preventDefault();
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var date, month, day;
        var grey_class = '';
        var range = $(this).attr('data-date');
        ajaxWait();
        $.get('/admin/weekly', {date: range}, function (res) {
            var html = '<thead><th>Client/Project/Task</th>';
            var keys = Object.keys(res);

            for (var item in res[keys[0]]) {
                date = new Date(item);
                month = parseInt(date.getMonth() + 1);
                month = month < 10 ? '0' + month : month;
                day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                html += '<th class="date_th">' + days[date.getDay()] + ', ' + month + '/' + day + '</th>'
            }
            html += '<th>Sum</th></thead><tbody>';
            keys.forEach(function (elem) {
                html += '<tr class="projects_weekly_' + elem + '"><td class="weekly_project_name">' + elem + '</td>';
                for (var item in res[elem]) {
                    date = new Date(item);
                    month = parseInt(date.getMonth() + 1);
                    month = month < 10 ? '0' + month : month;
                    day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                    if (!res[elem][item]) {
                        res[elem][item] = '0:00';
                        grey_class = 'style="color:#ccc"';
                    }
                    html += '<td class="weekly_duration_' + elem + '" data-date="' + month + '/' + day + '_day" ' + grey_class + '>' + res[elem][item] + '</td>';
                    grey_class = '';
                }
                html += '<td class="weekly_sum"></td></tr>';
            });
            html += '<tr><td>Sum:</td>';
            for (var item in res[keys[0]]) {
                date = new Date(item);
                month = parseInt(date.getMonth() + 1);
                month = month < 10 ? '0' + month : month;
                day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                html += '<td class="day_sum" data-date="sum_' + month + '/' + day + '"></td>'
            }
            html += '<td id="total_sum"></td></tr></table>';

            var projects_table = $('.weekly_timesheet_projects table');
            projects_table.children().remove();
            projects_table.append(html);
            weeklyProjectsSum();
        });
        var week_range_list = $('.week_range_list');
        $.get('/admin/weeks', {weekly_date: range}, function (res) {
            week_range_list.children().remove();
            res.forEach(function (elem) {
                var html_range = '<td><a href="javascript:void(0)" data-date="' + elem + '" class="week_range">' + elem + '</a></td>';
                week_range_list.append(html_range);
            });
            $('.week_range:last').addClass('current_week_range');
            week_range_list.append(week_range_html);
            ajaxWaitDelete();
        });
    });

    $('.submit_timesheet').click(function () {
        var id_timesheet = $(this).data('id_timesheet');
        $.post('/admin/timesheet/send', {
            id_timesheet: id_timesheet,
        }, function (res) {
            location.href = '/admin/report'
        });

    });

    // functions -------------------------------------

    function errorMsg(string) {
        var error_msg = $("#error_msg");
        error_msg.append('<div class="alert alert-danger"><strong>Error! </strong>' + string + '</div>');
        setTimeout('$("#error_msg").children().remove()', 2000);
    }

    function totalTime() {
        var total = [];
        total['hours'] = 0;
        total['min'] = 0;
        $('.project_time').each(function () {
            var buf = this.innerText.split(':');
            total['hours'] += parseInt(buf[0]);
            total['min'] += parseInt(buf[1]);
        });

        if (total['min'] > 59) {
            total['hours'] += Math.floor(total['min'] / 60);
            total['min'] = total['min'] % 60;
        }

        if (total['min'] < 10) {
            total['min'] = '0' + total['min'];
        }

        return total['hours'] + ':' + total['min'];
    }

    function timerLogout() {
        idle_time++;

        if (document.getElementById('logout-form') && idle_time == 24) {
            document.getElementById('logout-form').submit();
        }
    }

    function minutesToHrsView(time) {
        var hours = parseInt(time) / 60;
        hours = hours < 1 ? hours = 0 : Math.floor(hours);
        var minutes = parseInt(time) % 60;

        if (minutes < 10) {
            minutes = '0' + minutes;
        }
        return hours + ':' + minutes;
    }

    function currentDateHidden(date) {
        var day = parseInt(date.getDate()) < 10 ? ('0' + parseInt(date.getDate())) : parseInt(date.getDate());
        var month = (parseInt(date.getMonth()) + 1) < 10 ? ('0' + (parseInt(date.getMonth()) + 1)) : (parseInt(date.getMonth()) + 1);
        var current_date = date.getFullYear() + '-' + month + '-' + day;
        $('.current_date_hidden').text(current_date);
    }


    function updateWeeklyTimesheet() {
        $('.week_range:last').trigger('click');
        ajaxWaitDelete();
    }

    function weeklyProjectsSum() {
        var project_name_td = $('.weekly_project_name');
        var sum = [];
        project_name_td.each(function () {
            sum['hours'] = 0;
            sum['min'] = 0;
            var project_name = this.innerText;
            $("td.weekly_duration_" + project_name).each(function (iter, that) {
                var time = $.trim(that.innerText).split(':');
                sum['hours'] += parseInt(time[0]);
                sum['min'] += parseInt(time[1]);
            });
            $('.projects_weekly_' + project_name + ' .weekly_sum').text(minutesToHrsView(+sum['hours'] * 60 + sum['min']))
        });

        $('.date_th').each(function () {
            var day = $.trim(this.innerText.split(',')[1]);
            sum['hours'] = 0;
            sum['min'] = 0;

            $('td[data-date="' + day + '_day"]').each(function (iter, that) {
                var time_sum = $.trim(that.innerText).split(':');
                sum['hours'] += parseInt(time_sum[0]);
                sum['min'] += parseInt(time_sum[1]);
            });
            $('td[data-date="sum_' + day + '"]').text(minutesToHrsView(+sum['hours'] * 60 + sum['min']))
        });

        sum['hours'] = 0;
        sum['min'] = 0;
        $('.day_sum').each(function () {
            var time_total_sum = $.trim(this.innerText).split(':');
            if (time_total_sum[0] && time_total_sum[1]) {
                sum['hours'] += parseInt(time_total_sum[0]);
                sum['min'] += parseInt(time_total_sum[1]);
            }
        });
        $('#total_sum').text(minutesToHrsView(+sum['hours'] * 60 + sum['min']))
    }

    function updateRangeTimesheet() {
        var start = $('#datepicker_range_timesheet input[name="start"]').val();
        var end = $('#datepicker_range_timesheet input[name="end"]').val();

        $.get('/timesheet/period', {from: start, to: end}, function (res) {
            for (var item in res) {
                $('.timesheet_' + item).text(res[item]);
            }
        });
        var url_date = start + ' - ' + end;
        url_date = replaceAll("/", ".", url_date);
        var href = $('.statistics_href').attr('href');
        href = href.split('/');
        href[href.length - 1] = url_date;
        href = href.join('/');
        $('.statistics_href').attr('href', href);

        $(".timesheet_period").text(start + ' - ' + end);
    }

    function replaceAll(find, replace, str) {
        while (str.indexOf(find) > -1) {
            str = str.replace(find, replace);
        }
        return str;
    }

    function ajaxWait() {
        var pleaseWaitDialog = $('#pleaseWaitDialog');
        pleaseWaitDialog.modal();
        $('#ajax_loader').show();
        pleaseWaitDialog.removeClass('hide');
    }

    function ajaxWaitDelete() {
        $('#pleaseWaitDialog').modal('hide');
    }
});

