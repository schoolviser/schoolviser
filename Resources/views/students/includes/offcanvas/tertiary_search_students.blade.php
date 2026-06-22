<div class="offcanvas offcanvas-end rounded-start" style="width: 35%;" data-bs-scroll="true" tabindex="-1" id="searchStudentOffcanvas" aria-labelledby="searchStudentLabel">

    <div class="offcanvas-header flex-column align-items-start w-100">
        
        <!-- Label on top -->
        <span class="fw-semibold mb-2">Search Student</span>
        
        <!-- Input + Button on same line -->
        <div class="d-flex w-100">
            <input 
                type="text" 
                id="searchStudentInput" 
                class="form-control me-2" 
                placeholder="Enter student name or access number"
                data-url="{{ route('students.search') }}"
            />
            <button id="searchStudentButton" class="btn btn-dark me-2">Search</button>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

    </div>

    <div class="offcanvas-body">
        <div class="card my-2 border-info">
            <div class="card-body d-flex p-1">
                <div class="px-1 fw-bold text-dark">Access Number</div>
                <div class="px-1 fw-bold text-secondary">Names</div>
                <div class="px-1 fw-bold text-secondary">Course</div>
            </div>
        </div>
    </div>

    <div class="offcanvas-footer p-4">
        <a href="" class="btn btn-md btn-dark w-100">Advanced Search</a>
    </div>

</div>
