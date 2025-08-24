<?php

namespace App\Mail;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEnrollment extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly Course $course)
    {
    }

    public function build(): NewEnrollment
    {
        return $this->subject('New Student Enrolled')
            ->view('emails.new_enrollment')
            ->with(['course' => $this->course]);
    }
}
