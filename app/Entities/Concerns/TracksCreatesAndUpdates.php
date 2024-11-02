<?php

namespace App\Entities\Concerns;



trait TracksCreatesAndUpdates
{

   public static function bootTracksCreatesAndUpdates(){

      static::creating(function($model){
         //$modal->created_by = auth()->user()->id;
      });

      static::updating(function($model){
         //$modal->updated_by = auth()->user()->id;
      });

   }
   
}