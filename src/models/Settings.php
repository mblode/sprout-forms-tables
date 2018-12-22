<?php

namespace mblode\sproutformstables\models;

use craft\base\Model;

class Settings extends Model
{
    // Public Properties
    // =========================================================================
    /**
     * JSON Decode the table value that is used on the notification email. (Only turn on with a custom notification email template).
     *
     * @var boolean
     */
    public $decodeValue = true;
}
