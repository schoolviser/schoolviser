<div id="expelStudentConfirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('students.expel', ['id' => $student->id]) }}" method="POSt">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="">Expell {{ $student->full_name }}</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="reason" id="" cols="10" rows="10" class="form-control" placeholder="Give reason for expelling {{ $student->full_name }}"></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-danger">Expel</button>
      </div>
    </form>
  </div>
</div>