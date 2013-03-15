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
 * Main class for rendering the culactivity_stream block
 */
class block_culactivity_stream_renderer extends plugin_renderer_base {

    /**
     * Function for rendering the notification wrapper
     * 
     * @global stdClass $USER
     * @param array $notifications array of notification objects
     * @return string $output html
     */ 
    public function culactivity_stream($notifications) {
        global $USER;
        $output = '';        
        // Generate an id and the required JS call to make this a nice widget
        $id = html_writer::random_id('culactivity_stream');
        // Start content generation
        $output = html_writer::start_tag('div', array(
            'id'=>$id,
            'class'=>'culactivity_stream'));
        $output .= html_writer::start_tag('ul');
        $output .= $this->culactivity_stream_items ($notifications);
        $output .= html_writer::end_tag('ul');
        $output .= html_writer::end_tag('div');       

        return $output;
    }

    /**
     * Function for appending reload button and ajax loading gif to title
     * 
     * @return string $output html
     */
    public function culactivity_stream_title () {
        $output = '';
        $output .= get_string('activitystream', 'block_culactivity_stream');
        // Reload button
        $reloadimg = $this->output->pix_icon('i/reload', '', 'moodle',
                array('class'=>'iconsmall'));
        $reloadurl = new moodle_url('/my/index.php');
        $reloadattr = array('id'=>'block_culactivity_stream_reload');
        $output .= html_writer::link($reloadurl, $reloadimg, $reloadattr);
        // Loading gif
        $ajaximg = $this->output->pix_icon('i/ajaxloader', '');
        $output .= html_writer::tag('span', $ajaximg, array('id'=>'loadinggif'));
        
        return $output;
    }

    /**
     * Function to render the individual notification list items
     * 
     * @param array $notifications array of notification objects
     * @return string $output html
     */
    public function culactivity_stream_items ($notifications) {
        $output = '';
        $times = array();

        foreach ($notifications as $notification){
            $class = $notification->new? 'new' : 'old';
            $output .= html_writer::start_tag('li', array('id'=>'m_'.$notification->id,
                                                            'class'=>$class));
            $output .= html_writer::start_tag('div', array('class'=>'coursepicture'));

            if (is_string($notification->img)) {
                $icon = "<img src=\"{$notification->img}\" />";
                $output .= html_writer::link($notification->contexturl, $icon);
            } else {
                $output .= $this->output->user_picture($notification->img,
                        array('size'=>35, 'class'=>'personpicture'));
            }

            $output .= html_writer::end_tag('div'); // .coursepicture
            $output .= html_writer::start_tag('div', array('class'=>'text'));
            $output .= html_writer::start_tag('span');
            $output .= $notification->smallmessage . ' ';
            $output .= html_writer::end_tag('span');
            $output .= html_writer::end_tag('div'); // .text
            $output .= html_writer::start_tag('div', array('class'=>'activityicon'));
            $output .= $this->output->pix_icon($notification->icon, 'activity icon',
            $notification->component, array('class'=>'iconsmall',                                            'title'=>''));
            $output .= html_writer::end_tag('div'); // .activityicon
            $output .= html_writer::start_tag('div', array('class'=>'contexturls')); // TODO

            if ($notification->notification) {
                $output .= html_writer::link($notification->contexturl, $notification->contexturlname);
                $output .= ' | ';
                $removeurl = new moodle_url('/blocks/culactivity_stream/remove.php', 
                        array('remove'=>$notification->id, 'sesskey' => sesskey()));
                $output .= html_writer::link($removeurl, get_string('remove'), 
                        array('class'=>'removelink'));
            }

            $output .= html_writer::end_tag('div'); // .contexturls
            $output .= html_writer::start_tag('div', array('class'=>'timesince'));
            $output .= html_writer::start_tag('span');
            $output .= 'about ' . $notification->time . ' ago'; // TODO lang string
            $output .= html_writer::end_tag('span');
            $output .= html_writer::end_tag('div'); // .timesince
            $output .= html_writer::end_tag('li');
            $output .= '<hr/>';
        }

        return $output;
    }

    /**
     * Function to create the pagination. This will only show up for non-js
     * enabled browsers.
     * 
     * @param int $prev the previous page number
     * @param int $next the next page number
     * @return string $output html
     */
    function culactivity_stream_pagination($prev=false, $next=false) {
        $output = '';

        if ($prev || $next) {
            $output .= html_writer::start_tag('div', array('class'=>'pages'));

            if ($prev) {
                $prevurl = new moodle_url('/my/index.php', array('block_culactivity_stream_page' => $prev));
                $prevtext = get_string('newer', 'block_culactivity_stream');
                $output .= html_writer::link($prevurl, $prevtext);
            }

            if ($prev && $next) {
                $output .= '&nbsp;|&nbsp;';
            }

            if ($next) {
                $nexturl = new moodle_url('/my/index.php', array('block_culactivity_stream_page' => $next));
                $nexttext = get_string('older', 'block_culactivity_stream');
                $output .= html_writer::link($nexturl, $nexttext);
            }

            $output .= html_writer::end_tag('div'); // .pages
        }

        return $output;

    }

}