<table>
    <thead>
    <tr>
        <th colspan="7">{{ $section->code }} Grades Summary</th>
    </tr>
    <tr>
        <th>Name of Student</th>
        <th>Course/Yr and Section</th>
        <th>Midterm Grade Equivalent</th>
        <th>Finals Grade Equivalent</th>
        <th>Grade Average</th>
        <th>Numerical Rating</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            @php
                $mtg = round($student->getGrades($section, 1)->sum() + $student->getAttendanceGrade($section),2);
                $fg = round($student->getGrades($section, 2)->sum() + $student->getAttendanceGrade($section),2);
                $ave = round(($mtg+$fg)/2,2);
            @endphp
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $section->course->code }}/{{ $section->code }}</td>
            <td>
                {{ $grading_system->attendance_weight ? $mtg : 'N/A'}}
            </td>
            <td>
                {{ $grading_system->attendance_weight ? $fg : 'N/A'}}
            </td>
            <td>
                {{ $grading_system->attendance_weight ? $ave : 'N/A'}}
            </td>
            <td>
                {{ $grading_system->attendance_weight ? $grading_system->getGradeValue($ave) : 'N/A'}}
            </td>
            <td>
                {{ $grading_system->attendance_weight ? $grading_system->getRemarks($ave) : 'N/A'}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
