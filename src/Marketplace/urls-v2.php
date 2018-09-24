<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
return array(
    /*
     * SPA
     */
    array( // Create
        'regex' => '#^/spas$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/spas$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'precond' => array(),
        'params' => array(
            'model' => 'Marketplace_Spa',
            'sortOrder' => array(
                'creation_dtime',
                'DESC'
            )
        )
    ),
    array( // Read
        'regex' => '#^/spas/(?P<modelId>\d+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'get',
        'http-method' => 'GET'
    ),
    array( // Read (file)
        'regex' => '#^/spas/(?P<modelId>\d+)/file$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'download',
        'http-method' => 'GET'
    ),
    array( // Update (by token)
        'regex' => '#^/spas/token-(?P<token>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'updateByToken',
        'http-method' => 'POST'
    ),
    array( // Update (by id)
        'regex' => '#^/spas/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'update',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/spas/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'delete',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    /*
     * Template
     */
    array(
        'regex' => '#^/templates/(?P<modelName>.+)/file$#',
        'model' => 'Marketplace_Views_Template',
        'method' => 'download',
        'http-method' => 'GET'
    ),
    array(
        'regex' => '#^/template/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Template',
        'method' => 'get',
        'http-method' => 'GET'
    )
);
