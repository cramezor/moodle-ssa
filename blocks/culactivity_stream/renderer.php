<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * CUL Activity Stream renderer
 *
 * @package    block
 * @subpackage culactivity_stream
 * @copyright  2013 Amanda Doughty <amanda.doughty.1@city.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */

defined('MOODLE_INTERNAL') || die;

/**
 * 
 */
class block_culactivity_stream_renderer extends plugin_renderer_base {

    /**
     * 
     * @global type $USER
     * @param type $notifications
     * @return type
     */ 
    public function culactivity_stream($notifications) {
        global $USER;
        $class = '';
        $times = array();

        // Generate an id and the required JS call to make this a nice widget
        $id = html_writer::random_id('culactivity_stream');
        // Start content generation
        $output = html_writer::start_tag('div', array(
            'id'=>$id,
            'class'=>'culactivity_stream'));
        $output .= html_writer::start_tag('ul');

        foreach ($notifications as $notification){
            $class .= $notification->new? 'new' : 'old';
            $output .= html_writer::start_tag('li', array('class'=>$class));
            $output .= html_writer::start_tag('div', array('class'=>'coursepicture'));
            
            if (is_string($notification->img)) {
                $icon = "<img src=\"{$notification->img}\" />";
                $output .= html_writer::link($notification->contexturl, $icon);
            } else {
                $output .= $this->output->user_picture($notification->img, 
                        array('size'=>40, 'class'=>'personpicture'));
            }
            
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'text'));
            $output .= html_writer::start_tag('p');
            $output .= $notification->smallmessage . ' ';
            
            if ($notification->notification) {
                $output .= html_writer::link($notification->contexturl, $notification->contexturlname);
            }

            $output .= html_writer::end_tag('p');
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'activityicon'));
            $output .= $this->output->pix_icon($notification->icon, $notification->subject,
            $notification->component, array('class'=>'iconsmall')); 
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'timesince'));
            $output .= html_writer::start_tag('p', array('class'=>'timesince'));
            $output .= 'about ' . $notification->time . ' ago'; // TODO lang string
            $output .= html_writer::end_tag('p');
            $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('li');
        }

        $output .= html_writer::end_tag('ul');
        $output .= html_writer::end_tag('div');

        return $output;
    }
}