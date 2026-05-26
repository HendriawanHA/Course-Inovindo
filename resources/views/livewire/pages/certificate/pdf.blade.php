<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate</title>

    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 60px;
        }

        .title {
            font-size: 48px;
            font-weight: bold;
            margin-top: 40px;
        }

        .name {
            font-size: 36px;
            color: #4f46e5;
            margin: 30px 0;
        }

        .footer {
            margin-top: 80px;
        }
    </style>
</head>

<body>

    <h4>CERTIFICATE OF COMPLETION</h4>

    <div class="title">
        {{ $course->title }}
    </div>

    <p>This certificate is proudly presented to</p>

    <div class="name">
        {{ $user->name }}
    </div>

    <p>
        For successfully completing the course.
    </p>

    <div class="footer">

        <p>
            Completion Date:
            {{ $enrollment->completed_at?->format('d M Y') }}
        </p>

        <p>
            Instructor:
            {{ $course->instructor->name ?? 'Instructor' }}
        </p>

    </div>

</body>

</html>