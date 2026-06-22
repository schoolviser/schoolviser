<?php
/**
 * Schoolviser (https://schoolviser.com).
 *
 * @link https://github.com/schoolviser/schoolviser source repository
 *
 * @copyright Copyright (c) 2024. Schoolviser (https://schoolviser.com)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace Modules\Student\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Entities\Clazz;
use Delgont\Core\Entities\Any;

use Modules\Student\Entities\TermlyRegistration;

class ClazzStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $registrations = TermlyRegistration::current()->whereHas('clazz', function($clazzQuery) use ($id){
            $clazzQuery->whereId($id);
        })->with(['student:id,first_name,last_name'])->paginate();

        $data = $registrations->getCollection()->transform(function($item, $key){
            return new Any([
                'id' => $item->student->id,
                'first_name' => $item->student->first_name,
                'registration' => new Any([
                    'id' => $item->id,
                    'residence' => $item->residence,
                    'new_or_continuing' => $item->new_or_continuing,
                    'clazz' => $item->clazz
                ])
            ]);
        });

        return $students = $registrations->setCollection($data);
    }


    
    public function search($id, $query)
    {
        return $registrations = TermlyRegistration::current()->whereHas('clazz', function($clazzQuery) use ($id){
            $clazzQuery->whereId($id);
        })->whereHas('student', function($studentQuery) use ($query){
            $studentQuery->where('first_name', 'LIKE', "%{$query}%")->orWhere('last_name', 'LIKE', "%{$query}%")->orWhere('regno', 'LIKE', "%{$query}%");
        })->with(['student:id,first_name,last_name'])->get();
    }
}
