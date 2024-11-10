<div id="editEmployeeWorkInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
 <form class="modal-dialog modal-lg" role="document" method="POST" action="{{ route('staff.update.work.info', ['id' => $id]) }}">
   @csrf
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="my-modal-title">Update Employee Work Info</h5>
       <button class="close" data-bs-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body row">

       <div class="col-12 col-lg-3">
         <label for="hire_date" class="text-muted text-small">Hire Date</label>
         <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date') ?? $hiredate }}" placeholder="First Name" />
       </div>

       <div class="col-12 col-lg-3">
        <label for="hire_date" class="text-muted text-small">Work Identification Number</label>
        <input type="text" name="work_number" class="form-control" value="{{ old('work_number') ?? $worknumber }}" placeholder="Work Identification Number" />
      </div>

       <div class="col-lg-3">
        @inject('positions', '\App\Models\Employee\EmployeePosition')
        <label for="position" class="text-small text-muted">Position</label>
        <select name="position" id="" class="form-control">
         @foreach ($positions->get() as $position)
             <option value="{{ $position->id }}" {{ ($position->id == $position_id) ? 'selected' : '' }}>{{ $position->name }}</option>
         @endforeach
        </select>
       </div>

       <div class="col-lg-12 py-1">
        <div class="custom-control custom-checkbox">
         <small class="text-muted">Departments</small><br />
         @inject('departments', '\App\Models\Department\Department')
         @foreach ($departments->get() as $department)
           <div class="mr-5">
            <input id="{{ 'department'.$department->id }}" class="custom-control-input" type="checkbox" name="departments[]" value="{{ $department->id }}" {{ (in_array($department->id, $departmentIds)) ? 'checked' : '' }}>
            <label for="{{ 'department'.$department->id }}" class="custom-control-label pr-5">{{ $department->name }}</label>
           </div>
         @endforeach
        </div>
       </div>
     </div>
     <div class="modal-footer text-start">
       <button type="submit" class="btn btn-md btn-primary">Update Info</button>
     </div>
   </div>
 </form>
</div>
