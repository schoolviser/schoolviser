<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-hover table-row-gray-400 gy-5">
    <thead>
        <tr>
        <th><input type="checkbox" class="form-check-input" id="selectAllItems" /></th>
        <th>Subject Name</th>
        <th>Short Name</th>
        <th>Level</th>
        <th>Actions</th>
        </tr>
    </thead>
    <tbody class="fs-6 fw-semibold text-gray-600">
        @foreach ($subjects as $subject)
            <tr>
            <td><input type="checkbox" class="item-checkbox form-check-input" value="{{ $subject->uuid }}"></td>
            <td>{{ $subject->name }}</td>
            <td>{{ $subject->short_name }}</td>
            <td>{{ ($subject->level == 'o' ? 'O Level' : 'A Level') }}</td>
            <td>
                <a class="btn btn-success btn-sm" href="{{ route('subjects.show', $subject->uuid) }}">View</a>
            </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</div>