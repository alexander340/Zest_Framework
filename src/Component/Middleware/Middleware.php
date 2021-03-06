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
 * @since 1.9.7
 * @deprecated 3.0.0
 *
 * @license MIT
 */

namespace Zest\Component\Middleware;

class Middleware
{
    final public function run($type, $middleware, $params, $namespace)
    {
        if (!empty($type) && !empty($middleware)) {
            if (!empty($namespace)) {
                $namespace = $namespace;
            } else {
                throw new \Exception('Component middleware not found', 404);
            }
            $middleware = $middleware;
            $middleware = $namespace.$middleware;
            if (class_exists($middleware)) {
                $middleware_obj = new $middleware();
                if ($type === 'before') {
                    if (method_exists($middleware_obj, 'before')) {
                        $middleware_obj->before($params);
                    } else {
                        throw new \Exception('Middleware method not exists', 404);
                    }
                }
                if ($type === 'after') {
                    if (method_exists($middleware_obj, 'after')) {
                        $middleware_obj->after($params);
                    } else {
                        throw new \Exception('Middleware method not exists', 404);
                    }
                }
            } else {
                throw new \Exception("Middleware {$middleware} class not found", 404);
            }
        } else {
            throw new \Exception('Error unknown middleware', 404);
        }
    }
}
