<div id="{{ 'confirmStudentDeleteModal'.$student_id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Confirm Student Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are your sure you want to delete <span class="text-primary font-weight-semibold">{{ $student_names }}</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a href="{{ route('students.delete', ['id' => $student_id]) }}" class="btn btn-primary">Yes, Continue</a>
      </div>
    </div>
  </div>
</div>