<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class FeesPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'Fees Manager';

    const CAN_MANAGE_FEES = 'can_manage_fees';
    const CAN_VIEW_EXPECTED_FEES_SUMMARY = 'can_view_expected_fees_summary';
    const CAN_VIEW_PREVIOUS_BALANCE_SUMMARY = 'can_view_previous_balance_summary';
    const CAN_VIEW_COLLECTED_FEES_SUMMARY = 'can_view_collected_fees_summary';
    const CAN_VIEW_FEES_PAYMENTS = 'can_view_fees_payments';
    const CAN_SEARCH_FEES_PAYMENTS = 'can_search_fees_payments';
    const CAN_VIEW_FEES_CARRIED_FORWARD = 'can_view_fees_carried_forward';
    const CAN_UPDATE_FEES_CARRIED_FORWARD = 'can_update_fees_carried_forward';
    const CAN_IMPORT_FEES_PAYMENTS = 'can_import_fees_payments';

    const CAN_VIEW_FEES_PAYMENT_TRANSACTIONS = 'can_view_fees_payments_transactions';

    const CAN_VIEW_FEES_PARTICULARS = 'can_views_fees_breakdown';
    const CAN_ADD_FEES_BREAKDOWN = 'can_add_fees_breakdown';

    const CAN_ADD_FEES_DISCOUNTS = 'can_add_fees_discounts';
    const CAN_VIEW_FEES_DISCOUNTS = 'can_view_fees_discounts';
    const CAN_DELETE_FEES_DISCOUNTS = 'can_delete_fees_discounts';
    const CAN_UPDATE_FEES_DISCOUNTS = 'can_update_fees_discounts';

    const CAN_RECORD_FEES_PAYMENT = 'can_record_fees_payment';



    public function descriptions()
    {
        return [
         self::CAN_MANAGE_FEES => 'User will be able to access fees manager',
         self::CAN_VIEW_FEES_PARTICULARS => 'User will be able to view fees particulars on fees breakdown page',
        ];
    }
    
}