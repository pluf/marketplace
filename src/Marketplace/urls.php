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
    array(
        'regex' => '#^/spa/find$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'precond' => array(),
        'params' => array(
            'model' => 'Marketplace_Spa',
            'listFilters' => array(
                'id',
                'title',
                'symbol'
            ),
            'listDisplay' => array(
                'id' => 'spa id',
                'title' => 'title',
                'creation_dtime' => 'creation time'
            ),
            '$searchFields' => array(
                'name',
                'title',
                'description',
                'homepage'
            ),
            'sortFields' => array(
                'id',
                'name',
                'title',
                'homepage',
                'license',
                'version',
                'creation_dtime'
            ),
            'sortOrder' => array(
                'creation_dtime',
                'DESC'
            )
        )
    ),
    array(
        'regex' => '#^/spa/(?P<modelId>\d+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'get',
        'http-method' => 'GET',
    ),
    array(
        'regex' => '#^/spa/(?P<modelId>\d+)/download$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'download',
        'http-method' => 'GET',
    ),
    array(
        'regex' => '#^/spa/new$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'Pluf_Precondition::ownerRequired'
        )
    ),
    array(
        'regex' => '#^/spa/token-(?P<token>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'updateByToken',
        'http-method' => 'POST',
    ),
    array(
        'regex' => '#^/spa/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'update',
        'http-method' => 'POST',
        'precond' => array(
            'Pluf_Precondition::ownerRequired'
        )
    ),
    array(
        'regex' => '#^/spa/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'delete',
        'http-method' => 'DELETE',
        'precond' => array(
            'Pluf_Precondition::ownerRequired'
        )
    ),
    array(
        'regex' => '#^/spa/(?P<modelName>.+)/download$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'download',
        'http-method' => 'GET',
    ),
    array(
        'regex' => '#^/spa/(?P<modelName>.+)$#',
        'model' => 'Marketplace_Views_Spa',
        'method' => 'get',
        'http-method' => 'GET',
    ),
);
