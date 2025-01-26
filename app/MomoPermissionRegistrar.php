<?php

namespace App;

use Delgont\Armor\PermissionRegistrar;

/**
 * MomoPermissionRegistrar Class
 *
 * This class extends the PermissionRegistrar to manage and register permissions
 * related to MTN MoMo (Mobile Money) operations within the application.
 *
 */
class MomoPermissionRegistrar extends PermissionRegistrar
{
    /**
     * The group name for MTN MoMo-related permissions.
     *
     * @var string
     */
    protected $group = 'MTN Momo';

    const CAN_VIEW_MOMO_REQUESTS_TO_PAY = 'can_view_momo_requests_to_pay';

    /**
     * Returns a list of permission descriptions for this group.
     *
     * Each permission constant is associated with a human-readable description
     * explaining what the permission allows the user to do.
     *
     * @return array The array of permissions and their descriptions.
     */
    public function descriptions() : array
    {
        return [
            self::CAN_VIEW_MOMO_REQUESTS_TO_PAY => 'Allows the user to view MTN MoMo requests to pay.'
        ];
    }
}
