<?php

defined('_JEXEC') or die;
if (!isset($this->error))
{
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
$apps             = JFactory::getApplication();
$docs             = JFactory::getDocument();
$users            = JFactory::getUser();
$this->language  = $docs->language;
$this->direction = $docs->direction;

$params = $apps->getTemplate(true)->params;
$this->_script = $this->_scripts = array();	
$sitename = $apps->getCfg('sitename');
$descriptions = $apps->getCfg('MetaDesc');
$this->_script = $this->_scripts = array();	
$directory_tpl = JURI::root(true) . '/templates/oxygen/';
 

$logo = '<img class="animated fadeInDownBig" src="' . $directory_tpl . 'assets/images/mpw-logo.gif" alt="' . $sitename . '" />';
$footer_logo = $directory_tpl . 'assets/images/mpw-logo.png';
# If you use Analyrics intern - Piwik | With plugin https://www.yireo.com/software/joomla-extensions/piwik
#include_once JPATH_SITE . '/plugins/system/piwik/piwik.php';
#if (class_exists('PlgSystemPiwik')) {
#    PlgSystemPiwik::callPiwik();
#}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

  <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="<?php echo $this->baseurl; ?>/media/mod_opensource/effect/animate.min.css" rel="stylesheet">
  <link href="<?php echo $this->baseurl; ?>/templates/oxygen/assets/production/boostrap3-full.min.css" rel="stylesheet">

	<!--<if lt IE 9>
		[script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" /]
		[script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" /]
	<!<endif>-->

  <link rel="shortcut icon" href="<?php echo $directory_tpl; ?>favicon.ico">
</head>
<body>
 <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
  <header id="home">
    <div class="header">
        <div class="item active">
          <div class="caption">
            <img src="images/owner/logo.png" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            <p class="animated fadeInRightBig"><?php echo $descriptions; ?></p>
			<meta itemprop="description" content="<?php echo $descriptions; ?>">
            <a data-scroll class="btn btn-start animated fadeInUpBig" href="#intro">Introduction</a>
          </div>
        </div>

      <a id="tohash" href="#intro"><i class="fa fa-angle-down"></i></a>

    </div>
    <div class="main-nav">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">
            <h2><?php echo $sitename; ?></h2>  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          </a>                  
        </div>
        <div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="scroll active"><a href="#home" class="fa fa-warning"></a></li>	
				<li class="scroll"><a href="index.html"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></li>	
			</ul>
        </div>
      </div>
    </div>
  </header>
  <section id="intro">
    <div class="container">
      <div class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="row">
          <div class="text-center col-sm-8 col-sm-offset-2">
            <h1><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></h1>
          </div>
        </div> 
      </div>
      <div class="text-center">
        <div class="row">
          <div class="col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
			<p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
			<ol>
				<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
				<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
				<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
				<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
				<li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
				<li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
			</ol>
			<p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>
			<ul>
				<li><a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></li>
			</ul>
			<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
			<div class="well">
			<p><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
			<p>
				<?php if ($this->debug) : ?>
					<?php echo $this->renderBacktrace(); ?>
				<?php endif; ?>
			</p>
			</div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer">
    <div class="wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
			<p><img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo">
						<br><i class="fa fa-mobile fa-5x"></i> <i class="fa fa-tablet fa-5x"></i> <i class="fa fa-laptop fa-5x"></i> <i class="fa fa-desktop fa-5x"></i> <br>
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.<br>
                    <span itemprop="copyrightHolder">&copy; <a href="<?php echo $this->baseurl; ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - 
					Conception by <a href="//www.AlexonBalangue.me" target="_top">www.AlexonBalangue.me</a> - Webdesigner by <a href="//www.themeum.com" target="_top">www.themeum.com</a>
					<br />Toute reproduction interdite sans l'autorisation de l'auteur. </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="<?php echo $this->baseurl; ?>/media/mod_opensource/effect/wow.min.js"></script>
  <script src="<?php echo $this->baseurl; ?>/templates/oxygen/assets/production/boostrap3-full.min.js"></script>

</body>
</html>