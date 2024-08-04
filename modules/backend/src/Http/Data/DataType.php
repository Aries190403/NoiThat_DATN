<?php
namespace Modules\Backend\Http\Data;

class DataType
{
    const DELETED_DATA_TYPE = 'deleted';
    const NORMAL_DATA_TYPE = 'normal';
    const LOCKED_DATA_TYPE = 'locked';
    const ACTIVE_DATA_TYPE = 'active';
    const INVOICE_UNPAID_DATA_TYPE = 'Unpaid';
    const INVOICE_PAID_DATA_TYPE = 'Paid';
    const INVOICE_PENDING_DATA_TYPE = 'Pending';
    const INVOICE_COMFIRMED_DATA_TYPE = 'Confirmed';
    const INVOICE_SHIPPING_DATA_TYPE = 'Shipping';
    const INVOICE_COMPLETED_DATA_TYPE = 'Completed';
    const INVOICE_FAILED_DATA_TYPE = 'Failed';
    const INVOICE_REFUNDING_DATA_TYPE = 'Refunding';
    const INVOICE_REFUNED_DATA_TYPE = 'Refuned';
    const INVOICE_RETURNDING_DATA_TYPE = 'Returnding';
    const INVOICE_RETURNED_DATA_TYPE = 'Returned';
}

