<?php
namespace Cwp\Address\Controllers;

use Cwp\Address\Library\JapanAddressService;
use Cwp\Address\Models\JapanAddress;
use Illuminate\Http\Request;


class JpAddressController extends Controller
{

    public function code($pref, $city, $town)
    {
        return JapanAddressService::getCodeByLocation($pref, $city, $town);
    }

    public function location($code)
    {
        return JapanAddressService::getByCode($code);
    }

    public function locationList($code)
    {
        return JapanAddressService::getListByCode($code);
    }

    public function prefectures()
    {
        return JapanAddressService::getPrefectures();
    }

    public function cities($pref_name)
    {
        return JapanAddressService::getCities($pref_name);
    }

    public function towns($prefecture_name, $city_name)
    {
        return JapanAddressService::getTowns($prefecture_name, $city_name);
    }

}
