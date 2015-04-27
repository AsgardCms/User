<?php

View::composer('partials.sidebar-nav', 'Modules\User\Composers\SidebarViewComposer');
View::composer([
        'user::admin.partials.permissions',
        'user::admin.partials.permissions-create',
    ], 'Modules\User\Composers\PermissionsViewComposer');

View::composer(['partials.sidebar-nav', 'partials.top-nav', 'layouts.master', 'partials.*'], 'Modules\User\Composers\UsernameViewComposer');
