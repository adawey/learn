<?php


namespace App\Localization;


use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * @var \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public $locale;


    /**
     * Localization constructor.
     * @param string $default
     */
    public function __construct($default = 'en')
    {
        $this->locale = \Session('locale');

        if(\Session('locale') != ''){
            App::setLocale(\Session('locale'));
        }else{
            if(!($default == 'en' || $default == 'ar' || $default == 'fr')){
                $default = 'en';
            }
            \Session(['locale' => $default]);
            App::setLocale($default);
            $this->locale = \Session('locale');
        }

        Carbon::setLocale($this->locale);
        if($this->locale == 'ar'){
            setlocale(LC_TIME, 'ar_eg');
        }

    }




}
