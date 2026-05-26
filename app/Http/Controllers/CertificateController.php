<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CertificateController extends Controller
{
    public function show(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->first();

        if (!$enrollment) {
            abort(403, 'Course not completed yet.');
        }

        return view(
            'livewire.pages.certificate.certificate-show',
            compact('course', 'user', 'enrollment')
        );
    }

    public function download(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->first();

        if (!$enrollment) {
            abort(403, 'Course not completed yet.');
        }

        $pdf = Pdf::loadView('livewire.pages.certificate.pdf', [
            'course' => $course,
            'user' => $user,
            'enrollment' => $enrollment,
        ]);

        return $pdf->download(
            'certificate-' . $course->id . '.pdf'
        );
    }
}
