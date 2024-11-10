<div id="markEmployeeAsLeft" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <form method="POST" action="{{ route('staff.mark.as.left', ['id' => $id]) }}" class="modal-dialog" role="document">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Mark as left</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="">
          Are you sure you want to mark <span class="text-primary">{{ $name }}</span> as an employee who left the school.
        </p>
        <small class="text-muted">Employees marked as left will not be shown in the employee listing, or even appear on the payrol.</small>
        <hr />
        <label for="date" class="py-1">Date Employee Left</label>
        <input type="date" name="date" id="date" class="form-control my-1" />
        <label for="reason" class="py-1">Reason for leaving the school</label>
        <textarea name="reason" id="reason" cols="10" rows="3" class="form-control rounded"></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Mark as left</button>
      </div>
    </div>
  </form>
</div>