<?php
namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot AS BasicPivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pivot extends BasicPivot
{
    use SoftDeletes;
}
