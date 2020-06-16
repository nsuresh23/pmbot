<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use Illuminate\Http\Request;

Auth::routes();

Route::post('error401', function () {
	return view('errors.error401');
})->name('error401');

Route::post('error404', function () {
	return view('errors.error404');
})->name('error404');

Route::group(['middleware' => ['auth', 'roles']], function () {

	Route::get('/', function (Request $request) {
		return Redirect::to('/home');
	});

	Route::get('home', function (Request $request) {

		return redirectRoute($request);

	})->name('home');

	Route::get('dashboard', function (Request $request) {

		return redirectRoute($request);

	})->name('dashboard');


	function redirectRoute($request)
	{

		$params = $request->all();


		$redirectToDashboardParam = "";

		if (array_key_exists("redirectToDashboard", $params)) {

			$redirectToDashboardParam = "?redirectToDashboard=true";
		}

		$role = Auth::user()->role;

		// echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($role);echo '<PRE/>';exit;
		// Check user role
		switch ($role) {

			case 'admin':
				// return '/pm/dashboard';
				return Redirect::to('/admin/dashboard' . $redirectToDashboardParam);
				break;
			case 'account_manager':
				// return redirect()->route('dashboard');
				// return '/dashboard';
				// return '/am/dashboard';
				return Redirect::to('/am/dashboard' . $redirectToDashboardParam);
				break;
			case 'project_manager':
				// return '/pm/dashboard';
				return Redirect::to('/pm/dashboard' . $redirectToDashboardParam);
				break;
			case 'copy_editing':
				// return '/pm/dashboard';
				return Redirect::to('/stakeholders/dashboard' . $redirectToDashboardParam);
				break;
			case 'logistics':
				// return '/pm/dashboard';
				return Redirect::to('/stakeholders/dashboard' . $redirectToDashboardParam);
				break;
			case 'production':
				// return '/pm/dashboard';
				return Redirect::to('/stakeholders/dashboard' . $redirectToDashboardParam);
				break;
			case 'art':
				// return '/pm/dashboard';
				return Redirect::to('/stakeholders/dashboard' . $redirectToDashboardParam);
				break;

			// case 'stakeholder':
			// 	// return '/stakeholders/dashboard';
			// 	return Redirect::to('/stakeholders/dashboard' . $redirectToDashboardParam);
			// 	break;
			default:
				// return '/login';
				return Redirect::to('/login');
				break;
		}

	}


    Route::any('file', 'File\FileController@getFile')->name('file');

    // Route::any('/pm/dashboard', 'PM\DashboardController@index');
    // Route::any('/stakeholders/dashboard', 'StakeHolders\DashboardController@index');

    Route::post('process-media', 'HomeController@storeMedia')->name('process-media');

	// Route::any('/admin/dashboard', 'Admin\AdminController@index')->name('dashboard');
	// Route::any('/am/dashboard', 'AM\DashboardController@index')->name('dashboard');
	// Route::any('/pm/dashboard', 'PM\DashboardController@index')->name('dashboard');
	// Route::any('/stakeholders/dashboard', 'StakeHolders\DashboardController@index')->name('dashboard');

	// Route::any('/job-list', 'Job\JobController@getJobsByStageAndStatus')->name('job-list');



	Route::any('invoice-list', 'Job\InvoiceController@listbyparam')->name('invoice-list');
	Route::any('job-task-list', 'Job\TaskController@jobTaskList')->name('job-task-list');
	Route::any('my-task-list', 'Job\TaskController@myTaskList')->name('my-task-list');
	Route::any('query-list', 'Job\TaskController@queryList')->name('query-list');
	Route::any('email-list', 'Job\EmailController@emailList')->name('email-list');
	Route::any('draft-task-list', 'Job\TaskController@draftTaskList')->name('draft-task-list');
	Route::any('open-task-list', 'Job\TaskController@openTaskList')->name('open-task-list');
	Route::any('task-view/{id}', 'Job\TaskController@taskView')->name('task-view');
	Route::any('task-history/{id}', 'Job\TaskController@taskHistory')->name('task-history');
	Route::any('task-search/{id}', 'Job\TaskController@taskSearch')->name('task-search');

	Route::any('task-store', 'Job\TaskController@taskStore')->name('task-store');
	Route::any('task-add', 'Job\TaskController@taskAdd')->name('task-add');
	Route::any('task-update', 'Job\TaskController@taskUpdate')->name('task-update');
	Route::any('task-followup-date-update', 'Job\TaskController@taskFollowupUpdate')->name('task-followup-date-update');
	Route::any('task-field-update', 'Job\TaskController@taskFieldUpdate')->name('task-field-update');
	Route::any('task-edit/{id}', 'Job\TaskController@taskEdit')->name('task-edit');
	Route::any('task-close', 'Job\TaskController@taskClose')->name('task-close');
	Route::any('task-delete', 'Job\TaskController@taskDelete')->name('task-delete');

	// Route::any('note-list', 'Job\NoteController@noteList')->name('note-list');
	Route::any('task-note-list/{id}', 'Job\NoteController@taskNoteList')->name('task-note-list');
	Route::any('note-store', 'Job\NoteController@noteStore')->name('note-store');
	Route::any('note-add', 'Job\NoteController@noteAdd')->name('note-add');
	Route::any('note-update', 'Job\NoteController@noteUpdate')->name('note-update');
	// Route::any('note-edit/{id}', 'Job\NoteController@noteEdit')->name('note-edit');
	// Route::any('note-view/{id}', 'Job\NoteController@noteView')->name('note-view');
	Route::any('note-delete', 'Job\NoteController@noteDelete')->name('note-delete');

	Route::any('check-list', 'Job\CheckListController@checkList')->name('check-list');
	Route::any('check-list-task-select', 'Job\CheckListController@checkListTasksSelect')->name('check-list-task-select');
	Route::any('check-list-view/{id}', 'Job\CheckListController@checkListView')->name('check-list-view');
	Route::any('check-list-search', 'Job\CheckListController@checkListSearch')->name('check-list-search');
	Route::post('check-list-media', 'Job\CheckListController@storeMedia')->name('check-list-media');


	Route::any('notification-count', 'Notification\NotificationController@notificationCount')->name('notification-count');
	Route::any('notification-list', 'Notification\NotificationController@notificationList')->name('notification-list');
	Route::any('notification-read/{id}', 'Notification\NotificationController@notificationRead')->name('notification-read');
	Route::any('notification-read-all', 'Notification\NotificationController@notificationReadAll')->name('notification-read-all');

	// Route::any('/', route('home'));



});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin']], function () {

	Route::any('/admin/dashboard', 'Admin\AdminController@index')->name('admin-dashboard');

});

Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin', 'account_manager']], function () {

	Route::any('/am/dashboard', 'AM\DashboardController@index')->name('am-dashboard');

});

Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin', 'project_manager']], function () {

	Route::any('/pm/dashboard', 'PM\DashboardController@index')->name('pm-dashboard');

});

Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin', 'copy_editing', 'logistics', 'production', 'art']], function () {

	Route::any('/stakeholders/dashboard', 'StakeHolders\DashboardController@index')->name('stakeholders-dashboard');

});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'roles'], 'roles' => ['admin']], function () {

	Route::any('/', 'User\UserController@index')->name('user');

	Route::any('user-password-update/{id}', 'User\UserController@userPasswordUpdate')->name('user-password-update');

	Route::any('user-list', 'User\UserController@userList')->name('user-list'); //done
	Route::any('user-store', 'User\UserController@userStore')->name('user-store'); //done
	Route::any('user-add', 'User\UserController@userAdd')->name('user-add'); //done
	Route::any('user-update', 'User\UserController@userUpdate')->name('user-update'); //done
	Route::any('user-edit/{id}', 'User\UserController@userEdit')->name('user-edit'); //done
	Route::any('user-delete', 'User\UserController@userDelete')->name('user-delete'); //done

	Route::any('group-list', 'User\UserController@groupList')->name('group-list'); //done
	Route::any('group-add', 'User\UserController@groupAdd')->name('group-add'); //done
	Route::any('group-edit', 'User\UserController@groupEdit')->name('group-edit'); //done
	Route::any('group-delete', 'User\UserController@groupDelete')->name('group-delete'); //done
	Route::any('group-active', 'User\UserController@getActiveGroups')->name('group-active'); //done

	Route::any('role-list', 'User\UserController@roleList')->name('role-list'); //done
	Route::any('role-add', 'User\UserController@roleAdd')->name('role-add'); //done
	Route::any('role-edit', 'User\UserController@roleEdit')->name('role-edit'); //done
	Route::any('role-delete', 'User\UserController@roleDelete')->name('role-delete'); //done
	Route::any('role-active', 'User\UserController@getActiveRoles')->name('role-active'); //done

	Route::any('location-list', 'User\UserController@locationList')->name('location-list'); //done
	Route::any('location-add', 'User\UserController@locationAdd')->name('location-add'); //done
	Route::any('location-edit', 'User\UserController@locationEdit')->name('location-edit'); //done
	Route::any('location-delete', 'User\UserController@locationDelete')->name('location-delete'); //done
	Route::any('location-active', 'User\UserController@getActiveLocations')->name('location-active'); //done

	Route::any('stage-list', 'Job\StageController@stageList')->name('stage-list'); //done
	Route::any('stage-add', 'Job\StageController@stageAdd')->name('stage-add'); //done
	Route::any('stage-edit', 'Job\StageController@stageEdit')->name('stage-edit'); //done
	Route::any('stage-delete', 'Job\StageController@stageDelete')->name('stage-delete'); //done
	Route::any('stage-active', 'Job\StageController@getActiveStages')->name('stage-active'); //done

		// Route::any('addgroup', 'User\UserController@updateUserGroup')->name('addgroup'); //done
		// Route::any('editgroup/{id}', 'User\UserController@updateUserGroup')->name('editgroup'); //done
		// Route::get('deletegroup/{id}', 'User\UserController@deleteGroup');

		// Route::any('grouplistdata', 'User\UserController@groupListData');
		// Route::any('addwhf', 'UserController@updateUserGroup')->name('addwhf');
		// Route::any('addwfhuser/{grpid}', 'UserController@updateWFHUser')->name('addwfhuser');//done
		// Route::any('editwfhuser/{usrid}', 'UserController@updateWFHUser')->name('editwfhuser');//done
		// Route::get('deleteuser/{id}', 'UserController@deleteUser');

		// Route::get('groupuserlist/{grpid}', 'UserController@wfhUserList')->name('groupuserlist'); //done
		// Route::any('groupuserlistdata', 'UserController@wfhUserListData');
		// Route::get('wfhgroupdetails/{grpid}', 'UserController@groupDetails')->name('wfhgroupdetails');
		// Route::post('saveip/{grpid}', 'UserController@saveIpAddress');
		// Route::any('macipdata', 'UserController@macIpData');
		// Route::any('deleteip', 'UserController@deleteMacIp');

		// //date override option:
		// Route::any('overridedate/{grpid}', 'UserController@overrideDates')->name('overridedate');
		// Route::get('deletedates/{volid}', 'UserController@deleteDates');
		// Route::any('editdateranges/{volid}', 'UserController@overrideDates')->name('editdateranges');

		// Route::get('alldatelist', 'UserController@volumeRanges')->name('alldatelist'); //done
		// Route::get('datelist/{grpid}', 'UserController@volumeRanges')->name('datelist');
		// Route::any('datelistdata', 'UserController@volumeRangesData');

		// Route::any('add_user', 'UserController@addInhouseUser')->name('add_user');//done

		// Route::any('edituser/{id}', 'UserController@editInhouseUser')->name('edithouseuser');//done

		// Route::get('user_list', 'UserController@InhouseUser')->name('user_list');//done
		// Route::any('userlistdata', 'UserController@inhouseListData');
		// Route::any('inhouselistdata', 'UserController@inhouseListData');//Duplicate page

		// Route::post('getusertype', 'UserController@getUserType');
	});

// Route::any('job/{id}', 'Job\JobController@getJobDetails')->name('jobDetail'); //done

// Route::get('/job-list', 'Job\JobController@getJobsByStageAndStatus')->name('job-list');

Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin', 'account_manager', 'project_manager']], function () {

    Route::any('/job-store', 'Job\JobController@jobStore')->name('job-store');
    Route::any('/job-update', 'Job\JobController@jobUpdate')->name('job-update');
    Route::any('/annotator-job-add', 'Job\JobController@annotatorJobAdd')->name('annotator-job-add');
	Route::any('/job-list', 'Job\JobController@jobList')->name('job-list');
	Route::any('/delayed-job-list', 'Job\JobController@getDelayedJobs')->name('delayed-job-list');
	Route::any('/job-list/{stage?}', 'Job\JobController@getJobsByStage');
	Route::any('/job-list/{status?}', 'Job\JobController@getJobsByStatus');
	Route::any('/job-list/{stage?}/{status?}', 'Job\JobController@getJobsByStageAndStatus');

	Route::any('job/{id}', 'Job\JobController@getJobDetails')->name('job-detail');
	Route::any('job-history/{id}', 'Job\JobController@jobHistory')->name('job-history');
	Route::any('job-timeline/{id}', 'Job\JobController@jobTimeline')->name('job-timeline');
	Route::any('my-history', 'User\UserController@myHistory')->name('my-history');

	Route::any('email-send', 'Job\EmailController@emailSend')->name('email-send');
	Route::any('draft-email-send', 'Job\EmailController@draftemailSend')->name('draft-email-send');
	Route::any('email-get', 'Job\EmailController@emailGet')->name('email-get');
    Route::any('pms-email-count', 'Job\EmailController@pmsEmailCount')->name('pms-email-count');
	Route::any('get-emailid', 'Job\EmailController@emailidGet')->name('get-emailid');
	Route::any('email-status-update', 'Job\EmailController@emailStatusUpdate')->name('email-status-update');

	Route::any('job', 'Job\JobController@index')->name('job');

	// Route::any('task-store', 'Job\TaskController@taskStore')->name('task-store');
	// Route::any('task-add', 'Job\TaskController@taskAdd')->name('task-add');
	// Route::any('task-update', 'Job\TaskController@taskUpdate')->name('task-update');
	// Route::any('task-field-update', 'Job\TaskController@taskFieldUpdate')->name('task-field-update');
	// Route::any('task-edit/{id}', 'Job\TaskController@taskEdit')->name('task-edit');
	// Route::any('task-close', 'Job\TaskController@taskClose')->name('task-close');
	// Route::any('task-delete', 'Job\TaskController@taskDelete')->name('task-delete');

	Route::any('check-list-store', 'Job\CheckListController@checkListStore')->name('check-list-store');
	Route::any('check-list-add', 'Job\CheckListController@checkListAdd')->name('check-list-add');
	Route::any('check-list-update', 'Job\CheckListController@checkListUpdate')->name('check-list-update');
	Route::any('check-list-edit/{id}', 'Job\CheckListController@checkListEdit')->name('check-list-edit');
	Route::any('check-list-delete', 'Job\CheckListController@checkListDelete')->name('check-list-delete');


	/* Email annotator */


	//Route::any('annotation/{id}/empcode/{empcode}/', 'Annotator\ApiController@getannotatoremail')->name('annotation');
	Route::any('annotation/id/{id}', 'Annotator\ApiController@getannotatoremail')->name('email-view');
	Route::any('annotation/getresult', 'Annotator\ApiController@getresult');
	Route::any('annotation/search', 'Annotator\ApiController@search');
	Route::any('annotation/getpmbotjoblist', 'Annotator\ApiController@getpmbotjoblist')->name('annotation');
	Route::any('annotation/gettasklist', 'Annotator\ApiController@gettasklist')->name('annotation');


	Route::any('annotation/getpmuserlist', 'Annotator\ApiController@getpmuserlist');
	Route::any('annotation/gettaskdetail', 'Annotator\ApiController@gettaskdetail');
	Route::any('annotation/newattachment', 'Annotator\ApiController@newattachment');
	Route::any('annotation/getselectedjob', 'Annotator\ApiController@getselectedjob')->name('getselectedjob');
	Route::any('annotation/getjobtasklist', 'Annotator\ApiController@getjobtasklist');

	Route::any('annotation/store', 'Annotator\ApiController@store');
	Route::any('annotation/update/{id}', 'Annotator\ApiController@update');
	Route::any('annotation/delete/{id}', 'Annotator\ApiController@delete');
	Route::any('annotation/statusupdate/{id}', 'Annotator\ApiController@statusupdate');
	Route::any('annotation/updategroupingdata/', 'Annotator\ApiController@updategroupingdata');
	Route::any('annotation/getdataresult', 'Annotator\ApiController@getdataresult');

	Route::any('annotation/completetaskdetail', 'Annotator\ApiController@completetaskdetail');
	Route::any('annotation/nonbusiness', 'Annotator\ApiController@nonbusiness');
	Route::any('annotation/createisbn', 'Annotator\ApiController@createisbn');



	//Tickets
	Route::any('/tickets', 'Controller@tickets');
	Route::any('/tickets/gettickets', 'TicketController@gettickets');
	Route::any('/tickets/getticketdata', 'TicketController@getticketdata');
	Route::any('/tickets/searchtickets', 'TicketController@searchtickets');
	Route::any('/tickets/updateticket/{id}', 'TicketController@updateticket');
	Route::any('/tickets/deleteticket/{id}', 'TicketController@deleteticket');

	//responseeditor
	Route::any('/responseeditor', 'Controller@responseeditor');
	Route::any('/responseeditor/getresult', 'ResponseController@getresult');
	Route::any('/responseeditor/search', 'ResponseController@search');
	Route::any('/responseeditor/update/{id}', 'ResponseController@update');
	Route::any('/responseeditor/getdataresult/', 'ResponseController@getdataresult');

});
