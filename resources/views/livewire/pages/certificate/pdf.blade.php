<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap" rel="stylesheet">
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Source Serif 4", serif;
        }

        .certificate {
            position: relative;

            width: 100%;
            height: 100vh;
        }

        .bg {
            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            display: block;
        }

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE ID
        |--------------------------------------------------------------------------
        */

        .certificate-id {
            position: absolute;
            top: 9.6%;
            left: 17.5%;

            font-size: 18px;
            color: #111;
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT NAME
        |--------------------------------------------------------------------------
        */

        .student-name {
            position: absolute;

            top: 360px;
            left: 0;
            right: 0;

            text-align: center;

            font-size: 42px;
            font-weight: 700;

            color: #222;
        }

        /*
        |--------------------------------------------------------------------------
        | COURSE TITLE
        |--------------------------------------------------------------------------
        */

        .course-title {
            position: absolute;

            top: 500px;
            left: 0;
            right: 0;

            text-align: center;

            font-size: 28px;
            font-weight: bold;

            color: #222;
        }

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        .completion-date {
            position: absolute;

            top: 590px;

            left: 0;
            right: 0;

            text-align: center;

            font-size: 18px;

            color: #222;
        }
    </style>
</head>

<body>

    <div class="certificate">

        <!-- BACKGROUND -->
        <img
            src="{{ public_path('images/rev.png') }}"
            class="bg">

        <!-- CERTIFICATE ID -->
        <div class="certificate-id">
            CERT-{{ $user->id }}-{{ $course->id }}
        </div>

        <!-- USER NAME -->
        <div class="student-name">
            {{ strtoupper($enrollment->certificate_name) }}
        </div>

        <!-- COURSE -->
        <div class="course-title">
            {{ $course->title }}
        </div>

        <!-- DATE -->
        <div class="completion-date">
            {{ $enrollment->completed_at?->format('d F Y') }}
        </div>

    </div>

</body>

</html>