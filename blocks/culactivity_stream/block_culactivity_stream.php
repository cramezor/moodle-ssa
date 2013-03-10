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
 * CUL Activity Stream Block
 *
 * @package    block
 * @subpackage culactivity_stream
 * @copyright  2013 Amanda Doughty <amanda.doughty.1@city.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */

require_once('locallib.php');

/**
 * 
 */
class block_culactivity_stream extends block_base {
    
    /**
     * 
     */
    function init() {
        $this->title = get_string('pluginname', 'block_culactivity_stream');
    }

    /**
     * 
     * @return type
     */
    function get_content() {
        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $notifications = block_culactivity_stream_get_notifications();
        $renderer = $this->page->get_renderer('block_culactivity_stream');
        $this->content->text = $renderer->culactivity_stream($notifications);
        return $this->content;
    }

    /**
     * 
     * @return type
     */
    public function applicable_formats() {
        return array('my-index' => true);
    }
}

