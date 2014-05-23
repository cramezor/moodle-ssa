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
 * Moodle's Clean theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   theme_sidneystringer
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasfooter = (empty($PAGE->layout_options['nofooter']));
$logourl = $OUTPUT->pix_url('logo', 'theme');


$hasfootnote = (!empty($PAGE->theme->settings->footnote));
$navbar_inverse = '';
if (!empty($PAGE->theme->settings->invert)) {
    $navbar_inverse = 'navbar-inverse';
}



$layout = 'content-only';
$bodyclasses[] = $layout;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title>Sidney Stringer Academy VLE | ssa-vle.org.uk</title>
    <link rel=icon href=<?php echo $OUTPUT->pix_url('favicon128', 'theme')?> sizes="128x128" type="image/png">
    <link rel=icon href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" type="image/vnd.microsoft.icon" />
    <link rel="apple-touch-icon" href=<?php echo $OUTPUT->pix_url('favicon57', 'theme')?> />
    <link rel="apple-touch-icon" sizes="72x72" href=<?php echo $OUTPUT->pix_url('favicon72', 'theme')?> />
    <link rel="apple-touch-icon" sizes="114x114" href=<?php echo $OUTPUT->pix_url('favicon114', 'theme')?> />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="description" content="A VLE for students and staff at Sidney Stringer Academy.">
    <link rel=stylesheet type=text/css href="http://ssa-vle.org.uk/theme/sidneystringer/style/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar <?php echo $navbar_inverse ?> navbar-fixed-top">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <a class="logo" href="<?php echo $CFG->wwwroot; ?>" title="<?php print_string('home'); ?>">
                <img src="<?php echo $logourl ?>" alt="logo" />
            </a>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">


    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span12">
            <?php echo $OUTPUT->main_content() ?>
        </section>
    </div>

    <footer id="page-footer">
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        if ($hasfootnote) { ?>
           <div class="footnote text-center">
           <?php echo $PAGE->theme->settings->footnote; ?>
           </div>
            <?php
        } ?>
    </footer>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>
