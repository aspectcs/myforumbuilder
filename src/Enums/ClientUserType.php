<?php


namespace Aspectcs\MyForumBuilder\Enums;


use Illuminate\Validation\Rules\Enum;

final class ClientUserType extends Enum{
    const FAKE = 'FAKE';
    const REAL = 'REAL';
}
