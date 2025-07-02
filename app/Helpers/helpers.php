<?php

use App\Repository\SettingRepository;
use App\Repository\HostelRepository;
use App\Repositories\TermRepository;

use App\Models\Accounts\AccountingPeriod;

use App\Repository\AccountingPeriodRepository;

//use repos
use App\Entities\Clazz;
use App\Entities\Hostel;
use App\Course;

use Delgont\Auth\Models\Role;

use App\Repository\RolePermissionRepository;

//determine if auth role has permission
if(!function_exists('role_has_permission')){
    function role_has_permission($role_id, $permission){
        $permissions = app(RolePermissionRepository::class)->role($role_id)->fromCache()->permissions();
        return ($permissions) ? $permissions->contains('name', $permission) : false;
    }
}


//Get the current accounting period
//if(!function_exists('period')){
    //function period($id = null){
       // return ($id) ? app(AccountingPeriodRepository::class)->fromCache()->getPeriod($id) : app(AccountingPeriodRepository::class)->fromCache()->getCurrentPeriod();
   // }
//}

//Get the current term detials
if(!function_exists('term')){
    function term($id = null){
        return ($id) ? app(TermRepository::class)->fromCache()->getTerm($id) :app(TermRepository::class)->fromCache()->getCurrentTerm();
    }
}



//returns a option value
if(!function_exists('setting')){
    function setting($key, $object, $default = null){
        return app(SettingRepository::class)->fromCache()->value($key, $object, $default);
    }
}

//returns options of same group
if(!function_exists('settings')){
    function settings($group, $object, $default = null){
        return app(SettingRepository::class)->fromCache()->ofGroup($group, $object, $default);
    }
}


//returns a option value


if(!function_exists('clazzs_or_courses')){
    function clazzs_or_courses(){
        return (config('defaults.school_type', []) == 'tertiary') ? Course::all() : Clazz::all();
    }
}

if(!function_exists('clazzs')){
    function clazzs(){
        return Clazz::all();
    }
}


if(!function_exists('clazz_or_course_id')){
    function clazz_or_course_id(){
        return (config('defaults.school_type', []) == 'tertiary') ? 'course_id' : 'clazz_id';
    }
}


if(!function_exists('hostels_of_gender')){
    function hostels_of_gender($gender){
        return app(HostelRepository::class)->fromCache()->ofGender('male');
    }
}

if(!function_exists('hostels')){
    function hostels(){
        return app(HostelRepository::class)->fromCache()->all();
    }
}

if(!function_exists('roles')){
    function roles(){
        return Role::all();
    }
}






