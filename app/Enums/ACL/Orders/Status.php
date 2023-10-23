<?php

namespace App\Enums\ACL\Orders;

enum Status: string
{
    case PENDING = 'Pending';
    case PROCESSING = 'Processing';
    case SHIPPED = 'Shipped';
    case DELIVERED = 'Delivered';
    case CANCELED = 'Canceled';
    case ON_HOLD = 'On Hold';
    case REFUNDED = 'Refunded';
    case COMPLETED = 'Completed';
}
