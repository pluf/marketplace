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
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('Marketplace_Shortcuts_SpaManager');
Pluf::loadFunction('Marketplace_Shortcuts_GetSpaOr404ByName');

/**
 * Manages spas
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Marketplace_Views_Spa extends Pluf_Views
{

    /**
     * Get an spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function get($request, $match)
    {
        if (array_key_exists('modelId', $match)) {
            $spa = Pluf_Shortcuts_GetObjectOr404('Marketplace_Spa', $match['modelId']);
        } else {
            $spa = Marketplace_Shortcuts_GetSpaOr404ByName($match['modelName']);
        }
        Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'read');
        return static::prepareSpa($request, $spa);
    }

    /**
     * Creates new instance of spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function create($request, $match)
    {
        // 1- upload & extract
        $spa = new Marketplace_Spa();
        $spa->name = 'name' . rand();
        $spa->create();
        try {
            Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'create');
            return static::prepareSpa($request, $spa);
        } catch (Exception $e) {
            $spa->delete();
            throw $e;
        }
    }

    /**
     * Update an spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function update($request, $match)
    {
        if (array_key_exists('modelId', $match)) {
            $spa = Pluf_Shortcuts_GetObjectOr404('Marketplace_Spa', $match['modelId']);
        } else {
            $spa = Marketplace_Shortcuts_GetSpaOr404ByName($match['modelName']);
        }
        Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'update');
        return static::prepareSpa($request, $spa);
    }

    /**
     * Update by token
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @throws Pluf_HTTP_Error404
     * @return Marketplace_Spa
     */
    public function updateByToken($request, $match)
    {
        $request->REQUEST['token'] = $match['token'];
        $sql = new Pluf_SQL('token=%s', array(
            $match['token']
        ));
        $spa = Pluf::factory(Marketplace_Spa::class)->getOne($sql->gen());
        if (! isset($spa)) {
            throw new Pluf_HTTP_Error404("Object not found (Marketplace_Spa," . $match['token'] . ")");
        }
        Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'update');
        return static::prepareSpa($request, $spa);
    }

    /**
     * Delete an spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function delete($request, $match)
    {
        if (array_key_exists('modelId', $match)) {
            $spa = Pluf_Shortcuts_GetObjectOr404('Marketplace_Spa', $match['modelId']);
        } else {
            $spa = Marketplace_Shortcuts_GetSpaOr404ByName($match['modelName']);
        }
        Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'delete');
        return static::prepareSpa($request, $spa);
    }

    /**
     * If user is owner set feild token as readable esle set it unreadable.
     * @param Pluf_HTTP_Request $request
     * @param Marketplace_Spa $spa
     * @return Marketplace_Spa
     */
    private static function prepareSpa($request, $spa){
        $spa->_a['cols']['token']['readable'] = User_Precondition::isOwner($request);
        return $spa;
    }
    
    /**
     * Download an spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function download($request, $match)
    {
        if (array_key_exists('modelId', $match)) {
            $spa = Pluf_Shortcuts_GetObjectOr404('Marketplace_Spa', $match['modelId']);
        } else {
            $spa = Marketplace_Shortcuts_GetSpaOr404ByName($match['modelName']);
        }
        Marketplace_Shortcuts_SpaManager($spa)->apply($spa, 'download');
        return new Pluf_HTTP_Response_File($spa->file, 'application/zip');
    }
}
