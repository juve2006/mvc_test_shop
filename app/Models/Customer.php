<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

/**
 * Class Customer
 */
class Customer extends Model
{
    /**
     * Customer constructor.
     */
    function __construct()
    {
        $this->tableName = 'customer';
        $this->idColumn = 'customer_id';
    }
}