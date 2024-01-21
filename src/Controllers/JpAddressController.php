<?php
namespace Cwp\Address\Controllers;

use Cwp\Address\Library\JpAddressService;
use Cwp\Address\Models\JpAddress;
use Illuminate\Http\Request;


class JpAddressController extends Controller
{

    public function code($pref, $city, $town)
    {
        return JpAddressService::getCodeByLocation($pref, $city, $town);
    }

    public function location($code)
    {
        return JpAddressService::getByCode($code);
    }

    public function locationList($code)
    {
        return JpAddressService::getListByCode($code);
    }

    public function prefectures()
    {
        return JpAddressService::getPrefectures();
    }

    public function cities($pref)
    {
        return JpAddressService::getCities($pref);
    }

    public function towns($pref, $city)
    {
        return JpAddressService::getTowns($pref, $city);
    }

}
