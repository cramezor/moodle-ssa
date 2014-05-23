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
 * Strings for core subsystem 'blog'
 *
 * @package    core
 * @subpackage blog
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['addnewentry'] = 'Add a new general post';
$string['addnewexternalblog'] = 'Register an external blog';
$string['assocdescription'] = 'If you are writing about a course and/or activity modules, select them here.';
$string['associated'] = 'Associated {$a}';
$string['associatewithcourse'] = 'Blog about course {$a->coursename}';
$string['associatewithmodule'] = 'Blog about {$a->modtype}: {$a->modname}';
$string['association'] = 'Association';
$string['associations'] = 'Associations';
$string['associationunviewable'] = 'This post cannot be viewed by others until a course is associated with it or the \'Publish to\' field is changed';
$string['autotags'] = 'Add these tags';
$string['autotags_help'] = 'Enter one or more local tags (separated by commas) that you want to automatically add to each blog post copied from the external blog into your local blog.';
$string['backupblogshelp'] = 'If enabled then blogs will be included in SITE automated backups';
$string['blockexternalstitle'] = 'External blogs';
$string['blocktitle'] = 'Blog tags block title';
$string['blog'] = 'Blog';
$string['blogaboutthis'] = 'Blog about this {$a->type}';
$string['blogaboutthiscourse'] = '+ New blog post';
$string['blogaboutthismodule'] = 'Add a post about this {$a}';
$string['blogadministration'] = 'Blog administration';
$string['blogdeleteconfirm'] = 'Delete this blog post?';
$string['blogdisable'] = 'Blogging is disabled!';
$string['blogentries'] = 'Blog posts';
$string['blogentriesabout'] = 'Blog posts about {$a}';
$string['blogentriesbygroupaboutcourse'] = 'Blog posts about {$a->course} by {$a->group}';
$string['blogentriesbygroupaboutmodule'] = 'Blog posts about {$a->mod} by {$a->group}';
$string['blogentriesbyuseraboutcourse'] = 'Blog posts about {$a->course} by {$a->user}';
$string['blogentriesbyuseraboutmodule'] = 'Blog posts about this {$a->mod} by {$a->user}';
$string['blogentrybyuser'] = 'Blog post by {$a}';
$string['blogpreferences'] = 'Blog preferences';
$string['blogs'] = 'Blogs';
$string['blogscourse'] = 'Course blogs';
$string['blogssite'] = 'Site blogs';
$string['blogtags'] = 'Blog tags';
$string['cannotviewcourseblog'] = 'You do not have the required permissions to view blogs in this course';
$string['cannotviewcourseorgroupblog'] = 'You do not have the required permissions to view blogs in this course/group';
$string['cannotviewsiteblog'] = 'You do not have the required permissions to view all site blogs';
$string['cannotviewuserblog'] = 'You do not have the required permissions to read user blogs';
$string['configexternalblogcrontime'] = 'How often Moodle checks the external blogs for new posts.';
$string['configmaxexternalblogsperuser'] = 'The number of external blogs each user is allowed to link to their Moodle blog.';
$string['configuseblogassociations'] = 'Enables the association of blog posts with courses and course modules.';
$string['configuseexternalblogs'] = 'Enables users to specify external blog feeds. Moodle regularly checks these blog feeds and copies new posts to the local blog of that user.';
$string['courseblog'] = 'Course blog: {$a}';
$string['courseblogdisable'] = 'Course blogs are not enabled';
$string['courseblogs'] = 'Users can only see blogs for people who share a course';
$string['deleteblogassociations'] = 'Delete blog associations';
$string['deleteblogassociations_help'] = 'If ticked then blog posts will no longer be associated with this course or any course activities or resources.  The blog posts themselves will not be deleted.';
$string['deleteexternalblog'] = 'Unregister this external blog';
$string['deleteotagswarn'] = 'Are you sure you want to remove these tags from all blog posts and remove it from the system?';
$string['description'] = 'Description';
$string['description_help'] = 'Enter a sentence or two summarising the contents of your external blog. (If no description is supplied, the description recorded in your external blog will be used).';
$string['donothaveblog'] = 'You do not have your own blog, sorry.';
$string['editentry'] = 'Edit a blog post';
$string['editexternalblog'] = 'Edit this external blog';
$string['emptybody'] = 'Blog post body can not be empty';
$string['emptyrssfeed'] = 'The URL you entered does not point to a valid RSS feed';
$string['emptytitle'] = 'Blog post title can not be empty';
$string['emptyurl'] = 'You must specify a URL to a valid RSS feed';
$string['entrybody'] = 'Blog post body';
$string['entrybodyonlydesc'] = 'Entry description';
$string['entryerrornotyours'] = 'This post is not yours';
$string['entrysaved'] = 'Your post has been saved';
$string['entrytitle'] = 'Entry title';
$string['eventblogentriesviewed'] = 'Blog posts viewed';
$string['eventblogassociationadded'] = 'Blog association created';
$string['evententryadded'] = 'Blog post added';
$string['evententrydeleted'] = 'Blog post deleted';
$string['evententryupdated'] = 'Blog post updated';
$string['externalblogcrontime'] = 'External blog cron schedule';
$string['externalblogdeleteconfirm'] = 'Unregister this external blog?';
$string['externalblogdeleted'] = 'External blog unregistered';
$string['externalblogs'] = 'External blogs';
$string['feedisinvalid'] = 'This feed is invalid';
$string['feedisvalid'] = 'This feed is valid';
$string['filterblogsby'] = 'Filter posts by...';
$string['filtertags'] = 'Filter tags';
$string['filtertags_help'] = 'You can use this feature to filter the posts you want to use. If you specify tags here (separated by commas) then only posts with these tags will be copied from the external blog.';
$string['groupblog'] = 'Group blog: {$a}';
$string['groupblogdisable'] = 'Group blog is not enabled';
$string['groupblogentries'] = 'Blog posts associated with {$a->coursename} by group {$a->groupname}';
$string['groupblogs'] = 'Users can only see blogs for people who share a group';
$string['incorrectblogfilter'] = 'Incorrect blog filter type specified';
$string['intro'] = 'This RSS feed was automatically generated from one or more blogs.';
$string['invalidgroupid'] = 'Invalid group ID';
$string['invalidurl'] = 'This URL is unreachable';
$string['linktooriginalentry'] = 'Link to original blog post';
$string['maxexternalblogsperuser'] = 'Maximum number of external blogs per user';
$string['name'] = 'Name';
$string['name_help'] = 'Enter a descriptive name for your external blog. (If no name is supplied, the title of your external blog will be used).';
$string['noentriesyet'] = 'No visible posts here';
$string['noguestpost'] = 'Guest can not post blogs!';
$string['nopermissionstodeleteentry'] = 'You lack the permissions required to delete this blog post';
$string['norighttodeletetag'] = 'You have no rights to delete this tag - {$a}';
$string['nosuchentry'] = 'No such blog post';
$string['notallowedtoedit'] = 'You are not allowed to edit this post';
$string['numberofentries'] = 'Entries: {$a}';
$string['numberoftags'] = 'Number of tags to display';
$string['pagesize'] = 'Blog posts per page';
$string['permalink'] = 'Permalink';
$string['personalblogs'] = 'Users can only see their own blog';
$string['preferences'] = 'Preferences';
$string['publishto'] = 'Publish to';
$string['publishto_help'] = 'There are 3 options:

* Yourself (draft) - Only you and the teachers can see this post
* Anyone on this site - Anyone who is registered on this site can read this post
* Anyone in the world - Anyone, including guests, could read this post';
$string['publishtocourse'] = 'Users sharing a course with you';
$string['publishtocourseassoc'] = 'Members of the associated course';
$string['publishtocourseassocparam'] = 'Members of {$a}';
$string['publishtogroup'] = 'Users sharing a group with you';
$string['publishtogroupassoc'] = 'Your group members in the associated course';
$string['publishtogroupassocparam'] = 'Your group members in {$a}';
$string['publishtonoone'] = 'Yourself (draft)';
$string['publishtosite'] = 'Anyone on this site';
$string['publishtoworld'] = 'Anyone in the world';
$string['readfirst'] = 'Read this first';
$string['relatedblogentries'] = 'Related blog posts';
$string['retrievedfrom'] = 'Retrieved from';
$string['rssfeed'] = 'Blog RSS feed';
$string['searchterm'] = 'Search: {$a}';
$string['settingsupdatederror'] = 'An error has occurred, blog preference setting could not be updated';
$string['siteblog'] = 'Site blog: {$a}';
$string['siteblogdisable'] = 'Site blog is not enabled';
$string['siteblogs'] = 'All site users can see all blog posts';
$string['tagdatelastused'] = 'Date tag was last used';
$string['tagparam'] = 'Tag: {$a}';
$string['tags'] = 'Tags';
$string['tagsort'] = 'Sort the tag display by';
$string['tagtext'] = 'Tag text';
$string['timefetched'] = 'Time of last sync';
$string['timewithin'] = 'Display tags used within this many days';
$string['updateentrywithid'] = 'Updating post';
$string['url'] = 'RSS feed URL';
$string['url_help'] = 'Enter the RSS feed URL for your external blog.';
$string['useblogassociations'] = 'Enable blog associations';
$string['useexternalblogs'] = 'Enable external blogs';
$string['userblog'] = 'User blog: {$a}';
$string['userblogentries'] = 'Blog posts by {$a}';
$string['valid'] = 'Valid';
$string['viewallblogentries'] = 'All posts about this {$a}';
$string['viewallmodentries'] = 'View all posts about this {$a->type}';
$string['viewallmyentries'] = 'My blog posts from the whole site';
$string['viewentriesbyuseraboutcourse'] = 'View posts about this course by {$a}';
$string['viewblogentries'] = 'View all posts about this {$a->type}';
$string['viewblogsfor'] = 'View all posts for...';
$string['viewcourseblogs'] = 'Other blog posts';
$string['viewgroupblogs'] = 'View posts for group...';
$string['viewgroupentries'] = 'Group posts';
$string['viewmodblogs'] = 'View posts for module...';
$string['viewmodentries'] = 'Module posts';
$string['viewmyentries'] = 'My posts';
$string['viewmyentriesaboutmodule'] = 'View my posts about this {$a}';
$string['viewmyentriesaboutcourse'] = 'My blog posts';
$string['viewsiteentries'] = 'View all posts';
$string['viewuserentries'] = 'View all posts by {$a}';
$string['worldblogs'] = 'The world can read posts set to be world-accessible';
$string['wrongpostid'] = 'Wrong blog post id';
$string['page-blog-edit'] = 'Blog editing pages';
$string['page-blog-index'] = 'Blog listing pages';
$string['page-blog-x'] = 'All blog pages';
