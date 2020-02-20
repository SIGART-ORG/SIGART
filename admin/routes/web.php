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

use App\Access;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/main', 'PanelController@index')->name('main');
    Route::get('/information', 'PanelController@getDataDashboard')->name('main.information');
    Route::get('/information/data/', 'PanelController@getInformation')->name('main.admin.information');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/ajax/days', 'AjaxController@arrayDays');/*Revisar donde se llama*/

    Route::group(['middleware' => ['permits:1']], function () {

        Route::get('/module/dashboard', 'ModuleController@dashboard')->name('module.dashboard');
        Route::get('/module', 'ModuleController@index');
        Route::Post('/module/register', 'ModuleController@store');
        Route::PUT('/module/update', 'ModuleController@update');
        Route::Put('/module/deactivate', 'ModuleController@deactivate');
        Route::Put('/module/activate', 'ModuleController@activate');
        Route::Put('/module/delete', 'ModuleController@delete');
        Route::get('/module/select', 'ModuleController@selectModule');/*Revisar donde se llama*/

    });

    Route::group(['middleware' => ['permits:2']], function () {

        Route::get('/user/dashboard', 'UserController@dashboard')->name('user.index');
        Route::get('/user', 'UserController@index');
        Route::Post('/user/register', 'UserController@store');
        Route::PUT('/user/update', 'UserController@update');
        Route::Put('/user/deactivate', 'UserController@deactivate');
        Route::Put('/user/activate', 'UserController@activate');
        Route::Put('/user/delete', 'UserController@delete');
        Route::get('/user/{user}/sites', 'UserController@getUserSite');

    });

    Route::group(['middleware' => ['permits:3']], function () {

        Route::get('/role', 'RoleController@index');
        Route::get('/role/dashboard', 'RoleController@dashboard')->name('role.dashboard');
        Route::Post('/role/register', 'RoleController@store');
        Route::PUT('/role/update', 'RoleController@update');
        Route::Put('/role/deactivate', 'RoleController@deactivate');
        Route::Put('/role/activate', 'RoleController@activate');
        Route::Put('/role/delete', 'RoleController@delete');
        Route::get('/role/select', 'RoleController@selectRole');/*Revisar donde se llama*/
        Route::get('/role/show', 'RoleController@show');

    });


    Route::group(['middleware' => ['permits:4']], function () {

        Route::get('/page', 'PageController@index');
        Route::get('/page/dashboard/{id?}', 'PageController@dashboard')->name('pages.dashboard');
        Route::Post('/page/register', 'PageController@store');
        Route::PUT('/page/update', 'PageController@update');
        Route::Put('/page/deactivate', 'PageController@deactivate');
        Route::Put('/page/activate', 'PageController@activate');
        Route::Put('/page/delete', 'PageController@delete');

    });

    Route::group(['middleware' => ['permits:5']], function () {

        Route::get('/access/dashboard/{id?}', 'AccessController@dashboard')->name('access.dashboard');
        Route::get('/access/{role_id?}', 'AccessController@index');
        Route::Post('/access', 'AccessController@accessSystem');

    });

    Route::group(['middleware' => ['permits:6']], function () {

        Route::get('/icons/select', 'IconController@select');/*Revisar donde se llama*/
        Route::get('/icons', 'IconController@index');
        Route::get('/icons/dashboard', 'IconController@dashboard');
        Route::Post('/icons/register', 'IconController@store');
        Route::PUT('/icons/update', 'IconController@update');
        Route::Put('/icons/deactivate', 'IconController@deactivate');
        Route::Put('/icons/activate', 'IconController@activate');
        Route::Put('/icons/delete', 'IconController@delete');

    });

    Route::group(['middleware' => ['permits:7']], function () {

        Route::get('/sites', 'SiteController@index');
        Route::get('/sites/dashboard', 'SiteController@dashboard');
        Route::post('/sites/register', 'SiteController@store');
        Route::put('/sites/update', 'SiteController@update');
        Route::put('/sites/deactivate', 'SiteController@deactivate');
        Route::put('/sites/activate', 'SiteController@activate');
        Route::Put('/sites/delete', 'SiteController@delete');

    });

    Route::group(['middleware' => ['permits:8']], function () {

        Route::get('/categories', 'CategoryController@index');
        Route::get('/categories/dashboard', 'CategoryController@dashboard');
        Route::Post('/categories/register', 'CategoryController@store');
        Route::Put('/categories/update', 'CategoryController@update');
        Route::put('/categories/deactivate', 'CategoryController@deactivate');
        Route::put('/categories/activate', 'CategoryController@activate');
        Route::Put('/categories/delete', 'CategoryController@delete');

    });

    Route::group(['middleware' => ['permits:9']], function () {

        Route::get('/holidays', 'HolidayController@index');
        Route::get('/holidays/dashboard', 'HolidayController@dashboard');
        Route::Post('/holidays/register', 'HolidayController@store');
        Route::put('/holidays/update', 'HolidayController@update');
        Route::put('/holidays/deactivate', 'HolidayController@deactivate');
        Route::put('/holidays/activate', 'HolidayController@activate');
        Route::Put('/holidays/delete', 'HolidayController@delete');

    });


    Route::group(['middleware' => ['permits:10']], function () {

        Route::get('/calendar', 'GoogleCalendarController@index');
        Route::get('/calendar/dashboard', 'GoogleCalendarController@dashboard');
        Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'GoogleCalendarController@oauth']);
        Route::get('/calendario/list', 'GoogleCalendarController@list');

    });

    Route::group(['middleware' => ['permits:11']], function () {

        Route::get('/unity/dashboard', 'UnityController@dashboard');
        Route::get('/unity', 'UnityController@index');
        Route::post('/unity/register', 'UnityController@store');
        Route::put('/unity/update', 'UnityController@update');
        Route::put('/unity/deactivate', 'UnityController@deactivate');
        Route::put('/unity/activate', 'UnityController@activate');
        Route::Put('/unity/delete', 'UnityController@delete');

    });

    Route::group(['middleware' => ['permits:12']], function () {
        Route::get('logs/dashboard/', 'LogActionController@index');
        Route::get('logs/data', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });

    Route::group(['middleware' => ['permits:13']], function () {
        Route::get('loginUser/dashboard', 'UserController@loginUser');
        Route::get('supplant/{user?}', 'SupplantController@supplant');
    });

    Route::group(['middleware' => ['permits:14']], function () {
        Route::get('products/dashboard', 'ProductController@dashboard')->name('products.index');
        Route::get('products/', 'ProductController@index');
        Route::post('products/register', 'ProductController@store');
        Route::put('products/update', 'ProductController@update');
        Route::Put('products/delete', 'ProductController@destroy');
        Route::post('products/upload', 'ProductController@upload');
        Route::put('products/presentation/', 'ProductController@presentation');
        Route::get('products/download-excel', 'ProductController@downloadExcel');
        Route::post('products/upload-excel', 'ProductExcelController@uploadExcel');

        Route::get('categories/select', 'CategoryController@select');
        Route::get('unity/select/', 'UnityController@select');

        Route::put('productGalery/image-default/', 'ProductImageController@defaultImage');
        Route::get('presentation/{id}/dashboard', 'PresentationController@dashboard');
        Route::get('presentation/{id?}', 'PresentationController@index');
        Route::put('presentation/delete', 'PresentationController@destroy');
        Route::get('presentation/select/{id?}', 'PresentationController@select');
    });

    Route::group(['middleware' => ['permits:16']], function () {
        Route::get('providers/dashboard', 'ProvidersControllers@dashboard');
        Route::get('providers/', 'ProvidersControllers@index');
        Route::get('providers/config', 'ProvidersControllers@configProvider');
        Route::get('get-data-provider/', 'ProvidersControllers@getDataProvider');
        Route::post('providers/register/', 'ProvidersControllers@store');
        Route::put('providers/update', 'ProvidersControllers@update');
        Route::get('providers/{id?}/pdf', 'ProvidersControllers@generatePDF');
        Route::put('providers/deactivate', 'ProvidersControllers@deactivate');
        Route::put('providers/activate', 'ProvidersControllers@activate');
        Route::Put('providers/delete', 'ProvidersControllers@destroy');

    });

    Route::group(['middleware' => ['permits:15']], function () {
        Route::get('customers/dashboard', 'CustomersControllers@dashboard')->name('customers.index');
        Route::get('customers/', 'CustomersControllers@index');
        Route::get('customers/config', 'CustomersControllers@configCustomer');
        Route::get('get-data-customer/', 'CustomersControllers@getDataCustomer');
        Route::post('customers/register/', 'CustomersControllers@store');
        Route::put('customers/update', 'CustomersControllers@update');
        Route::get('customers/{id?}/pdf', 'CustomersControllers@generatePDF');
        Route::get('customers/pdf-example/{id}', 'CustomersControllers@examplePDF');
        Route::put('customers/deactivate', 'CustomersControllers@deactivate');
        Route::put('customers/activate', 'CustomersControllers@activate');
        Route::Put('customers/delete', 'CustomersControllers@destroy');
        Route::get('customers/generate-user/{id}', 'CustomersControllers@generateUser');
    });

    Route::group(['middleware' => ['permits:17']], function () {
        Route::get('stock/dashboard', 'StockController@dashboard')->name('stock.dashboard');
        Route::get('stock/tool/dashboard', 'StockController@dashboardTool')->name('stock.tool.dashboard');
        Route::get('stock/', 'StockController@index');
        Route::post('purchase-request/', 'PurchaseRequestController@store');
    });

    Route::group(['middleware' => ['permits:18']], function () {
        route::get('purchase-request/dashboard/', 'PurchaseRequestController@dashboard')->name('pr.index');
        route::get('purchase-request/', 'PurchaseRequestController@index');
        route::get('purchase-request/details/{id}/data', 'PurchaseRequestController@getDetails');
        Route::get('get-providers/', 'ProvidersControllers@select');
        Route::get('purchase-request/{id}/quote/', 'PurchaseRequestController@quote');
        Route::get('purchase-request/{id}/details', 'PurchaseRequestController@show');
        Route::post('purchase-request/{id}/upload', 'PurchaseRequestController@readExcel');
        Route::post('quotation/', 'QuotationController@store');
        Route::get('quotation/generate-pdf/{id}', 'QuotationController@generatePDFRequest')->name('quotation.generate-pdf');
        Route::get('quotation/generate-excel/{id}', 'QuotationController@generateExcelRequest')->name('quotation.generate-excel');
    });

    Route::group(['middleware' => ['permits:19']], function () {
        Route::get('quotations/dashboard/', 'QuotationController@dashboard')->name('quotation.index');
        Route::get('quotations/', 'QuotationController@index');
        Route::get('quotations/data/{id}', 'QuotationController@show');
        Route::post('quotations/save/', 'QuotationController@save');
        Route::get('quotation/{pr}/data-providers/', 'QuotationController@dataProviders');
        Route::post('/quotation/select/', 'QuotationAprovedController@select');
        Route::put('/quotation/cancel/', 'QuotationAprovedController@cancelQuotation');
        Route::post('/quotation/{id}/forward-mail/', 'QuotationController@forwardMail');

        Route::post('/purchase-order/generate/', 'PurchaseOrderController@generate');
        Route::get('/purchase-order/{id}/generatePDF/', 'PurchaseOrderController@generatePDFRequest');
    });

    Route::group(['middleware' => ['permits:20']], function () {
        Route::get('purchase-order/dashboard', 'PurchaseOrderController@dashboard')->name('purchase-order.index');
        Route::get('purchase-order/', 'PurchaseOrderController@index');
        Route::post('purchase-order/approve/', 'PurchaseOrderController@approve');
        Route::post('/purchase-order/{id}/forward-mail/', 'PurchaseOrderController@forwardMail');
        Route::get('/purchase-order/{id}/show/', 'PurchaseOrderController@show');
        Route::get('/purchase-order/{id}/cancel/', 'PurchaseOrderController@destroy');
    });

    Route::group(['middleware' => ['permits:21']], function () {
        Route::get('purchases/dashboard/', 'PurchaseController@dashboard')->name('purchase.index');
        Route::get('purchases/', 'PurchaseController@index');
        Route::get('purchases/{id}/complete-inf', 'PurchaseController@create');
        Route::get('purchases/{id}/show', 'PurchaseController@show');
        Route::post('purchases/new/', 'PurchaseController@store');
        Route::post('purchases/update/', 'PurchaseController@update');
        Route::put('purchases/{id}/pay/', 'PurchaseController@payPurchase');
        Route::post('purchases/{id}/upload/', 'PurchaseController@upload');
        Route::get('purchases/{id}/generatePDF/', 'PurchaseController@generatePDF');

        Route::get('provider/search/', 'ProvidersControllers@search');
        Route::get('product/search/', 'PresentationController@search');
    });

    Route::get('departaments', 'DepartamentController@allRegister')->name('departaments');
    Route::get('provinces/{departament}', 'ProvinceController@allRegister')->name('provinces');
    Route::get('districts/{departament}/{pronvince}', 'DistrictController@allRegister')->name('districts');

    Route::get('type-documents', 'TypeDocumentController@allRegister')->name('districts');

    Route::get('/reverse', 'SupplantController@reverse')->name('reverse');

    Route::get('/profile', 'UserController@profile');
    Route::get('/profile/data', 'UserController@dataSesion');
    Route::post('/profile/saveData', 'UserController@saveData');

    Route::post('/uploadFile', 'UploadFileController@upload');
    Route::get('/gallery/{id}/{rel}', 'GalleryController@gallery');
    Route::put('/gallery/{id}/delete', 'GalleryController@delete');

    /*General*/
    Route::get('/sites/select', 'SiteController@select');

    Route::group(['middleware' => ['permits:22']], function () {
        Route::get('salesquote/dashboard/', 'SalesQuoteController@dashboard');
        Route::get('salesquote/ListProductxTipService/', 'SalesQuoteController@ListProductxTipService');
        Route::get('salesquote/searchProduct/', 'SalesQuoteController@ListProduct');
        Route::get('salesquote/ViewTotalLetters/', 'SalesQuoteController@ViewTotalLetters');
        Route::post('salesquote/RegisterSales/', 'SalesQuoteController@RegisterSales');
        Route::get('salesquote/PrintQuotations/{id}', 'SalesQuoteController@PrintQuotations');
    });


    Route::group(['middleware' => ['permits:29']], function () {
//        Route::get('servicerequest/dashboard/', 'ServiceRequestController@dashboard');
//        Route::post('servicerequest/RegisterServiceRequest/', 'ServiceRequestController@RegisterServiceRequest');
//        Route::get('servicerequest/PrintServiceRequest/{id}', 'ServiceRequestController@PrintServiceRequest');
        Route::get('service_request/dashboard/', 'ServiceRequestController@dashboardServices')->name('services_request.dash');
        Route::get('service_request', 'ServiceRequestController@listServices')->name('services_request.list');
    });

    Route::group(['middleware' => ['permits:29']], function () {
        Route::put('service_request/derive', 'ServiceRequestController@derive')->name('services_request.derive');
        Route::get('service_request_derive/dashboard', 'ServiceRequestController@dashboardServicesDerive')->name('services_request_derive.dash');
        Route::get('/service-request/{service}/data/', 'ServiceRequestController@data')->name('services-request.detalle');
        Route::get('service_request/details', 'ServiceRequestController@detail')->name('services_request.details');
        Route::get('service_request/list-materials/{service}', 'GenerateListMaterialsController@listMaterials')->name('services_request.list-materials');
        Route::get('service_request/list-materials/load/{service}', 'GenerateListMaterialsController@loadMaterials')->name('services_request.load-materials');
        Route::post('service_request/list-materials/store/', 'GenerateListMaterialsController@storeMaterialesRequest')->name('services_request.store-materials');
    });



    Route::post('/sale-quotation/save/', 'SalesQuoteController@saveData')->name('sale-quotation.save');
    Route::post('/sale-quotation/send/', 'SalesQuoteController@sendQuotation')->name('sale-quotation.send');
    Route::put('/sale-quotation/action/', 'SalesQuoteController@action')->name('sale-quotation.action');
    Route::get('/sale-quotation/{id}/info/', 'SalesQuoteController@information')->where('id', '[0-9]+')->name('sale-quotation.info');
    Route::get('/sale-quotation/{sr}/info/v2/', 'SalesQuoteController@detail')->where('id', '[0-9]+')->name('sale-quotation.info.v2');

    Route::get('/service-request/{type}/dashboard/', 'ServiceRequestController@listTypeDashboard')->name('services-request.type.list');
    Route::get('/service-request/{type}/', 'ServiceRequestController@listTypeData')->name('services-request.type.data');


    Route::group(['middleware' => ['permits:24']], function () {

//        Route::get('servicerequestscompany/dashboard/', 'ServiceRequestCompanyController@dashboard');
    });

    Route::group(['middleware' => ['permits:25']], function () {
        Route::get('input-orders/dashboard', 'InputOrderController@dashboard')->name('input-order.index');
        Route::get('input-orders', 'InputOrderController@index');
        Route::post('input-orders/{id}/approved', 'InputOrderController@approvedInputDetail');
        Route::get('input-orders/details/', 'InputOrderController@show');
    });

    Route::group(['middleware' => ['permits:28']], function () {
        Route::get('input-orders/{id}/approved', 'InputOrderController@pageApproved');
    });

    Route::group(['middleware' => ['permits:26']], function () {
        Route::get('tool/dashboard', 'ToolController@dashboard')->name('tool.index');
        Route::get('tool/', 'ToolController@index');
    });

    Route::prefix('ajax')->group(function () {
        Route::post('change-site', 'UserController@changeSite');
    });

    Route::get('service/dashboard', 'ServiceController@dashboard')->name('service.dashboard');
    Route::get('service/', 'ServiceController@index')->name('service.index');
    Route::get('service/{id}/request', 'ServiceController@request')->name('service.request');
    Route::get('service/{id}/data', 'ServiceController@data')->name('service.data');

    Route::post('service/stage/new/', 'ServiceStageController@store')->name('service.stage.new');
    Route::get('/service/{id}/stage/', 'ServiceStageController@index')->name('service.stage.list');
    Route::get('/service/stage/task/{stage}/head/', 'TaskController@head')->name('service.task.head');
    Route::get('/service/{stage}/task/', 'TaskController@index')->name('service.task.list');
    Route::get('/user/workers/', 'UserController@workers')->name('user.worker.list');

    Route::get('/service/task/workers/{task}/', 'TaskController@getWorkers')->name('service.task.workers');
    Route::post('/service/task/new/', 'TaskController@store')->name('service.task.store');
    Route::post('/service/task/update/', 'TaskController@update')->name('service.task.update');
    Route::get('/service/task/{task}/delete/', 'TaskController@delete')->name('service.task.delete');
    Route::get('/service/task/{task}/show/', 'TaskController@show')->name('service.task.show');

    Route::get('/service/board/', 'TaskController@boardDashboard')->name('service.board');
    Route::get('/board/task/', 'TaskController@boardData')->name('service.board.data');

    /*-----------------------------------------------------------------------------------------------*/
    Route::get('/reference-term/', 'ReferencetermController@index')->name('reference-term.index');
    Route::get('/reference-term/dashboard/{saleQuotation?}/', 'ReferencetermController@dashboard')->name('reference-term.dashboard');
    Route::post('/reference-term/generate/', 'ReferencetermController@generate')->name('reference-term.generate');
    Route::get('/reference-term/{saleQuotation?}/data/', 'ReferencetermController@getData')->name('reference-term.data');
    Route::put('/reference-term/update/', 'ReferencetermController@update')->name('reference-term.update');
    Route::put('/reference-term/action/', 'ReferencetermController@action')->name('reference-term.action');
    Route::put('/service/send-order-pay/', 'ServiceController@sendOrderPay')->name('service.send.order-pay');
    Route::get('/reference-term/prueba/', function() {

        $referenceClass = new \App\Http\Controllers\ReferencetermController();
        $reference = \App\Models\Referenceterm::find( 2 );
        $getReference = $referenceClass->getDataReferenceTerm( $reference );

        $data = [
            'title' => 'Prueba',
            'reference' => $getReference
        ];
        return View( 'mintos.PDF.pdf-service-requirement', $data );
    })->name('reference-term.data');

    Route::get('/sales/dashboard/', 'SaleController@dashboard')->name('sale.dashboard');
    Route::get('/sales/', 'SaleController@index')->name('sale.list');
    Route::get('/sales/new/', 'SaleController@newSale')->name('sale.new');
    Route::post('/sales/new/', 'SaleController@store')->name('sale.store');
    Route::get('/sales/search/', 'SaleController@search')->name('sale.new');
    Route::get('/sales/{id}/pdf/', 'SaleController@pdf')->name('sale.pdf');
    Route::get('/sales/prueba/', function() {
        $data = [
            'title' => 'Prueba',
        ];
        return View( 'mintos.PDF.pdf-sale', $data );
    })->name('reference-term.data');
    /*-----------------------------------------------------------------------------------------------*/

});

/*Route::get('/test', function () {
    return view('test/contenido_test');
})->name('test');*/

