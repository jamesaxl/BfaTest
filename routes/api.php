<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', 'Api\PassportController@login');
Route::post('register', 'Api\PassportController@register');
Route::get('active/{code}', 'Api\PassportController@activeAccount');

Route::middleware('auth:api')->group(function () {

    Route::prefix('project')->group(function () {
        Route::get('/all', 'Api\ProjectController@index');
        Route::get('/all-np', 'Api\ProjectController@indexAll');
        Route::get('/show/{id}', 'Api\ProjectController@show');
        Route::post('/store', 'Api\ProjectController@store');
        Route::post('/update/{id}', 'Api\ProjectController@update');
        Route::post('/all-grid', 'Api\ProjectController@indexGrid');

        Route::delete('/delete/{id}', 'Api\ProjectController@destroy');
    });

    Route::prefix('opportunity')->group(function () {
        Route::get('/all', 'Api\OpportunityController@index');
        Route::post('/store', 'Api\OpportunityController@store');
        Route::post('/update/{id}', 'Api\OpportunityController@update');
        Route::get('/show/{id}', 'Api\OpportunityController@show');
        Route::delete('/delete/{id}', 'Api\OpportunityController@destroy');

        Route::post('/all-grid', 'Api\OpportunityController@indexGrid');
    });

    Route::get('logout', 'Api\PassportController@logout');

        Route::middleware(['check.admin'])->group(function () {
            Route::prefix('a')->group(function () {

                Route::prefix('company')->group(function () {
                    Route::get('/all', 'Api\CompanyController@index');
                    Route::get('/show/{id}', 'Api\CompanyController@show');
                    Route::post('/store', 'Api\CompanyController@store');
                    Route::post('/update/{id}', 'Api\CompanyController@update');
                    Route::delete('/delete/{id}', 'Api\CompanyController@destroy');
                    Route::post('/all-grid', 'Api\CompanyController@indexGrid');
                });

                Route::prefix('supplier')->group(function () {
                    Route::get('/all', 'Api\SupplierController@index');
                    Route::get('/show/{id}', 'Api\SupplierController@show');
                    Route::post('/store', 'Api\SupplierController@store');
                    Route::post('/update/{id}', 'Api\SupplierController@update');
                    Route::delete('/delete/{id}', 'Api\SupplierController@destroy');
                    Route::post('/all-grid', 'Api\SupplierController@indexGrid');
                });

                Route::prefix('consultant')->group(function () {
                    Route::get('/all', 'Api\ConsultantController@index');
                    Route::get('/show/{id}', 'Api\ConsultantController@show');
                    Route::post('/store', 'Api\ConsultantController@store');
                    Route::post('/update/{id}', 'Api\ConsultantController@update');
                    Route::delete('/delete/{id}', 'Api\ConsultantController@destroy');
                    Route::post('/all-grid', 'Api\ConsultantController@indexGrid');
                });

                Route::prefix('firm-consultant')->group(function () {
                    Route::get('/all', 'Api\FirmConsultantController@index');
                    Route::get('/show/{id}', 'Api\FirmConsultantController@show');
                    Route::post('/store', 'Api\FirmConsultantController@store');
                    Route::post('/update/{id}', 'Api\FirmConsultantController@update');
                    Route::delete('/delete/{id}', 'Api\FirmConsultantController@destroy');
                    Route::post('/all-grid', 'Api\FirmConsultantController@indexGrid');
                });

                Route::prefix('funder')->group(function () {
                    Route::get('/all', 'Api\FunderController@index');
                    Route::get('/show/{id}', 'Api\FunderController@show');
                    Route::post('/store', 'Api\FunderController@store');
                    Route::post('/update/{id}', 'Api\FunderController@update');
                    Route::delete('/delete/{id}', 'Api\FunderController@destroy');
                    Route::post('/all-grid', 'Api\FunderController@indexGrid');
                });

                Route::prefix('government')->group(function () {
                    Route::get('/all', 'Api\GovernmentController@index');
                    Route::get('/show/{id}', 'Api\GovernmentController@show');
                    Route::post('/store', 'Api\GovernmentController@store');
                    Route::post('/update/{id}', 'Api\GovernmentController@update');
                    Route::delete('/delete/{id}', 'Api\GovernmentController@destroy');
                    Route::post('/all-grid', 'Api\GovernmentController@indexGrid');
                });

                Route::prefix('investor')->group(function () {
                    Route::get('/all', 'Api\InvestorController@index');
                    Route::get('/show/{id}', 'Api\InvestorController@show');
                    Route::post('/store', 'Api\InvestorController@store');
                    Route::post('/update/{id}', 'Api\InvestorController@update');
                    Route::delete('/delete/{id}', 'Api\InvestorController@destroy');
                    Route::post('/all-grid', 'Api\InvestorController@indexGrid');
                });

                Route::prefix('ong')->group(function () {
                    Route::get('/all', 'Api\OngController@index');
                    Route::get('/show/{id}', 'Api\OngController@show');
                    Route::post('/store', 'Api\OngController@store');
                    Route::post('/update/{id}', 'Api\OngController@update');
                    Route::delete('/delete/{id}', 'Api\OngController@destroy');
                    Route::post('/all-grid', 'Api\OngController@indexGrid');
                });

                Route::prefix('transporter')->group(function () {
                    Route::get('/all', 'Api\TransporterController@index');
                    Route::get('/show/{id}', 'Api\TransporterController@show');
                    Route::post('/store', 'Api\TransporterController@store');
                    Route::post('/update/{id}', 'Api\TransporterController@update');
                    Route::delete('/delete/{id}', 'Api\TransporterController@destroy');
                    Route::post('/all-grid', 'Api\TransporterController@indexGrid');
                });

                Route::prefix('financial-institution')->group(function () {
                    Route::get('/all', 'Api\FinancialInstitutionController@index');
                    Route::get('/show/{id}', 'Api\FinancialInstitutionController@show');
                    Route::post('/store', 'Api\FinancialInstitutionController@store');
                    Route::post('/update/{id}', 'Api\FinancialInstitutionController@update');
                    Route::delete('/delete/{id}', 'Api\FinancialInstitutionController@destroy');
                    Route::post('/all-grid', 'Api\FinancialInstitutionController@indexGrid');
                });


            });
        });

    Route::prefix('user')->group(function () {
        Route::get('/detail', 'Api\PassportController@details');

        Route::middleware(['check.admin'])->group(function () {
            Route::get('/all', 'Api\UserController@index');
            Route::get('/show/{id}', 'Api\UserController@show');
            Route::post('/store', 'Api\UserController@store');
            Route::post('/update/{id}', 'Api\UserController@update');
            Route::delete('/delete/{id}', 'Api\UserController@destroy');
            Route::post('/all-grid', 'Api\UserController@indexGrid');

            Route::prefix('bfa')->group(function () {
                Route::post('/store', 'Api\Admin\BfaController@store');
                Route::post('/update/{id}', 'Api\Admin\BfaController@update');
            });

        });
    });

    Route::prefix('media')->group(function () {
        Route::get('/all', 'Api\MediaController@index');
        Route::get('/show/{id}', 'Api\MediaController@show');
        Route::post('/store', 'Api\MediaController@store');
        Route::post('/update/{id}', 'Api\MediaController@update');
        Route::delete('/delete/{id}', 'Api\MediaController@destroy');
        Route::post('/all-grid', 'Api\MediaController@indexGrid');
    });

    Route::prefix('fund')->group(function () {
        Route::get('/all', 'Api\FundController@index');
        Route::get('/show/{id}', 'Api\FundController@show');
        Route::post('/store', 'Api\FundController@store');
        Route::post('/update/{id}', 'Api\FundController@update');
        Route::delete('/delete/{id}', 'Api\FundController@destroy');
        Route::post('/all-grid', 'Api\FundController@indexGrid');
    });

    Route::prefix('faq')->group(function () {
        Route::get('/all', 'Api\QuestionAnswerController@index');
        Route::get('/show/{id}', 'Api\QuestionAnswerController@show');
        Route::post('/store', 'Api\QuestionAnswerController@store');
        Route::post('/update/{id}', 'Api\QuestionAnswerController@update');
        Route::delete('/delete/{id}', 'Api\QuestionAnswerController@destroy');
        Route::post('/all-grid', 'Api\QuestionAnswerController@indexGrid');
    });

    Route::prefix('video')->group(function () {
        Route::get('/all', 'Api\VideoController@index');
        Route::get('/show/{id}', 'Api\VideoController@show');
        Route::post('/store', 'Api\VideoController@store');
        Route::post('/update/{id}', 'Api\VideoController@update');
        Route::delete('/delete/{id}', 'Api\VideoController@destroy');
        Route::post('/all-grid', 'Api\VideoController@indexGrid');
    });

    Route::prefix('contact')->group(function () {
        Route::get('/all', 'Api\ContactController@index');
        Route::get('/show/{id}', 'Api\ContactController@show');
        Route::post('/store', 'Api\ContactController@store');
        Route::post('/update/{id}', 'Api\ContactController@update');
        Route::delete('/delete/{id}', 'Api\ContactController@destroy');
        Route::post('/all-grid', 'Api\ContactController@indexGrid');
    });

    Route::prefix('country')->group(function () {
        Route::get('/all', 'Api\CountryController@index');
        Route::get('/show/{id}', 'Api\CountryController@show');
        Route::get('/continent/{continent_id}', 'Api\CountryController@indexInContinent');
        Route::post('/all-grid', 'Api\CountryController@indexGrid');
    });

    Route::prefix('continent')->group(function () {
        Route::get('/show/{id}', 'Api\ContinentController@show');
        Route::get('/all', 'Api\ContinentController@index');
    });

    Route::prefix('city')->group(function () {
        Route::get('/country/{country_id}', 'Api\CityController@indexInCountry');
    });

    Route::prefix('sector')->group(function () {
        Route::get('/all', 'Api\SectorController@index');
        Route::get('/show/{id}', 'Api\SectorController@show');
        Route::post('/store', 'Api\SectorController@store');
        Route::post('/update/{id}', 'Api\SectorController@update');
        Route::delete('/delete/{id}', 'Api\SectorController@destroy');
        Route::post('/all-grid', 'Api\SectorController@indexGrid');
    });

    Route::prefix('post')->group(function () {
        Route::get('/all', 'Api\PostController@index');
        Route::get('/show/{id}', 'Api\PostController@show');
        Route::post('/store', 'Api\PostController@store');
        Route::post('/update/{id}', 'Api\PostController@update');
        Route::delete('/delete/{id}', 'Api\PostController@destroy');

        Route::post('/all-grid', 'Api\PostController@indexGrid');
    });

    Route::middleware(['check.organization.exist'])->group(function () {
        Route::prefix('organization')->group(function () {
            Route::prefix('user')->group(function () {

                Route::get('/all', 'Api\Organization\UserController@index'); // only users that belong to organization

                Route::get('/show/{id}', 'Api\Organization\UserController@show'); // if user belong to organization

                Route::post('/store', 'Api\Organization\UserController@store'); // store in organization

                Route::post('/update/{id}', 'Api\Organization\UserController@update'); // update only his/her organization

                Route::delete('/delete/{id}', 'Api\Organization\UserController@destroy'); // No

                Route::post('/all-grid', 'Api\Organization\UserController@indexGrid'); // only users that belong to organization
            });
        });
    });

    Route::middleware(['check.organization.owner'])->group(function () {
        Route::prefix('company')->group(function () {
            Route::get('/show/{id}', 'Api\CompanyController@show');
            Route::post('/update/{id}', 'Api\CompanyController@update');

            Route::prefix('transporter')->group(function () {
                Route::get('/show/{id}', 'Api\TransporterController@show');
                Route::post('/update/{id}', 'Api\TransporterController@update');
            });
        });

        Route::prefix('consultant')->group(function () {
            Route::get('/show/{id}', 'Api\ConsultantController@show');
            Route::post('/update/{id}', 'Api\ConsultantController@update');

        });

        Route::prefix('firm-consultant')->group(function () {
            Route::get('/show/{id}', 'Api\FirmConsultantController@show');
            Route::post('/update/{id}', 'Api\FirmConsultantController@update');
        });

        Route::prefix('financial-institution')->group(function () {
            Route::get('/show/{id}', 'Api\FinancialInstitutionController@show');
            Route::post('/update/{id}', 'Api\FinancialInstitutionController@update');

            Route::prefix('insurance')->group(function () {
                Route::get('/show/{id}', 'Api\InsuranceController@show');
                Route::post('/update/{id}', 'Api\InsuranceController@update');
            });
        });

        Route::prefix('funder')->group(function () {
            Route::get('/show/{id}', 'Api\FunderController@show');
            Route::post('/update/{id}', 'Api\FunderController@update');
        });

        Route::prefix('government')->group(function () {
            Route::get('/show/{id}', 'Api\GovernmentController@show');
            Route::post('/update/{id}', 'Api\GovernmentController@update');
        });

        Route::prefix('investor')->group(function () {
            Route::get('/show/{id}', 'Api\InvestorController@show');
            Route::post('/update/{id}', 'Api\InvestorController@update');
        });

        Route::prefix('ong')->group(function () {
            Route::get('/show/{id}', 'Api\OngController@show');
            Route::post('/update/{id}', 'Api\OngController@update');
        });

        Route::prefix('supplier')->group(function () {
            Route::get('/show/{id}', 'Api\SupplierController@show');
            Route::post('/update/{id}', 'Api\SupplierController@update');
        });
    });



    Route::prefix('job')->group(function () {
        Route::get('/all', 'Api\JobController@index');
        Route::post('/store', 'Api\JobController@store');
        Route::post('/update/{id}', 'Api\JobController@update');
        Route::get('/show/{id}', 'Api\JobController@show');
        Route::delete('/delete/{id}', 'Api\JobController@destroy');
        Route::post('/all-grid', 'Api\JobController@indexGrid');
    });

});

Route::prefix('role')->group(function () {
    Route::get('/{for}', 'Api\RoleController@index');
});

Route::prefix('producer')->group(function () {
    Route::get('/all', 'Api\ProducerController@index');
});

Route::prefix('country')->group(function () {
    Route::get('/all', 'Api\CountryController@index');
    Route::get('/show/{id}', 'Api\CountryController@show');
    Route::get('/continent/{continent_id}', 'Api\CountryController@indexInContinent');
    Route::post('/all-grid', 'Api\CountryController@indexGrid');
    Route::post('/update/{id}', 'Api\CountryController@update');
});

Route::prefix('document')->group(function () {
    Route::get('/all', 'Api\DocumentController@index');
    Route::get('/show/{id}', 'Api\DocumentController@show');
    Route::post('/store', 'Api\DocumentController@store');
    Route::post('/all-grid', 'Api\DocumentController@indexGrid');
    Route::post('/update/{id}', 'Api\DocumentController@update');
    Route::delete('/delete/{id}', 'Api\DocumentController@destroy');
});

Route::prefix('document-type')->group(function () {
    Route::get('/all', 'Api\DocumentTypeController@index');
    Route::get('/show/{id}', 'Api\DocumentTypeController@show');
});

Route::prefix('account-type')->group(function () {
    Route::get('/all', 'Api\AccountTypeController@index');
});

Route::prefix('account-subtype')->group(function () {
    Route::get('/all', 'Api\AccountSubTypeController@index');
    Route::get('/account-type/{accountTypeId}', 'Api\AccountSubTypeController@inAccountType');
});

Route::prefix('speciality')->group(function () {
    Route::get('/all', 'Api\SpecialityController@index');
});

Route::prefix('qualification')->group(function () {
    Route::get('/all', 'Api\QualificationController@index');
});

Route::prefix('sector')->group(function () {
    Route::get('/all', 'Api\SectorController@index');
    Route::get('/show/{id}', 'Api\SectorController@show');
    Route::post('/store', 'Api\SectorController@store');
    Route::post('/update/{id}', 'Api\SectorController@update');
    Route::delete('/delete/{id}', 'Api\SectorController@destroy');
    Route::post('/all-grid', 'Api\SectorController@indexGrid');
});

Route::prefix('sub-sector')->group(function () {
    Route::get('/sector/{sector_id}', 'Api\SubSectorController@indexInSector');
    Route::get('/all', 'Api\SubSectorController@index');
    Route::get('/show/{id}', 'Api\SubSectorController@show');
    Route::post('/store', 'Api\SubSectorController@store');
    Route::post('/update/{id}', 'Api\SubSectorController@update');
    Route::delete('/delete/{id}', 'Api\SubSectorController@destroy');
    Route::post('/all-grid', 'Api\SubSectorController@indexGrid');
});





Route::prefix('user')->group(function () {
    Route::post('/follow', 'Api\UserController@follow');
    Route::get('/followers', 'Api\UserController@followers');
    Route::get('/followeds', 'Api\UserController@followeds');
});



