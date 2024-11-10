<div id="{{ 'parentCategory'.$id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('accounting.expenses.categories.store', ['parent_id' => $id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Add Expense Category</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-6">
          <label for="" class="font-12 text-muted">Name</label>
          <input type="text" name="name" class="form-control" />
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn bt">Save</button>
      </div>
    </form>
  </div>
</div>