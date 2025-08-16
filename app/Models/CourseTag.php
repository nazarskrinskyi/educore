<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseTag extends Pivot
{
    protected $table = 'course_tag';

    public $timestamps = false;
}
