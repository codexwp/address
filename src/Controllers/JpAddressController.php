<?php
namespace Cwp\Address\Controllers;

use Cwp\Address\Models\JapaneseAddress;
use Illuminate\Http\Request;


class JpAddressController extends Controller
{

    public function location($zip_code)
    {
        $location = JapaneseAddress::where('code', $zip_code)->first();
        return $location ? $location->toArray() : [];
    }

    public function locationList($zip_code)
    {
        $location = JapaneseAddress::where('code', $zip_code)->first();
        if($location)
        {
            return [
                'location' => $location->toArray(),
                'list' => [
                    'prefectures' => $this->prefectures(),
                    'cities' => $this->cities($location->pref),
                    'towns'  => $this->towns($location->city)
                ]
            ];
        }
    }

    public function prefectures()
    {
        return JapaneseAddress::select('pref')->groupBy('pref')->pluck('pref')->toArray();
    }

    public function cities($pref_name)
    {
        return JapaneseAddress::select('city')->where('pref', $pref_name)->groupBy('city')->pluck('city')->toArray();
    }

    public function towns($city_name)
    {
        return JapaneseAddress::select('town')->where('city', $city_name)->groupBy('town')->pluck('town')->toArray();
    }

}
