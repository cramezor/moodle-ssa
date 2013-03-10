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
 * CUL Activity Stream event handlers
 *
 * @package    local
 * @subpackage culactivity_stream
 * @copyright  2013 Amanda Doughty <amanda.doughty.1@city.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */



/**
 * 
 * @param type $eventdata
    * Structure of $eventdata:
    * $eventdata->modulename
    * $eventdata->name       
    * $eventdata->cmid       
    * $eventdata->courseid   
    * $eventdata->userid     
 * @return boolean
 */
function culactivity_stream_mod_created($eventdata) {
    global $CFG, $DB;
    
    // required
    $message = new stdClass();
    $message->component = 'local_culactivity_stream';
    $message->modulename = $eventdata->modulename;
    $message->name = 'mod_created';
    $message->userfrom = $DB->get_record('user', array('id'=>$eventdata->userid));
    $message->subject          = get_string('mod_created', 'local_culactivity_stream', $eventdata->name);
    $message->fullmessage      = get_string('mod_created', 'local_culactivity_stream', $eventdata->name);
    $message->fullmessageformat = FORMAT_PLAIN;
    $message->fullmessagehtml  = get_string('mod_created', 'local_culactivity_stream', $eventdata->name);
    $message->smallmessage     = get_string('mod_created', 'local_culactivity_stream', $eventdata->name);
    
    // optional
    $message->notification = 1;
    $message->course = $DB->get_record('course', array('id'=>$eventdata->courseid));
    $message->contexturl      = "$CFG->wwwroot/$eventdata->modulename/view.php?id=$eventdata->cmid";
    $message->contexturlname  = $message->name;
    
        
    // foreach user that can see this
    $context = $context = context_course::instance($eventdata->courseid);
    $users = get_enrolled_users($context);
    
    foreach ($users as $user) {
        $message->userto = $user;
        message_send($message);        
    }    
    
    return true;
}