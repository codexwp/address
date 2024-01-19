<?php

namespace Cwp\Address;

use Cwp\Address\Models\JapanAddress;

class Address
{

    public function welcome(String $sName)
    {
        return 'Hi ' . $sName . '! How are you doing today?';
    }


    public static function getPrefectures()
    {
        return JapanAddress::select('pref')->groupBy('pref')->pluck('pref')->toArray();
    }

    public static function getListByCode($code)
    {
        return JapanAddress::select('pref')->groupBy('pref')->pluck('pref')->toArray();
    }

}
