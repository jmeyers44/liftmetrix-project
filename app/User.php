<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent{
    //
  protected $connection = 'mongodb';
}
