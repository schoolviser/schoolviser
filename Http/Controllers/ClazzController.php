<?php
namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Schoolviser\Entities\Clazz;

use Modules\Schoolviser\Repositories\ClazzRepository;
use Modules\Schoolviser\Services\ClazzService;

use Modules\Schoolviser\Http\Requests\StoreClazzRequest;
use Modules\Schoolviser\Http\Requests\UpdateClazzRequest;

class ClazzController extends Controller
{

    public function __construct(
        protected ClazzRepository $clazzRepository, 
        protected ClazzService $clazzService)
    {
        $this->middleware(function ($request, $next) {
            $company = company();

            if (! in_array($company->school_type, ['primary', 'secondary'])) {
                abort(403, 'Access denied. Only primary or secondary schools can manage classes.');
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = company()->id;

        $clazzs = $this->clazzRepository->company($companyId)->getClazzes();

        return view('schoolviser::clazzs.index', compact('clazzs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClazzRequest $request)
    {
        $request->validated();

        $companyId = company()->id;

        $clazz = $this->clazzService->company($companyId)->createClazz($request);

        log_activity([
            'action'     => 'created.clazz',
            'company_id' => $companyId,
            'message'    => auth()->user()->name . " created clazz with reference ".$clazz->uuid,
            'subject' => $clazz,
            'new' => $clazz,
            'visibility' => 'company_admin',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Class has been created successfully.',
                'clazz'   => $clazz
            ]);
        }

        return back()->withInput()->with('success', 'Class has been created successfully ....');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyId = company()?->id;
        $clazz = $this->clazzRepository->company($companyId)->getClazz($id);
        return view('schoolviser::clazzs.edit', compact('clazz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClazzRequest $request, $id)
    {
        $request->validated();

        $companyId = company()?->id;
        $oldClazz = $this->clazzRepository->company($companyId)->getClazz($id);

        $clazz = $this->clazzService->company($companyId)->updateClazz($oldClazz, $request);

        log_activity([
            'action'     => 'updated.clazz',
            'company_id' => $companyId,
            'message'    => auth()->user()->name . " updated clazz details with reference ".$clazz->uuid,
            'subject' => $clazz,
            'new' => $clazz,
            'old' => $oldClazz,
            'visibility' => 'company_admin',
        ]);

        return back()->withInput()->with('success', 'Clazz info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyId = company()?->id;
        $oldClazz = $this->clazzRepository->company($companyId)->fromCache()->getClazz($id);
        $deleted = $this->clazzService->company($companyId)->deleteClazz($oldClazz);

        log_activity([
            'action'     => 'updated.clazz',
            'company_id' => $companyId,
            'message'    => auth()->user()->name . " updated clazz details with reference ".$oldClazz->uuid,
            'old' => $oldClazz,
            'visibility' => 'company_admin',
        ]);
        
        if ($deleted) {
            return back()->with('success', 'Class deleted successfully.');
        }

        return back()->withErrors('Cannot delete class because it has linked termly registrations.');
    }
}
