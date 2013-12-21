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
 * My Target Block.
 *
 * @package   block_my_target
 * @author    Graham Bowman <gbowman85@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("{$CFG->libdir}/gradelib.php");
require_once($CFG->dirroot . '/grade/report/lib.php');
require_once $CFG->dirroot.'/grade/report/overview/lib.php';
require_once $CFG->dirroot.'/grade/lib.php';

class block_my_target extends block_base {
	public function init() {
		$this->title = get_string('my_target', 'block_my_target');
	}
	
	public function get_content() {
		global $DB, $USER, $PAGE;
 
		$this->content         =  new stdClass;
		
		// Get the current course id
		$context = $PAGE->context;
		$coursecontext = $context->get_course_context();
		$courseid = $coursecontext->instanceid;
		
			
		// Get target grade_item
		$grade_item = grade_item::fetch(array('courseid'=>$courseid,'itemname'=>'Target'));
		
		// Check if the user is a teacher
		if (has_capability('block/my_target:addinstance', $this->context)) {
			// Check if  a manual grade item has been created in this course
			if (!$grade_item && has_capability('block/my_target:addinstance', $this->context)) {
				$itemUrl = html_writer::link(new moodle_url('/grade/edit/tree/item.php', array('courseid'=>$courseid)), 'here');
				$this->content->text = get_string('no_target', 'block_my_target', $itemUrl);
				return $this->content;
			} else {           
				$url = html_writer::link(new moodle_url('/grade/report/grader/index.php', array('id'=>$courseid)), 'grades');
				$this->content->text = get_string('instructions', 'block_my_target', $url);
				return $this->content;
			}
        }

		// Get the stored grade
		$params = array('userid' => $USER->id, 'itemid' => $grade_item->id);
		$grade = $DB->get_record('grade_grades', $params);	
		
		// Check if  a target grade has been set
		if(!$grade) {
			return false;
		}
		
		// Format the target grade
		$targetgrade = grade_format_gradevalue($grade->finalgrade, $grade_item, true);
		

		
		// Return the content
		$this->content->text='<span class="target">'.$targetgrade.'</span>';
		return $this->content;
		
	}

	public function instance_allow_multiple() {
		return false;
	}

}

?>
