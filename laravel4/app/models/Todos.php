<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 */
class Todo extends Model
{

  use SoftDeletingTrait;

  const STATUS_INCOMPLETE = 1;
  const STATUS_COMPLETE = 2;

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $dates = ['completed_at', 'deleted_at'];
}
