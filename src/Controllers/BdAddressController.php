<?php
namespace Cwp\Address\Controllers;

use Cwp\Address\Library\BdAddressService;
use Illuminate\Http\Request;


class BdAddressController extends Controller
{

    public function divisions()
    {
        return BdAddressService::getDivisions();
    }

    public function districts($division_name)
    {
        return BdAddressService::getDistricts($division_name);
    }

    public function upazilas($division_name, $district_name)
    {
        return BdAddressService::getUpazilas($division_name, $district_name);
    }

}
