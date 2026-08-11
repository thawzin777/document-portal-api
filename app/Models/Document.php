<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
#[Table('documents')]
#[Fillable(['title', 'file_path', 'user_id'])]
class Document extends Model
{
    //
}
