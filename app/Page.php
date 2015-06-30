<?php

namespace App;
use Storage;
use File;
use Jenssegers\Mongodb\Model as Eloquent;

class Page extends Eloquent{

  protected $connection = 'mongodb';


}
