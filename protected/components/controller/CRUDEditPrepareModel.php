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
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
interface CRUDEditPrepareModel
{
    /**
     * prepares the $model for edeting, for example if you want to add
     * some default values.
     * @param CActiveRecord $model
     * @retrun CActiveRecord
     */
    public function prepareEditModel(CActiveRecord $model);
}
