<?php
/**
 * Created by PhpStorm.
 * User: rlutter
 * Date: 15-12-02
 * Time: 16:14
 */

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class NotWithValidator extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('not_with', function($attribute, $value, $parameters, $validator) {
            $paramValue = array_get($validator->getData(), $parameters[0], null);
            return ($value != '' && $paramValue != '') ? false : true;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}