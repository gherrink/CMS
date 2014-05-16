<?php

/*
 * Copyright (C) 2014 Maurice Busch <busch.maurice@gmx.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * An Interface for the CRUDControler with this interface you can 
 * tell the CRUDController to check if the $model is readable.
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
interface CRUDReadCheck
{
    /**
     * Check if the $model is readable.
     * @param CActiveRecord $model
     * @param boolean $editable
     * @throws CHttpException if the Model can't be readed
     */
    public function checkReadable(CActiveRecord $model, $editable);
}
