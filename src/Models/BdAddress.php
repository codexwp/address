<?php
namespace Cwp\Address\Models;

use Cwp\Address\Address;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BdAddress extends Eloquent
{
    protected $table = Address::PREFIX . "bd_addresses";

}
