<?php

use Illuminate\Support\Facades\Route;


// HSE checklist
Route::get('hse-checklists','Apiv2\HSEChecklistController@index')->name('checklists');
Route::get('/hse-checklist', 'Apiv2\LoginController@hseChecklist');

Route::get('hse-checklists/opt-checklist','Apiv2\HSEChecklistController@indexOpt')->name('opt-index');
Route::get('hse-checklists/rat-checklist','Apiv2\HSEChecklistController@indexRat')->name('rat-index');
Route::get('hse-checklists/opt-create','Apiv2\HSEChecklistController@createOpt')->name('opt-create');
Route::get('hse-checklists/rat-create','Apiv2\HSEChecklistController@createRat')->name('rat-create');


Route::group(['middleware' => ['guest']], function ()
{
    Route::get('/', 'AuthController@showLogin');
    Route::post('/', 'AuthController@doLogin');
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@processPasswordReset');
    Route::get('register', 'AuthController@showRegister');
});

//Applicatioin
Route::get('leader-login', 'Login\LoginController@showLoginForm');
Route::get('leader-check-list','Login\LoginController@login');
// Route::post('leader-changepassword','Login\LoginController@changePassword');
Route::get('leader-home','Login\LoginController@loginCheck');
Route::get('leader-other-home-page/{$userId}','Leader\ListController@otherLink')->name('get.leader.other');
// Route::get('home/{$userId}/{$siteId}/{$shiftId}','List\ListController@homePage');
Route::get('/get-leader-shifts/{siteId}', 'Leader\ListController@getShifts')->name('get.leader.shifts');


Route::group(['middleware' => ['auth']], function ()
{
    Route::get('conversation','ConversationsController@conversation');
    Route::post('conversationauth', 'ConversationsController@conversationauth');
    Route::post('setmessage','ConversationsController@set_message');
    Route::post('getmessage','ConversationsController@get_message');
    Route::post('getmember','ConversationsController@get_member');
    Route::get('home', 'HomeController@index');
    Route::get('change-password', 'AuthController@changePassword');
    Route::post('change-password', 'AuthController@processPasswordChange');
    Route::get('logout', 'AuthController@doLogout');
    Route::get('welcome', 'AuthController@welcome');
    Route::get('not-found', 'AuthController@notFound');
    Route::get('dashboard', 'AuthController@dashboard');
    Route::get('profile', 'ProfileController@show');



    // Routes for add-employees

    // Route::get('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@addEmployee']);
    Route::post('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@processEmployee']);
    Route::get('employee-manager', ['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);
    Route::post('employee-manager', 'EmpController@searchEmployee');
    Route::get('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);
    Route::post('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@uploadFile']);
    Route::get('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);
    Route::post('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@doEdit']);
    Route::get('delete-emp/{id}', ['as' => 'delete-emp', 'uses' => 'EmpController@doDelete']);
    Route::get('view-emp/{id}','EmpController@viewEmployee');
    Route::get('print-emp/{id}','EmpController@printEmployee');
    Route::post('search-emp','EmpController@searchEmployee');
    Route::get('employee-probation', ['as' => 'employee-probation', 'uses' => 'EmpController@showProbation']);
    Route::get('employee-permanent', ['as' => 'employee-permanent', 'uses' => 'EmpController@showPermanent']);
    Route::get('employee-resign', ['as' => 'employee-resign', 'uses' => 'EmpController@showResign']);
    Route::get('employee-warning', ['as' => 'employee-warning', 'uses' => 'EmpController@showWarning']);
    Route::get('employee-terminate', ['as' => 'employee-terminate', 'uses' => 'EmpController@showTerminate']);
    Route::get('employee-dismiss', ['as' => 'employee-dismiss', 'uses' => 'EmpController@showDismiss']);
    Route::post('employee-search', 'EmpController@searchSpecificEmployee');
    Route::get('show-exports', ['as' => 'show-exports', 'uses' => 'EmpController@showExports']);
    Route::post('export-detail', ['as' => 'export-detail', 'uses' => 'EmpController@exportDetail']);
    Route::post('export-summary', ['as' => 'export-summary', 'uses' => 'EmpController@exportSummary']);
    Route::post('export-emp', ['as' => 'export-emp-status', 'uses' => 'EmpController@exportEmpStatus']);
    Route::post('edit-employee-cv/{id}', ['as' => 'edit-employee-cv', 'uses' => 'EmpController@editEmployeeCV']);
    Route::post('print-employee-cv/{id}', ['as' => 'print-employee-cv', 'uses' => 'EmpController@printEmployeeCV']);
    Route::get('print/{id}', ['as' => 'print', 'uses' => 'EmpController@showPrintView']);




    // add sbu name
    
    Route::post('save-sbu-name', ['as' => 'save-sbu', 'uses' => 'EmpController@addSbu']);
    
    
    
    // Routes for Bank Account details

    Route::get('bank-account-details', ['uses' => 'EmpController@showDetails']);
    Route::post('update-account-details', ['uses' => 'EmpController@updateAccountDetail']);



    // Routes for Team.

    Route::get('add-team', ['as' => 'add-team', 'uses' => 'TeamController@addTeam']);
    Route::post('add-team', ['as' => 'add-team', 'uses' => 'TeamController@processTeam']);
    Route::get('team-listing', ['as' => 'team-listing', 'uses' => 'TeamController@showTeam']);
    Route::get('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@showEdit']);
    Route::post('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@doEdit']);
    Route::get('delete-team/{id}', ['as' => 'delete-team', 'uses' => 'TeamController@doDelete']);



    // Routes for Role.

    Route::get('add-role', ['as' => 'add-role', 'uses' => 'RoleController@addRole']);
    Route::post('add-role', ['as' => 'add-role', 'uses' => 'RoleController@processRole']);
    Route::get('role-list', ['as' => 'role-list', 'uses' => 'RoleController@showRole']);
    Route::get('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@showEdit']);
    Route::post('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@doEdit']);
    Route::get('delete-role/{id}', ['as' => 'delete-role', 'uses' => 'RoleController@doDelete']);



    // Routes for Expense.

    Route::get('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@addExpense']);
    Route::post('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@processExpense']);
    Route::get('expense-list', ['as' => 'expense-list', 'uses' => 'ExpenseController@showExpense']);
    Route::get('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@showEdit']);
    Route::post('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@doEdit']);
    Route::get('delete-expense/{id}', ['as' => 'delete-expense', 'uses' => 'ExpenseController@doDelete']);



    // Routes for Leave.

    Route::get('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@addLeaveType']);
    Route::post('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@processLeaveType']);
    Route::get('leave-type-listing', ['as' => 'leave-type-listing', 'uses' => 'LeaveController@showLeaveType']);
    Route::get('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@showEdit']);
    Route::post('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@doEdit']);
    Route::get('delete-leave-type/{id}', ['as' => 'delete-leave-type', 'uses' => 'LeaveController@doDelete']);
    Route::get('apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@doApply']);
    Route::post('apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@processApply']);
    Route::get('my-leave-list', ['as' => 'my-leave-list', 'uses' => 'LeaveController@showMyLeave']);
    Route::get('total-leave-list', ['as' => 'total-leave-list', 'uses' => 'LeaveController@showAllLeave']);
    Route::post('total-leave-list', 'LeaveController@searchLeave');
    Route::post('search-leave','LeaveController@searchLeave');
    Route::get('delete-leave/{id}','LeaveController@deleteLeave');
    Route::get('view/{id}','LeaveController@viewLeave');
    
    Route::get('leaverecord',['as'=>'leave-record', 'uses'=>'LeaveController@leaverecord']);
    Route::get('add-leave-record',['as'=>'add-leave-record', 'uses'=> 'LeaveController@addLeaveRecord']);
    Route::post('save-leave-record',['as'=>'save-leave-record', 'uses'=>'LeaveController@saveLeaveRecord']);
    Route::get('edit-leave-record/{id}','LeaveController@editleaveRecord');
    Route::post('save-edit-leave-record/{id}',['as'=>'save-edit-leave-record','uses'=>'LeaveController@saveEditLeaveRecord']);
    Route::get('delete-leave-record/{id}','LeaveController@deleteLeaveRecord');
    Route::post('search-leaverecord','LeaveController@searchLeaveRecord');
    
    Route::get('edit-apply-leave/{id}','LeaveController@applyLeaveEdit');
    Route::post('edit-leave-apply/{id}','LeaveController@editLeaveApply');
    Route::post('delete-leave-apply/{id}','LeaveController@deleteLeaveApply');
    Route::post('change-st','LeaveController@changeStatus');



    // Routes for Attendance.

    Route::get('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@importAttendanceFile']);
    Route::post('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@uploadFile']);
    Route::get('attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@showSheetDetails']);
    Route::get('search-attendance', ['as' => 'search-attendance', 'uses' => 'AttendanceController@searchAttendance']);
    Route::post('search-attendance', ['as' => 'search-attendance', 'uses' => 'AttendanceController@searchAttendance']);
    Route::get('delete-file/{id}', ['as' => 'delete-file', 'uses' => 'AttendanceController@doDelete']);
    Route::get('addattendence',['as'=> 'add-attendence', 'uses' => 'AttendanceController@index']);
    Route::post('addattendence',['as'=>'add-attendence', 'uses' =>'AttendanceController@addAttendence']);
    Route::get('showattendance',['as'=>'show-attendance','uses'=>'AttendanceController@show']);
    Route::get('editAtt/{id}','AttendanceController@edit');
    Route::post('editAtt/{id}',['as'=>'edit-attendence','uses'=>'AttendanceController@editAttendance']);
    Route::get('deleteAtt/{id}','AttendanceController@deleteAtt');
    Route::post('change-status','AttendanceController@changeStatus');
    Route::post('att','AttendanceController@att');
    Route::get('att-export','AttendanceController@attExport')->name('att-export');
    
    Route::get('map-view/{id}','AttendanceController@viewMap')->name('map-view');


    //Overtime

    Route::get('add-overtime',['as'=>'add-overtime','uses'=>'OverTimeController@addOvertime']);
    Route::post('save-overtime','OverTimeController@saveOverTime');
    Route::get('overtime-list',['as'=>'overtime-list', 'uses' =>'OverTimeController@show']);
    Route::get('edit-overtime/{id}','OverTimeController@editOT');
    Route::post('save-edit-overtime/{id}','OverTimeController@processEditOt');
    Route::get('delete-overtime/{id}','OverTimeController@deleteOvertime');
    Route::post('search-overtime','OverTimeController@searchOverTime');
    Route::post('overtime-change-status','OverTimeController@changeStatus');



    // Routes for Assets.

    Route::get('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@addAsset']);
    Route::post('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@processAsset']);
    Route::get('asset-listing', ['as' => 'asset-listing', 'uses' => 'AssetController@showAsset']);
    Route::get('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@showEdit']);
    Route::post('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@doEdit']);
    Route::get('delete-asset/{id}', ['as' => 'delete-asset', 'uses' => 'AssetController@doDelete']);
    Route::get('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@doAssign']);
    Route::post('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@processAssign']);
    Route::get('assignment-listing', ['as' => 'assignment-listing', 'uses' => 'AssetController@showAssignment']);
    Route::get('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@showEditAssign']);
    Route::post('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@doEditAssign']);
    Route::get('delete-asset-assignment/{id}', ['as' => 'delete-asset-assignment', 'uses' => 'AssetController@doDeleteAssign']);
    Route::get('hr-policy', ['as' => 'hr-policy', 'uses' => 'IndexController@showPolicy']);
    Route::get('download-forms', ['as' => 'download-forms', 'uses' => 'IndexController@showForms']);
    Route::get('download/{name}', 'DownloadController@downloadForms');
    Route::get('calendar', 'AuthController@calendar');



    // Routes for Leave and Holiday.

    Route::post('get-leave-count', 'LeaveController@getLeaveCount');
    Route::post('approve-leave', 'LeaveController@approveLeave');
    Route::post('disapprove-leave', 'LeaveController@disapproveLeave');
    Route::post('confirm-leave', 'LeaveController@confirmLeave');
    Route::get('add-holidays', 'LeaveController@showHolidays');
    Route::post('add-holidays', 'LeaveController@processHolidays');
    Route::get('holiday-listing', 'LeaveController@showHoliday');
    Route::get('edit-holiday/{id}', 'LeaveController@showEditHoliday');
    Route::post('edit-holiday/{id}', 'LeaveController@doEditHoliday');
    Route::get('delete-holiday/{id}', 'LeaveController@deleteHoliday');



    // Routes for Event.

    Route::get('create-event', ['as'=>'create-event','uses'=>'EventController@index']);
    Route::post('create-event', 'EventController@createEvent');
    Route::get('create-meeting', 'EventController@meeting');
    Route::post('create-meeting', 'EventController@createMeeting');



    // Routes for Award.

    Route::get('add-award', ['uses'=>'AwardController@addAward']);
    Route::post('add-award', ['uses'=>'AwardController@processAward']);
    Route::get('award-listing', ['uses'=>'AwardController@showAward']);
    Route::get('edit-award/{id}', ['uses'=>'AwardController@showAwardEdit']);
    Route::post('edit-award/{id}', ['uses'=>'AwardController@doAwardEdit']);
    Route::get('delete-award/{id}', ['uses'=>'AwardController@doAwardDelete']);
    Route::get('assign-award', ['uses'=>'AwardController@assignAward']);
    Route::post('assign-award', ['uses'=>'AwardController@processAssign']);
    Route::get('awardees-listing', ['uses'=>'AwardController@showAwardAssign']);
    Route::get('edit-award-assignment/{id}', ['uses'=>'AwardController@showAssignEdit']);
    Route::post('edit-award-assignment/{id}', ['uses'=>'AwardController@doAssignEdit']);
    Route::get('delete-award-assignment/{id}', ['uses'=>'AwardController@doAssignDelete']);



    // Routes for Prmotion.

    Route::get('promotion', ['uses'=>'EmpController@doPromotion']);
    Route::post('promotion', ['uses'=>'EmpController@processPromotion']);
    Route::get('show-promotion', ['uses'=>'EmpController@showPromotion']);
    Route::post('get-promotion-data', ['uses' => 'EmpController@getPromotionData']);



    // Routes for Training.

    Route::get('add-training-program', ['uses'=>'TrainingController@addTrainingProgram']);
    Route::post('add-training-program', ['uses'=>'TrainingController@processTrainingProgram']);
    Route::get('show-training-program', ['uses'=>'TrainingController@showTrainingProgram']);
    Route::get('edit-training-program/{id}', ['uses'=>'TrainingController@doEditTrainingProgram']);
    Route::post('edit-training-program/{id}', ['uses'=>'TrainingController@processEditTrainingProgram']);
    Route::get('delete-training-program/{id}',['uses'=>'TrainingController@deleteTrainingProgram']);
    Route::get('add-training-invite', ['uses'=>'TrainingController@addTrainingInvite']);
    Route::post('add-training-invite', ['uses'=>'TrainingController@processTrainingInvite']);
    Route::get('show-training-invite', ['uses'=>'TrainingController@showTrainingInvite']);
    Route::get('edit-training-invite/{id}', ['uses'=>'TrainingController@doEditTrainingInvite']);
    Route::post('edit-training-invite/{id}', ['uses'=>'TrainingController@processEditTrainingInvite']);
    Route::get('delete-training-invite/{id}',['uses'=>'TrainingController@deleteTrainingInvite']);
    Route::post('status-update', 'UpdateController@index');
    Route::post('post-reply', 'UpdateController@reply');
    Route::get('post/{id}', 'UpdateController@post');



    // Routes for clients 
    Route::get('add-client', 'ClientController@addClient')->name('add-client');
    Route::post('add-client', 'ClientController@saveClient');
    Route::get('list-client', 'ClientController@listClients')->name('list-client');
    Route::get('edit-client/{clientId}', 'ClientController@showEdit')->name('edit-client');
    Route::post('edit-client/{clientId}', 'ClientController@saveClientEdit');
    Route::get('delete-list/{clientId}', 'ClientController@doDelete');



    // Route for user 

    Route::get('add-user', 'UserController@addUser')->name('add-user');
    Route::post('save-user','UserController@saveUser');
    Route::get('list-user','UserController@listUser')->name('user-list');
    Route::get('edit-user/{id}','UserController@edit')->name('edit-user');
    Route::post('update-user/{id}', 'UserController@update');
    Route::get('delete-user/{id}','UserController@destroy');
    Route::get('genpass','UserController@randomPass');




    /** Routes for projects **/
    Route::get('validate-code/{code}', 'ClientController@validateCode');
    Route::get('add-project', 'ProjectController@addProject')->name('add-project');
    Route::post('add-site', 'ProjectController@saveProject');
    Route::get('edit-project/{projectId}', 'ProjectController@showEdit')->name('edit-project');
    Route::post('edit-project/{projectId}', 'ProjectController@doEdit');
    Route::get('list-project', 'ProjectController@listProject')->name('list-project');
    Route::get('edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@showEdit']);
    Route::post('edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@doEdit']);
    Route::get('delete-project/{id}', ['as' => 'delete-project', 'uses' => 'ProjectController@doDelete']);
    Route::get('assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@doAssign']);
    Route::post('assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@processAssign']);
    Route::get('project-assignment-listing', ['as' => 'project-assignment-listing', 'uses' => 'ProjectController@showProjectAssignment']);
    Route::get('edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@showEditAssign']);
    Route::post('edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@doEditAssign']);
    Route::get('delete-project-assignment/{id}', ['as' => 'delete-project-assignment', 'uses' => 'ProjectController@doDeleteAssign']);
    Route::get('upload-assignment', ['as' => 'upload-assignment', 'uses' => 'ProjectController@importFile']);
    Route::post('upload-assignment', ['as' => 'upload-assignment', 'uses' => 'ProjectController@uploadtFile']);
    Route::post('assign-search', 'ProjectController@searchassign');
    Route::post('assign-site-search', 'ProjectController@searchAssignSite');
    Route::post('project-search', 'ProjectController@searchProject');
    Route::get('/get-shifts/{projectId}', 'ProjectController@getShifts')->name('get.shifts');


    //for calender edit
    Route::get('calender', 'CalenderController@index')->name('calender.index');
    Route::post('calender', 'CalenderController@addEvent')->name('calender.add');

   
    //for parttime
    Route::post('save-part-time','PartTimeController@add');
    Route::post('edit-part-time/{id}','PartTimeController@edit');
    Route::get('parttime-list',['as'=>'parttime-list','uses'=>'PartTimeController@list']);
    Route::get('delete-parttime/{id}','PartTimeController@delete');
    Route::post('search-parttime','PartTimeController@searchPartTime');
    Route::get('export-parttime', ['as' => 'export-parttime', 'uses' => 'PartTimeController@export']);

});

Route::get('/config-clear', function() {
    Artisan::call('config:clear'); 
    return 'Configuration cache cleared!';
});

Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return 'Configuration cache cleared! <br> Configuration cached successfully!';
});

Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
    return 'Application cache cleared!';
});

Route::get('/view-cache', function() {
    Artisan::call('view:cache');
    return 'Compiled views cleared! <br> Blade templates cached successfully!';
});

Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'Compiled views cleared!';
});

Route::get('/route-cache', function() {
    Artisan::call('route:cache');
    return 'Route cache cleared! <br> Routes cached successfully!';
});

Route::get('/route-clear', function() {
    Artisan::call('route:clear');
    return 'Route cache cleared!';
});

Route::get('privacy', function(){
    return view('hrms.privacy.privacy');
});

Route::get('download', function(){
    return view('hrms.download.download');
});







#--------------------------------------------------------- API ROUTES -------------------------------------------------------------------#

#--------------------------------------------------------- VERSION (1) ------------------------------------------------------------------#

Route::group(['prefix' => 'api'], function () 
{  
    Route::post('/login','Apiv1\LoginController@login');
    Route::post('changepassword','Apiv1\LoginController@changePassword');
    // attendance
    Route::post('attendance','Apiv1\AttendanceController@attendance');
    Route::post('attendlist','Apiv1\ListController@listAttendence');
    // site
    Route::post('createSite','Apiv1\AttendanceController@createSite');
    Route::get('site','Apiv1\AttendanceController@site');
    Route::post('editSite','Apiv1\AttendanceController@editSite');
    Route::post('deleteSite','Apiv1\AttendanceController@doDelete');
    // leave
    Route::post('leave','Apiv1\AttendanceController@leave');
    Route::post('leavelist','Apiv1\ListController@listLeave');
    // overtime
    Route::post('overtime','Apiv1\AttendanceController@overtime');
    Route::post('overtimelist','Apiv1\ListController@overtimeList');
    // assign
    Route::post('assign','Apiv1\AttendanceController@assign');
    Route::get('assignlist','Apiv1\ListController@assignList');
    Route::post('editAssign','Apiv1\AttendanceController@editAssign');
    Route::post('deleteAssign','Apiv1\AttendanceController@deleteAssign');
    Route::post('userdelete','Apiv1\AttendanceController@deleteAccount');
    Route::get('employee','Apiv1\AttendanceController@employee');
    Route::post('forceupdateAndroid','Apiv1\ListController@forceupdateAndroid');
    Route::post('forceupdateIos','Apiv1\ListController@forceupdateIos');
    Route::post('userProfile','Apiv1\ListController@userProfile');
    Route::post('saveUserPhoto','Apiv1\ListController@saveuserImage');
    Route::get('adminAssign','Apiv1\ListController@assign'); #This route for admin attendance
    // admin-attendance/leave/overtime
    Route::post('adminOverTime','Apiv1\AttendanceController@adminOvertime');
    Route::post('adminLeave','Apiv1\AttendanceController@adminLeave');
    Route::post('parttime','Apiv1\AttendanceController@parttime');
    Route::get('partimelist','Apiv1\ListController@parttimeList'); 
    Route::post('logindata','Apiv1\LoginController@loginData');
});

#--------------------------------------------------------- END VERSION (1) --------------------------------------------------------------#



#--------------------------------------------------------- VERSION (2) ------------------------------------------------------------------#

Route::group(['prefix' => 'api/v2'], function () 
{
    
    // account
    Route::post('/login', 'Apiv2\LoginController@login');
    Route::post('changepassword', 'Apiv2\LoginController@changePassword');
    Route::post('userdelete', 'Apiv2\AttendanceController@deleteAccount');
    
    // attendance
    Route::post('attendance/create', 'Apiv2\AttendanceController@attendanceCreate');
    Route::post('attendance/list', 'Apiv2\ListController@AttendanceList');
    Route::post('attendance/edit', 'Apiv2\AttendanceController@attendanceEdit');
    
    // shift
    Route::post('shifts/create', 'Apiv2\AttendanceController@shiftCreate');
    Route::get('shifts', 'Apiv2\AttendanceController@shiftList');
    Route::post('shifts/edit', 'Apiv2\AttendanceController@shiftEdit');
    Route::post('shifts/delete', 'Apiv2\AttendanceController@shiftDelete');

    // site
    Route::post('sites/create', 'Apiv2\AttendanceController@siteCreate');
    Route::get('sites', 'Apiv2\AttendanceController@siteList');
    Route::post('sites/edit', 'Apiv2\AttendanceController@siteEdit');
    Route::post('sites/delete', 'Apiv2\AttendanceController@siteDelete');

    // parttime
    Route::post('parttimes/create', 'Apiv2\AttendanceController@parttimeCreate');
    Route::get('parttimes', 'Apiv2\ListController@parttimeList'); 
    
    // assign
    Route::post('assigns/create', 'Apiv2\AttendanceController@assignCreate');
    Route::get('assigns', 'Apiv2\ListController@assignList');
    Route::post('assigns/edit', 'Apiv2\AttendanceController@assignEdit');
    Route::post('assigns/delete', 'Apiv2\AttendanceController@assignDelete');
    Route::get('employees', 'Apiv2\AttendanceController@employeeList');
    Route::post('forceupdateAndroid', 'Apiv2\ListController@forceupdateAndroid');
    Route::post('forceupdateIos', 'Apiv2\ListController@forceupdateIos');
    Route::post('userProfile', 'Apiv2\ListController@userProfile');
    Route::post('saveUserPhoto', 'Apiv2\ListController@saveuserImage');

    // leave
    Route::post('leaves/create', 'Apiv2\AttendanceController@leaveCreate');
    Route::post('leaves/edit', 'Apiv2\AttendanceController@leaveEdit');
    Route::post('leaves', 'Apiv2\ListController@leaveListForOne');
    
    // overtime 
    Route::post('overtimes/create', 'Apiv2\AttendanceController@overtimeCreate');
    Route::post('overtimes/edit', 'Apiv2\AttendanceController@overtimeEdit');
    Route::post('overtimes', 'Apiv2\ListController@overtimeList');

    // admin leave / overTime
    Route::post('adminOverTime', 'Apiv2\AttendanceController@adminOvertime');
    Route::post('adminLeave', 'Apiv2\AttendanceController@adminLeave');
    Route::post('leader-login-data', 'Apiv2\LoginController@loginData');
    Route::get('admin-assigns', 'Apiv2\ListController@adminAssign');
    
});

#--------------------------------------------------------- END VERSION (2) --------------------------------------------------------------#


