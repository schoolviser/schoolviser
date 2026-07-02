<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-hover table-row-gray-400 gy-5">
    <thead>
        <tr>
        <th>
            <input type="checkbox" class="form-check-input" id="selectAllItems" />
        </th>
        <th>Personal Details</th>
        <th>Academic Info.</th>
        <th>Previous Registration</th>
        <th></th>
        </tr>
    </thead>
    <tbody class="fs-6 fw-semibold text-gray-600">
        @foreach ($students as $student)
            <tr>
            <td>
                <input type="checkbox" class="item-checkbox form-check-input" value="{{ $student->uuid }}">
            </td>
            <td class="text-capitalize">
                <span><b>Full Names: </b> <a href="{{ route('students.show', ['id' => $student->uuid]) }}">{{ $student->first_name.' '.$student->last_name }}</a></span><br />
                <span><b>Gender: </b>{{ $student->gender }}</span><br />
                <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                <span><b>Nin: </b>{{ $student->nin }}</span><br />
            </td>
            <td class="text-capitalize">
                <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                <span><b>Access Number: </b>{{ $student->access_number }}</span><br />
            </td>
            <td class="text-capitalize">
                @foreach ($student->termlyRegistrations as $registration)
                <div class="bg-light p-1">
                    <span>
                    <b>Intake: </b>
                    {{ $registration?->term?->term ? termLabel($registration?->term?->term) : 'No term label' }}
                    {{ $registration?->term?->academicYear?->name }}
                    </span><br />
                    <span><b>Clazz: </b>{{ $registration?->clazz?->name }}</span><br />
                    <span><b>Residence: </b>{{ $registration->residence }}</span><br />
                    <span><b>Entry: </b>{{ $registration->new_or_continuing }}</span><br />
                </div>
                @endforeach
            </td>
            <td>
                <!-- existing single enroll button -->
                <a class="btn btn-success btn-sm" data-bs-toggle="offcanvas" data-bs-target="{{ '#enrollStudent'.$student->uuid }}">
                Enroll
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="{{ 'enrollStudent'.$student->uuid }}">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <form method="POST" action="{{ route('students.registerStudent', $student->uuid) }}">
                        @csrf
                        <div class="mb-3">
                            <label>Class</label>
                            <select id="clazz-{{ $student->uuid }}" name="clazz_id" class="form-control clazz-select">
                                @foreach ($clazzes as $clazz)
                                    <option value="{{ $clazz->id }}" data-streams='@json($clazz->streams)'>
                                        {{ $clazz->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Stream</label>
                            <select id="stream-{{ $student->uuid }}" name="stream_id" class="form-control stream-select"></select>
                        </div>


                        <div class="mb-3">
                            <label>Term</label>
                            <select name="term_id" class="form-control">
                            <option value="{{ $term->id }}">{{ termLabel($term->term).' '.$term?->academicYear?->name }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>New Or Continuing</label>
                            <select name="new_or_continuing" class="form-control">
                            <option value="new">New</option>
                            <option value="continuing" selected>Continuing</option>
                            </select>
                        </div>

                        <button class="btn btn-success w-100">Enroll Student</button>
                    </form>
                </div>
                </div>

            </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</div>