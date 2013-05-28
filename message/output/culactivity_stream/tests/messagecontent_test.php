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
 * PHPUnit message content tests
 *
 * @package    mod_forum
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * PHPUnit data generator testcase
 *
 * @package    mod_forum
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_culactivity_stream_testcase extends advanced_testcase {

     /**
     * Tests set up
     */
    protected function setUp() {
        global $CFG, $DB;        
        
        require_once($CFG->dirroot . '/message/lib.php');

        $this->resetAfterTest();
        $this->preventResetByRollback();
        $this->setAdminUser();

        // Turn off all message processors (apart from culactivity_stream)
        $messageprocessors = get_message_processors();
        // Leave this enabled as it the one we need to test
        unset($messageprocessors['culactivity_stream']);

        foreach($messageprocessors as $messageprocessor) {
            $messageprocessor->enabled = 0;
            $DB->update_record('message_processors', $messageprocessor);
        }
    }


	public function test_enrolmessage() {
        global $DB, $CFG;
         // Set up code
        $course1 = $this->getDataGenerator()->create_course();
        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $teacherrole = $DB->get_record('role', array('shortname'=>'teacher'));
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();        
        $manual = enrol_get_plugin('manual');
        $manual->set_config('expirynotifylast', time() - 60*60*24);
        $manual->set_config('expirynotifyhour', 0);
        $instance1 = $DB->get_record('enrol', array('courseid'=>$course1->id, 'enrol'=>'manual'), '*', MUST_EXIST);
        $instance1->expirythreshold = 60*60*24;
        $instance1->expirynotify    = 1;
        $instance1->notifyall       = 1;
        $DB->update_record('enrol', $instance1);
        $manual->enrol_user($instance1, $user1->id, $teacherrole->id);
        $timeend = time() + 60*60*24 - 60*3;
        $manual->enrol_user($instance1, $user2->id, $studentrole->id, 0, $timeend);
        
        //... code that is sending messages
        // 1. Manual enrolment with near expiry date
        $manual->send_expiry_notifications(true);
        // Tests
        // Get the records from the table populated by the culactivity_stream
        // message output plugin (NB cannot use core tables as these are not
        // populated with the course info we need to test for)
        $messages = $DB->get_records('message_culactivity_stream');
        $this->assertEquals(2, count($messages));
        // Test that the correct course id is in the record
        $this->assertEquals($course1->id, $messages[1]->courseid);
        $eventdata = json_decode($messages[1]->eventdata);
        // Get the updated course object
        $course = $DB->get_record('course', array('id' => $course1->id));
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
        // Test that the correct course id is in the record
        $this->assertEquals($course1->id, $messages[2]->courseid);
        $eventdata = json_decode($messages[2]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
    }


    public function test_forummessage() {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/mod/forum/lib.php');
        // Set up code
        $course1 = $this->getDataGenerator()->create_course();
        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $teacherrole = $DB->get_record('role', array('shortname'=>'teacher'));
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $manual = enrol_get_plugin('manual');
        $instance1 = $DB->get_record('enrol', array('courseid'=>$course1->id, 'enrol'=>'manual'), '*', MUST_EXIST);
        $manual->enrol_user($instance1, $user1->id, $teacherrole->id);
        $manual->enrol_user($instance1, $user2->id, $studentrole->id);

        // Create forum post and run forum cron job to send message
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_forum');
        $forum = $generator->create_instance(array('course'=>$course1->id));
        forum_subscribe($user2->id, $forum->id);

        $discussion = new stdClass();
        $discussion->course        = $forum->course;
        $discussion->forum         = $forum->id;
        $discussion->name          = $forum->name;
        $discussion->assessed      = $forum->assessed;
        $discussion->message       = $forum->intro;
        $discussion->messageformat = $forum->introformat;
        $discussion->messagetrust  = trusttext_trusted(context_course::instance($forum->course));
        $discussion->mailnow       = true;
        $discussion->groupid       = -1;

        $message = '';
        $discussion->id = forum_add_discussion($discussion, null, $message, $user1->id);
        // Get the updated course object
        $course = $DB->get_record('course', array('id' => $forum->course));        
        // The cron sends subscribed users messages about new posts
        forum_cron();

        // Tests
        // Get the records from the table populated by the culactivity_stream
        // message output plugin (NB cannot use core tables as these are not
        // populated with the course info we need to test for)
        $messages = $DB->get_records('message_culactivity_stream');
        $this->assertEquals(1, count($messages));
        // Test that the correct course id is in the record
        $this->assertEquals($course1->id, $messages[1]->courseid);
        $eventdata = json_decode($messages[1]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
    }


    public function test_submitassignmessage() {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/mod/assign/lib.php');
        // Set up code
        $course = $this->getDataGenerator()->create_course();
        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $teacherrole = $DB->get_record('role', array('shortname'=>'teacher'));
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $manual = enrol_get_plugin('manual');
        $instance = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'manual'), '*', MUST_EXIST);
        $manual->enrol_user($instance, $user1->id, $teacherrole->id);
        $manual->enrol_user($instance, $user2->id, $studentrole->id);

        // Create the assignment module.
        $coursemodule = self::getDataGenerator()->create_module('assign', array(
            'course' => $course->id,
            'name' => 'lightwork assignment'
        ));
        
        // Get the updated course object
        $course = $DB->get_record('course', array('id' => $coursemodule->course));
        
        $userfrom = $userto = $user2;
        $messagetype = 'submissionreceipt'; 
        $eventtype = 'assign_notification';
        $updatetime = time();     
        $context = context_module::instance($coursemodule->id);
        $modulename = 'assign';
        $assignmentname = $coursemodule->name;
        $blindmarking = false;
        $uniqueidforuser = 0; // only required for blind marking        
        
        assign::send_assignment_notification($userfrom, $userto, $messagetype, $eventtype,
                                                        $updatetime, $coursemodule, $context, $course,
                                                        $modulename, $assignmentname, $blindmarking,
                                                        $uniqueidforuser);

        // Tests
        // Get the records from the table populated by the culactivity_stream
        // message output plugin (NB cannot use core tables as these are not
        // populated with the course info we need to test for)
        $messages = $DB->get_records('message_culactivity_stream');
        $this->assertEquals(1, count($messages));
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[1]->courseid);
        $eventdata = json_decode($messages[1]->eventdata);
        
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
    }

    public function test_feedbackmessage() {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/mod/feedback/lib.php');
        require_once("$CFG->dirroot/course/lib.php");
        // Set up code
        $course = $this->getDataGenerator()->create_course();
        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $teacherrole = $DB->get_record('role', array('shortname'=>'teacher'));
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $manual = enrol_get_plugin('manual');
        $instance1 = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'manual'), '*', MUST_EXIST);
        $manual->enrol_user($instance1, $user1->id, $teacherrole->id);
        $manual->enrol_user($instance1, $user2->id, $studentrole->id);

        // There is no generator for feedback mod  so we have to build it
        $feedback = new stdClass();
        $feedback->course = $course->id;
        $feedback->name = 'positive feedback';
        $feedback->intro = '<p>positive feedback</p>';
        $feedback->introformat = 1;
        $feedback->anonymous = 1;
        $feedback->email_notification = 1;
        $feedback->multiple_submit = 1;
        $feedback->autonumbering = 1;
        $feedback->site_after_submit = '';
        $feedback->page_after_submit = '<p>boo</p>';
        $feedback->page_after_submitformat = 1; 
        $feedback->publish_stats = 0;
        $feedback->timeopen = 0;
        $feedback->timeclose = 0;
        $feedback->timemodified = time();
        $feedback->completionsubmit = 0;
        
        $feedback->id = $DB->insert_record('feedback', $feedback);
        
        $cm = new stdClass();
        $cm->course             = $course->id;
        $cm->module             = $DB->get_field('modules', 'id', array('name'=>'feedback'));
        $cm->instance           = 0;
        $cm->section            = 1;
        $cm->idnumber           = 0;
        $cm->added              = time();
        
        $cm->id = $DB->insert_record('course_modules', $cm);

        course_add_cm_to_section($course->id, $cm->id, $cm->section);
        
        
        // Get the updated course object
        $course = $DB->get_record('course', array('id' => $feedback->course));
        
        feedback_send_email($cm, $feedback, $course, $user2->id);
        feedback_send_email_anonym($cm, $feedback, $course);


        // Tests
        // Get the records from the table populated by the culactivity_stream
        // message output plugin (NB cannot use core tables as these are not
        // populated with the course info we need to test for)
        $messages = $DB->get_records('message_culactivity_stream');
        $this->assertEquals(2, count($messages));
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[1]->courseid);
        $eventdata = json_decode($messages[1]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[2]->courseid);
        $eventdata = json_decode($messages[2]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
    }


    public function test_quizmessage() {
        global $DB, $CFG;
         // Set up code
        $course = $this->getDataGenerator()->create_course();
        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $teacherrole = $DB->get_record('role', array('shortname'=>'teacher'));
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();        
        $manual = enrol_get_plugin('manual');
        $instance = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'manual'), '*', MUST_EXIST);
        $manual->enrol_user($instance, $user1->id, $teacherrole->id);
        $manual->enrol_user($instance, $user2->id, $studentrole->id);
                
        // Create the quiz and retrieve the required parameters:
        // $course, $quiz, $attempt, $context, $cm
        $uniqueid = 0;
        $usertimes = array();
        $quiz_generator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');
        $quiz = $quiz_generator->create_instance(array('course'=>$course->id, 'timeclose'=>1200, 'timelimit'=>600));
        $attemptid = $DB->insert_record('quiz_attempts', array('quiz'=>$quiz->id, 'userid'=>$user2->id, 'state'=>'finished', 'timestart'=>100, 'timecheckstate'=>0, 'layout'=>'', 'uniqueid'=>$uniqueid++));
        $attempt = $DB->get_record('quiz_attempts', array('id'=>$attemptid));
        $context = context_module::instance($quiz->id);
        $cm = get_coursemodule_from_instance('quiz', $quiz->id);  
        
        // Assign the capabilities required for the messages we are testing
        assign_capability('mod/quiz:emailnotifysubmission', CAP_ALLOW, $teacherrole->id, $context->id);
        assign_capability('mod/quiz:emailconfirmsubmission', CAP_ALLOW, $studentrole->id, $context->id);
        assign_capability('mod/quiz:emailwarnoverdue', CAP_ALLOW, $studentrole->id, $context->id);
              
        // Get the updated course object
        $course = $DB->get_record('course', array('id' => $quiz->course));
        
        // Send messages:
        // 1. student mod_quiz confirmation 
        // 2. teacher mod_quiz submission
        quiz_send_notification_messages($course, $quiz, $attempt, $context, $cm);
        // Send message:
        // 1. student mod_quiz attempt_overdue
        quiz_send_overdue_message($course, $quiz, $attempt, $context, $cm);

        // Tests
        // Get the records from the table populated by the culactivity_stream
        // message output plugin (NB cannot use core tables as these are not
        // populated with the course info we need to test for)
        $messages = $DB->get_records('message_culactivity_stream');
        $this->assertEquals(3, count($messages));
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[1]->courseid);
        $eventdata = json_decode($messages[1]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[2]->courseid);
        $eventdata = json_decode($messages[2]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
        // Test that the correct course id is in the record
        $this->assertEquals($course->id, $messages[3]->courseid);
        $eventdata = json_decode($messages[3]->eventdata);
        // Test that the course object matches the object in eventdata
        $this->assertEquals($course, $eventdata->course);
    }
    
    public function test_lessonmessage() {
        // Essay marked
        // Procedural code - difficult to test        
    } 
    

    public function test_paypalmessage() {
        global $DB, $CFG;
        // 8. Paypal
        // Procedural code -  difficult to test
    }

    public function test_virusmessage() {
        // 7. Virus in uploaded file
        // Procedural code -  difficult to test
        // First line is a die statement!        
    }
}



