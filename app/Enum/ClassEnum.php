<?php

namespace App\Enum;

enum ClassEnum: string
{
    case Lecture = 'lecture';
    case Tutorial = 'tutorial';
    case Practical = 'practical';
    case Workshop = 'workshop';
    case Lab = 'lab';
}
