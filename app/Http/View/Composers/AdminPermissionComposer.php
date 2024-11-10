<?php

namespace App\Http\View\Composers;


use Illuminate\View\View;

use App\AccountingPermissionRegistrar;


class AdminPermissionComposer
{
    public function compose(View $view)
    {
        $view->with([
            'accountingPermissions' => AccountingPermissionRegistrar::class
        ]);
    }
}
