<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

class Logout
{
    /**
     * Logout the user.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function __construct()
    {
        $user = new User();
        $user->logout();
    }
}
