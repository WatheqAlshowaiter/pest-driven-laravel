@foreach ($courses as $course)
    <h2>{{ $course->title }}</h2>
    <h2>{{ $course->description }}</h2>
@endforeach
