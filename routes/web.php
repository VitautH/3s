<?php
Auth::routes();
Route::middleware(['auth', 'checkUserRole'])->group(function () {
    Route::get('/', 'ProfileController@index');
    Route::get('/project', 'ProfileController@projects')->name('projects');
    Route::get('/timesheet', 'TimesheetController@index')->name('timesheet');
    Route::post('/timesheet', 'TimesheetController@insert');
    Route::get('/timesheet/get/{id}', 'TimesheetController@getById');
    Route::post('/timesheet/update/{id}', 'TimesheetController@update');
    Route::post('/timesheet/delete', 'TimesheetController@delete');
    Route::post('/timesheet/billable', 'TimesheetController@changeStatus');
    Route::get('/timesheet/period', 'TimesheetController@getTimesheetPeriod');
    Route::post('/timesheet/send', 'TimesheetController@insertNotification');
    Route::get('/timesheet/{date}', 'TimesheetController@getByDate');
    Route::get('/weekly', 'TimesheetController@weeklyTimesheet');
    Route::get('/weeks', 'TimesheetController@getLastWeeks');
    Route::get('/statistic/{period}', 'TimesheetController@timesheetStatistic')->name('statistic');
    Route::get('/yearly', 'TimesheetController@yearlyTimesheet');
    Route::post('/profile/upload', 'ProfileController@upload');
});

// Admin Routing
Route::middleware(['auth', 'checkAdminRole'])->group(function () {
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/users', 'UsersController@index');
    Route::get('/admin/projects', 'ProjectsController@index');
    Route::get('/admin/user/{id}', 'UsersController@viewUser');
    Route::get('/admin/timesheets', 'AdminTimesheetController@index');
    Route::get('/admin/timesheets/{id}', 'AdminTimesheetController@index');
    Route::get('/admin/weekly', 'AdminTimesheetController@weeklyTimesheet');
    Route::get('/admin/weeks', 'AdminTimesheetController@getLastWeeks');
    Route::get('/admin/timesheet/{date}', 'AdminTimesheetController@getByDate');
    Route::post('/admin/timesheet/delete', 'AdminTimesheetController@delete');
    Route::get('/admin/report', 'AdminTimesheetController@report');
    Route::get('/admin/statistic/employee/{id}', 'AdminTimesheetController@timesheetStatistic');
    Route::post('/admin/timesheet/send', 'AdminTimesheetController@approveNotification');
});




