<?php
namespace Cwp\Address\Library;

use Cwp\Address\Models\BdAddress;
use Cwp\Address\Models\JpAddress;

class BdAddressService
{

    public static function getDivisions()
    {
        return BdAddress::select('division')->groupBy('division')->pluck('division')->toArray();
    }

    public static function getDistricts($division=null)
    {
        $query = BdAddress::select('district');
        if($division)
        {
            $query->where('division', $division);
        }
        return $query->groupBy('district')->pluck('district')->toArray();
    }

    public static function getUpazilas($division=null, $district=null)
    {
        $query = BdAddress::select('city');
        if($division)
        {
            $query->where('division', $division);
        }
        if($district)
        {
            $query->where('district', $district);
        }

        return $query->groupBy('city')->pluck('city')->toArray();
    }

}
