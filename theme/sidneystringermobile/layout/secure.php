<?php

/**
 * @package   theme_sidneystringermobile
 * @copyright 2013 G Bowman gbowman85@gmail.com
 */
$logourl = $OUTPUT->pix_url('logo', 'theme');

// Get the HTML for the settings bits.
$html = theme_sidneystringermobile_get_html_for_settings($OUTPUT, $PAGE);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header id="header" role="banner" class="navbar navbar-fixed-top moodle-has-zindex">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <a class="logo" href="<?php echo $CFG->wwwroot; ?>" title="<?php print_string('home'); ?>">
                <img src="<?php echo $logourl ?>" alt="logo" />
            </a>
            <div class="btn btn-navbar" id="toggle-menu" title="open">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="btn-group pull-right">
             <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
               <i class="icon-user"></i> <?php echo fullname($USER, true); ?>
               <span class="caret"></span>
             </a>
             <ul class="dropdown-menu">
               <li><a href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id; ?>" title="View profile" >Profile</a></li>
               <li class="divider"></li>
               <li><a href="<?php echo $CFG->wwwroot.'/login/logout.php?sesskey='.sesskey() ?>">Sign Out</a></li>
             </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid snap-content">

    <?php //if ($layout !== 'content-only') { ?>
        <div class="snap-drawer snap-drawer-left">
            <div class="nav-collapse block">
                <?php echo $OUTPUT->custom_menu(); ?>
            </div>
            <?php echo $OUTPUT->blocks('side-pre'); ?>
            <?php echo $OUTPUT->blocks('side-post'); ?>
        </div>
    <?php //} ?>
    
    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
    </header>

    <div id="page-content" class="row-fluid">
        <div id="region-bs-main-and-pre" class="span9">
            <div class="row-fluid">
                <section id="region-main" class="span8 pull-right">
                    <?php echo $OUTPUT->main_content(); ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
