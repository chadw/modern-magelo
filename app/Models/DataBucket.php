<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBucket extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'data_buckets';
}
