<div
 class="modal fade"
 id="{{ 'updateTermModal'.$term->id }}"
 tabindex="-1"
 data-bs-backdrop="static"
 data-bs-keyboard="false"
 role="dialog"
 aria-labelledby="modalTitleId"
 aria-hidden="true"
>
 <div
  class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
  role="document"
 >
  <form class="modal-content" action="{{ route('terms.update', ['id' => $term->id]) }}" method="POST">
    @csrf
   <div class="modal-header">
    <h5 class="modal-title font-12" id="modalTitleId">
     Edit Term Details
    </h5>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
     aria-label="Close"
    ></button>
   </div>
   <div class="modal-body row">
    <div class="col-lg-12">

      <label for="" class="font-10 mb-1 bg-light">Years</label>
      <select name="year" id="" class="form-control text-success rounded-0" style="font-weight: 700;">
       @for ($i = 0; $i < option('look_back_years', 5); $i++)
       <option value="{{ $term->year - $i }}" {{ (($term->year - $i) == request('year')) ? 'selected' : '' }}>{{ $term->year - $i }}</option>
       @endfor
     </select>
     <small class="text-small text-danger">{{ $errors->first('year') }}</small>

      <label for="" class="font-10 text-muted">Term</label>
      <select name="term" id="" class="form-control text-danger rounded-0">
        <option value="1" {{ ($term->term == 1) ? 'selected' : '' }}>Term One</option>
        <option value="2" {{ ($term->term == 2) ? 'selected' : '' }}>Term Two</option>
        <option value="3" {{ ($term->term == 3) ? 'selected' : '' }}>Term Three</option>
      </select>
      <small class="text-small text-danger">{{ $errors->first('term') }}</small>

      <label for="" class="font-10 text-muted">Start Date</label>
      <input type="date" name="start_date" class="form-control" value="{{$term->start_date}}">
      <small class="text-small text-danger">{{ $errors->first('start_date') }}</small>

      <label for="" class="font-10 text-muted">End Date</label>
      <input type="date" name="end_date" class="form-control" value="{{$term->end_date}}">
      <small class="text-small text-danger">{{ $errors->first('end_date') }}</small>

      <label for="" class="font-10 text-muted">End Date</label>
      <input type="date" name="next_term_start_date" class="form-control" value="{{$term->next_term_start_date}}">
      <small class="text-small text-danger">{{ $errors->first('next_term_start_date') }}</small>

    </div>
   </div>
   <div class="modal-footer">
    <button
     type="button"
     class="btn btn-secondary rounded-5 px-3"
     data-bs-dismiss="modal"
    >
     Close
    </button>
    <button type="submit" class="btn btn-primary rounded-5 px-3">Update</button>
   </div>
  </form>
 </div>
</div>
