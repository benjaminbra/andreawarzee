<?php

//TODO : Handle HTTP Errors

Route::group(['middleware' => ['web']], function () {

    /**
     * Login auth by Laravel
     * WORK : DONE
     */
    Route::auth();

    /**
     * Redirect user if he try to go on register
     * WORK : DONE
     */
    Route::get('/register','Redirect@login');

    /**
     * Redirect to a language home
     * WORK : DONE
     */
    Route::get('/', 'HomeController@indexDefault');

    /**
     * Every route beginning by /admin
     */
    Route::group(['prefix' => 'admin'], function(){

        /**
         * Home -> List of all projects
         */
        Route::get('/', 'Admin@index');

        /**
         * List of all paramaters
         * WORK : DONE
         */
        Route::get('/param', 'Admin@param');

        /**
         * Save the parameters
         * WORK : DONE
         */
        Route::post('/param/save', 'Admin@paramSave');

        /**
         * List of all project by a category
         * WORK : DONE
         */
        Route::get('/project/tag/{typeLabel}', 'Admin@listProject');

        /**
         * Redirect to the category list
         * WORK : DONE
         */
        Route::post('/project/load', 'Admin@loadType');

        /**
         * Form for a new project
         * WORK : DONE
         */
        Route::get('/project/new', 'Admin@newProject');

        /**
         * Form for editing a project
         * WORK : DONE
         */
        Route::get('/project/edit/{id}', 'Admin@editProject');

        /**
         * Save the project if its new or edit
         * WORK : DONE
         */
        Route::post('/project/save', 'Admin@save');

        /**
        * Save any modifications by ajax request
        * WORK : TODO -> API FUNCTIONNAL
        */
        Route::post('/project/api/save', 'Admin@apiSave');

        /**
        * Get any data by ajax request
        * WORK : TODO -> API FUNCTIONNAL
        */
        Route::post('/project/api/data', 'Admin@apiData');

        /**
        * Save images send by ajax request
        * WORK : TODO -> API FUNCTIONNAL
        */
        Route::post('/project/api/images', 'Admin@apiSaveImages');

        /**
         * Delete an image and return a json bool
         * WORK : DONE
         */
        Route::post('/project/image/delete', 'Admin@deleteImage');

        /**
         * Show the confirmation delete message
         * WORK : DONE
         */
        Route::get('/project/delete/{id}', 'Admin@deleteProject');

        Route::get('/image/optimizer', 'Admin@imageOptimizer');


    });

    /**
     * Every route beginning by /LanguageSelected -> Default Fr
     */
    Route::group(['prefix' => '{lang}'], function(){

        /**
         * Home -> List of all projects
         * WORK : TODO -> Show a default image if no vignette
         */
        Route::get('/', 'HomeController@index');

        /**
         * List of all projects of a category
         * WORK : DONE
         */
        Route::get('/type/{tagLabel}', 'HomeController@page');

        /**
         * Show details of project -> Title/Description/Gallery
         * WORK : Done
         */
        Route::get('/p/{id}', 'HomeController@project');

        /**
         * Show a static page of contact
         * WORK : DONE - IF ERROR
         */
        Route::get('/contact','HomeController@contact');

        /**
         * Send the email
         * WORK : TODO ALL
         */
        Route::post('/contact/send','HomeController@send');

    });
});
