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
 * Description of QuestionController
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class QuestionController extends Controller
{

    /**
     * Gives a JSON array for a Question
     * @param String $question
     */
    public function actionQuestion($head, $question)
    {
        $content['header'] = MsgPicker::msg()->getMessage($head);
        $content['body'] = MsgPicker::msg()->getMessage($question);
        $content['footer'] = $this->createButtonFooter();

        echo json_encode($content);
    }

    protected function createButtonFooter()
    {
        if (in_array('buttons', $_POST))
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_NOBUTTONS));

        $html = '';
        $buttons = $_POST['buttons'];

        while (($buttonaction = current($buttons)) !== FALSE)
        {
            $html .= BsHtml::button(MsgPicker::msg()->getMessage(key($buttons)), array(
                        'onclick' => $buttonaction,
            ));
            next($buttons);
        }

        return $html;
    }

}
