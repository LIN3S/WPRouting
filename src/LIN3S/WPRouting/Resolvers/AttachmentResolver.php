<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

/**
 * Attachment routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class AttachmentResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [Resolver::TYPE_ATTACHMENT, Resolver::TYPE_SINGLE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $attachment = get_queried_object();

        if ($attachment) {
            if (false !== strpos($attachment->post_mime_type, '/')) {
                list($type, $subtype) = explode('/', $attachment->post_mime_type);
            } else {
                list($type, $subtype) = [$attachment->post_mime_type, ''];
            }
            if (!empty($subtype)) {
                $controllers = $routes->match($type, ['subtype' => $subtype]);
                if (count($controllers) > 0) {
                    return $controllers[0];
                }
                $controllers = $routes->match($subtype);
                if (count($controllers) > 0) {
                    return $controllers[0];
                }
            }
            $controllers = $routes->match($type);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(Resolver::TYPE_ATTACHMENT);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
