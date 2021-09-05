<?php

use Illuminate\Support\Facades\Route;
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
$namespace = 'App\Modules\Admin\Controllers';

Route::group(
    ['namespace' => $namespace, 'prefix'=>'error', 'middleware' => ['web']],
    function() {
        Route::get('', 'ErrorController@ServerError')->name('ErrorIndex');
        Route::get('500', 'ErrorController@ServerError')->name('ServerError');
        Route::get('404', 'ErrorController@PageNotFound')->name('PageNotFound');
        Route::get('403', 'ErrorController@AccessDenied')->name('AccessDenied');
    }
);

Route::group(
    ['namespace' => $namespace, 'prefix'=>'admin', 'middleware' => ['web']],
    function() {
        Route::get('login', 'LoginController@Login')->name('AdminLogin');
        Route::post('login/check-login', 'LoginController@CheckLogin')->name('AdminCheckLogin');
        Route::get('logout', 'LoginController@Logout')->name('AdminLogout');
    }
);

Route::group(
    ['namespace' => $namespace, 'prefix'=>'admin', 'middleware' => ['web', 'auth']],
    function() {
        Route::get('', 'DashboardController@Index')->name('AdminDashboard');
        Route::get('dashboard', 'DashboardController@Index')->name('AdminDashboard2');

        Route::post('login/refresh-token', 'LoginController@RefreshToken')->name('RefreshToken');
        //Profile
        Route::get('profile', 'ProfileController@Index')->name('Profile');
        Route::post('profile/edit-profile/update-profile', 'ProfileController@UpdateProfile')->name('UpdateProfile');
        Route::post('profile/edit-profile/update-password', 'ProfileController@UpdatePassword')->name('UpdatePassword');

        // News
        Route::get('news-management/list-of-news', 'NewsManagementController@ListOfNews')->name('ListOfNews');
        Route::post('news-management/list-of-news/delete', 'NewsManagementController@DeleteNews')->name('DeleteNews');
        Route::post('news-management/list-of-news/update-status', 'NewsManagementController@UpdateStatus')->name('UpdateStatusOfNews');
        Route::get('news-management/news-detail/create-news', 'NewsManagementController@CreateNews')->name('CreateNews');
        Route::get('news-management/news-detail/edit-news/{id}', 'NewsManagementController@EditNews')->name('EditNews');
        Route::post('news-management/news-detail/create-news/insert-news', 'NewsManagementController@InsertNews')->name('InsertNews');
        Route::post('news-management/news-detail/edit-news/update-news', 'NewsManagementController@UpdateNews')->name('UpdateNews');

        // Careers
        Route::get('careers-management/careers', 'CareersManagementController@ListOfCareers')->name('ListOfCareers');
        Route::post('careers-management/careers/delete', 'CareersManagementController@DeleteCareers')->name('DeleteCareers');
        Route::post('careers-management/careers/update-status', 'CareersManagementController@UpdateStatus')->name('UpdateStatusOfCareers');
        Route::get('careers-management/careers-detail/create-careers', 'CareersManagementController@CreateCareer')->name('CreateCareer');
        Route::get('careers-management/careers-detail/edit-careers/{id}', 'CareersManagementController@EditCareer')->name('EditCareer');
        Route::post('careers-management/careers-detail/create-careers/insert-careers', 'CareersManagementController@InsertCareer')->name('InsertCareer');
        Route::post('careers-management/careers-detail/edit-careers/update-careers', 'CareersManagementController@UpdateCareer')->name('UpdateCareer');

        Route::get('careers-management/candidates', 'CandidatesManagementController@ListOfCandidates')->name('ListOfCandidates');
        Route::post('careers-management/candidates/delete', 'CandidatesManagementController@DeleteCandidates')->name('DeleteCandidates');
        Route::get('careers-management/candidates/view-candidates/{id}', 'CandidatesManagementController@ViewCandidate')->name('ViewCandidate');
        Route::post('careers-management/candidates/edit-candidates/update-candidates', 'CandidatesManagementController@UpdateCandidate')->name('UpdateCandidate');
        Route::post('careers-management/candidates/edit-candidates/approve-candidates', 'CandidatesManagementController@ApproveCandidate')->name('ApproveCandidate');
        Route::post('careers-management/candidates/edit-candidates/reject-candidates', 'CandidatesManagementController@RejectCandidate')->name('RejectCandidate');

        // Client
        Route::get('clients-management/clients', 'ClientsManagementController@ListOfClients')->name('ListOfClients');
        Route::post('clients-management/clients/delete', 'ClientsManagementController@DeleteClients')->name('DeleteClients');
        Route::post('clients-management/clients/update-status', 'ClientsManagementController@UpdateStatus')->name('UpdateStatusOfClients');
        Route::get('clients-management/clients-detail/create-clients', 'ClientsManagementController@CreateClient')->name('CreateClient');
        Route::get('clients-management/clients-detail/edit-clients/{id}', 'ClientsManagementController@EditClient')->name('EditClient');
        Route::post('clients-management/clients-detail/create-clients/insert-clients', 'ClientsManagementController@InsertClient')->name('InsertClient');
        Route::post('clients-management/clients-detail/edit-clients/update-clients', 'ClientsManagementController@UpdateClient')->name('UpdateClient');

        //Contact
        Route::get('contacts-management/contacts', 'ContactsManagementController@ListOfContacts')->name('ListOfContacts');
        Route::post('contacts-management/contacts/delete', 'ContactsManagementController@DeleteContacts')->name('DeleteContacts');
        Route::post('contacts-management/contacts/update-status', 'ContactsManagementController@UpdateStatus')->name('UpdateStatusOfContacts');
        Route::get('contacts-management/contacts/view-contacts/{id}', 'ContactsManagementController@ViewContact')->name('ViewContact');
        Route::post('contacts-management/contacts/resolve-contact', 'ContactsManagementController@ResolveContact')->name('ResolveContact');
        Route::post('contacts-management/contacts/close-contact', 'ContactsManagementController@CloseContact')->name('CloseContact');


        // Systems
        Route::get('systems-management/locations', 'LocationsManagementController@ListOfLocations')->name('ListOfLocations');
        Route::get('systems-management/locations-detail/edit-locations/{id}', 'LocationsManagementController@EditLocation')->name('EditLocation');
        Route::post('systems-management/locations-detail/edit-locations/update-locations', 'LocationsManagementController@UpdateLocation')->name('UpdateLocation');

        Route::get('systems-management/system-variables', 'SystemVariablesManagementController@ListOfSystemVariables')->name('ListOfSystemVariables');
        Route::get('systems-management/system-variables/edit-variables/{id}', 'SystemVariablesManagementController@EditSystemVariable')->name('EditSystemVariable');
        Route::post('systems-management/system-variables/edit-variables/update-variable', 'SystemVariablesManagementController@UpdateSystemVariable')->name('UpdateSystemVariable');

        Route::get('systems-management/delivery-models', 'DeliveryModelsManagementController@ListOfDeliveryModels')->name('ListOfDeliveryModels');
        Route::get('systems-management/delivery-models/edit-delivery-models/{id}', 'DeliveryModelsManagementController@EditDeliveryModel')->name('EditDeliveryModel');
        Route::post('systems-management/delivery-models/edit-delivery-models/update-delivery-model', 'DeliveryModelsManagementController@UpdateDeliveryModel')->name('UpdateDeliveryModel');
        Route::get('systems-management/delivery-models/delivery-model-details', 'DeliveryModelsManagementController@ListOfDeliveryModelDetails')->name('ListOfDeliveryModelDetails');

        Route::get('systems-management/contract-types', 'ContractTypesManagementController@ListOfContractTypes')->name('ListOfContractTypes');
        Route::get('systems-management/contract-types/edit-contract-types/{id}', 'ContractTypesManagementController@EditContractType')->name('EditContractType');
        Route::post('systems-management/contract-types/edit-contract-types/update-contract-type', 'ContractTypesManagementController@UpdateContractType')->name('UpdateContractType');
        Route::get('systems-management/contract-types/{id}/contract-type-details', 'ContractTypesManagementController@ListOfContractTypeDetails')->name('ListOfContractTypeDetails');
        Route::get('systems-management/contract-types/edit-contract-type-details/{id}', 'ContractTypesManagementController@EditContractTypeDetail')->name('EditContractTypeDetail');
        Route::post('systems-management/contract-types/edit-contract-types/update-contract-type-detail', 'ContractTypesManagementController@UpdateContractTypeDetail')->name('UpdateContractTypeDetail');

        Route::get('systems-management/company-profiles', 'CompanyProfilesManagementController@ListOfCompanyProfile')->name('ListOfCompanyProfile');
        Route::get('systems-management/company-profiles/edit-company-profile/{id}', 'CompanyProfilesManagementController@EditCompanyProfile')->name('EditCompanyProfile');
        Route::post('systems-management/company-profiles/company-profile/update-company-profiles', 'CompanyProfilesManagementController@UpdateCompanyProfile')->name('UpdateCompanyProfile');

    }
);
