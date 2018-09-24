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

/**
 * An SPA data model in market place
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *        
 */
class Marketplace_Spa extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'marketplace_spas';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'blank' => true
            ),
            'name' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'unique' => true,
                'is_null' => false,
                'size' => 50,
                'readable' => true,
                'editable' => false
            ),
            'version' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 100,
                'readable' => true,
                'editable' => false
            ),
            'title' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 50,
                'readable' => true,
                'editable' => true
            ),
            'token' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 50,
                'readable' => false,
                'editable' => false
            ),
            'state' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 50,
                'readable' => true,
                'editable' => false
            ),
            'license' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 250,
                'readable' => true,
                'editable' => false
            ),
            'description' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 250,
                'readable' => false,
                'editable' => false
            ),
            'file' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 100,
                'verbose' => 'SPA installation path',
                'readable' => false,
                'editable' => false
            ),
            'homepage' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 100
            ),
            'creation_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => true,
                'readable' => true,
                'editable' => false
            ),
            'modif_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => true,
                'readable' => true,
                'editable' => false
            )
        );

        $this->_a['views'] = array();
    }

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::preSave()
     */
    function preSave($create = false)
    {
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::preDelete()
     */
    function preDelete()
    {
        // @unlink(Pluf::f('upload_issue_path').'/'.$this->attachment);
        // TODO: hadi, 1395: قبل از حذف spa فایل‌های مربوط به این spa حذف شود
        // TODO: maso, 1395: از signal-slot استفاده شود و یک signal ارسال شود تا
        // سایرین که به
        // این spa وابسته هستند داده‌های مربوطه‌شان را حذف کنند.
        // remove related file
        $filename = $this->file;
        if (is_file($filename)) {
            unlink($filename);
        }
    }
}