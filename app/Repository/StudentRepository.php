<?php
namespace App\Repository;


use App\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;


use App\Models\Student;



class StudentRepository extends BaseRepository
{
    public function __construct(Student $model){
        parent::__construct($model);
    }

    
}