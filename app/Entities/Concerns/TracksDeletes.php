<?php

namespace App\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;


trait TracksDeletes
{

   public static function bootTracksDeletes(){

      static::deleting(function($model){
         $modal->deleted_by = auth()->user()->id;
      });

   }
   
}