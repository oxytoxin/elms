<table>
    <thead>
    <tr>
        <th colspan="2">{{ $section->code }} Course Orientation Summary</th>
    </tr>
    <tr>
        <th>Name of Student</th>
        <th>Course/Yr and Section</th>
    </tr>
    </thead>
    <tbody>
        @foreach($section->students->sortBy('user.name') as $student)
        <tr>
            <td>{{ $student->user->name }}</td>
            <td>{{ $section->course->code }}/{{ $section->code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
