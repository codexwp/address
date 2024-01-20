<?php
namespace Cwp\Address\Models;

use Cwp\Address\Address;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class JpAddress extends Eloquent
{
    protected $table = Address::PREFIX . "jp_addresses";

}
