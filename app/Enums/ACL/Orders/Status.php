<?php

namespace App\Enums\ACL\Orders;

/**
 * Documentation
 * 1. Pending --> Represnts that an order has been created by a customer but has not yet been processed or approved.
 * 2. Processiong --> Currently being processed by the system. This means that the order is getting
 *                    prepared to be shipped.
 * 3. Shipped --> Order has been processed and is ready for delivery. Order left from the warehouse.
 * 4. Delivered --> Order has successfully reached the customer's delivery address. Customer received the order.
 * 5. Canceled --> Order is canceled for a reason.
 * 6. On Hold --> Some orders might need to be temporarily paused or held for a specific reasons.
 * 7. Refunded --> Indicates that a refund has been issued for an order.
 * 8. Completed --> The order has gone through all processing stages. Sometimes after customer get the order
 *                  are stages like feedback for the order etc. So after all the stages, this is the final stage.
 */
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
