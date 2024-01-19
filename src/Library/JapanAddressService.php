<?php
namespace Cwp\Address\Library;

use Cwp\Address\Models\JapanAddress;

class JapanAddressService
{

    public static function getCodeByLocation($pref, $city, $town)
    {
        $location = JapanAddress::select('code')
            ->where('pref', 'LIKE', "$pref%")
            ->where('city', 'LIKE', "$city%")
            ->where('town', 'LIKE', "$town%")
            ->first();
        return $location ? $location->code : '';
    }

    public static function getByCode($code)
    {
        $location = JapanAddress::where('code', $code)->first();
        return $location ? $location->toArray() : [];
    }

    public static function getListByCode($code = null)
    {
        $prefectures = self::getPrefectures();
        $data = [
            'location' => null,
            'list' => [
                'prefectures' => $prefectures,
                'cities' => [],
                'towns'  => []
            ]
        ];

        $location = JapanAddress::where('code', $code)->first();
        if($location)
        {
            $data = [
                'location' => $location->toArray(),
                'list' => [
                    'prefectures' => self::getPrefectures(),
                    'cities' => self::getCities($location->pref),
                    'towns'  => self::getTowns($location->pref, $location->city)
                ]
            ];
        }
        return $data;
    }

    public static function getPrefectures()
    {
        return JapanAddress::select('pref')->groupBy('pref')->pluck('pref')->toArray();
    }

    public static function getCities($pref)
    {
        return JapanAddress::select('city')->where('pref', $pref)->groupBy('city')->pluck('city')->toArray();
    }

    public static function getTowns($pref, $city)
    {
        return JapanAddress::select('code', 'town')->where('pref', $pref)->where('city', $city)->groupBy('code', 'town')->pluck('town', 'code')->toArray();
    }

}
