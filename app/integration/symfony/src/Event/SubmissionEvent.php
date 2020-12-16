<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Submission;

class SubmissionEvent
{
    public const SAVED = 'app.submission.saved';
    private Submission $submission;

    /**
     * SubmissionEvent constructor.
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function getSubmission(): Submission
    {
        return $this->submission;
    }
}
