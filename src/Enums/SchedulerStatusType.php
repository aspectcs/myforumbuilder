<?php


namespace Aspectcs\MyForumBuilder\Enums;

use Illuminate\Validation\Rules\Enum;

final class SchedulerStatusType extends Enum{
    const PENDING = 'PENDING';
    const UNDER_PROCESS = 'UNDER PROCESS';
    const ERROR = 'ERROR';
    const SUCCESS = 'SUCCESS';
}

