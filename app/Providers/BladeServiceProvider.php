<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /* @define $i = 1 */
        \Blade::extend(function ($value) {
            return preg_replace('/\@define (.+)/', '<?php ${1}; ?>', $value);
        });
    }

    public function register()
    {
        //
    }
}