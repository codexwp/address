<?php
namespace Cwp\Address\Library;

use Cwp\Address\Models\JpAddress;

class JpAddressService
{

    public static function getCodeByLocation($pref, $city, $town)
    {
        $location = JpAddress::select('code')
            ->where('pref', 'LIKE', "$pref%")
            ->where('city', 'LIKE', "$city%")
            ->where('town', 'LIKE', "$town%")
            ->first();
        return $location ? $location->code : '';
    }

    public static function getByCode($code)
    {
        $location = JpAddress::where('code', $code)->first();
        return $location ? $location->toArray() : [];
    }

    public static function getLocationListByCode($code)
    {
        $location = JpAddress::where('code', $code)->first();
        $data = [
            'location' => $location,
            'list' => [
                'prefectures' => self::getPrefectures(),
                'cities' => [],
                'towns'  => []
            ]
        ];
        if($location)
        {
            $data['list']['cities'] = self::getCities($location->pref);
            $data['list']['towns'] = self::getTowns($location->pref, $location->city);
        }

        return $data;
    }

    public static function getLocationList($pref = '', $city = '', $town = '')
    {
        $data = [
            'location' => [
                'pref' => $pref,
                'city' => $city,
                'town' => $town
            ],
            'list' => [
                'prefectures' => self::getPrefectures(),
                'cities' => $pref ? self::getCities($pref) : [],
                'towns'  => $pref && $city ? self::getTowns($pref, $city) : []
            ]
        ];
        return $data;
    }

    public static function getPrefectures()
    {
        return JpAddress::select('pref')->groupBy('pref')->pluck('pref')->toArray();
    }

    public static function getCities($pref)
    {
        return JpAddress::select('city')->where('pref', $pref)->groupBy('city')->pluck('city')->toArray();
    }

    public static function getTowns($pref, $city)
    {
        return JpAddress::select('code', 'town')->where('pref', $pref)->where('city', $city)->groupBy('code', 'town')->pluck('town', 'code')->toArray();
    }

}
