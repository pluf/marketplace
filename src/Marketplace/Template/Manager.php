<?php

/**
 * Manages lifecycle of an Template
 * 
 * Each Template lifecycle handles with a Template_Manager. This is the genera
 * definistion of template manager.
 * 
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *
 */
interface Marketplace_Template_Manager
{

    /**
     * Creates a filter
     *
     * @param Pluf_HTTP_Request $request
     * @return Pluf_SQL
     */
    public function filter($request);

    /**
     * Apply action on object
     *
     * Each order must follow CRUD actions in life cycle. Here is default action
     * list:
     *
     * <ul>
     * <li>create</li>
     * <li>read</li>
     * <li>update</li>
     * <li>delete</li>
     * </ul>
     *
     * @param Marketplace_Spa $order
     * @param String $action
     * @return Marketplace_Spa
     */
    public function apply($spa, $action);

    /**
     * Returns next possible states
     *
     * @param Marketplace_Spa $order
     * @return array of states
     */
    public function states($spa);
}