<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistLine extends Model
{
  protected $fillable = [
    'playlist_id', 'wistia_video_id','sort'
  ];
}
