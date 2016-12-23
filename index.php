<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.coopceptor (oxygen)
 *
 * @copyright   Copyright (C) 2016 Alexon Balangue. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
#if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);# Add this code For Joomla 3.3.4+
$apps             = JFactory::getApplication();
$docs             = JFactory::getDocument();
$users            = JFactory::getUser();
jimport( 'joomla.environment.browser' );
$browser = JBrowser::getInstance();
$this->language  = $docs->language;
$this->direction = $docs->direction;

// Getting params from template
$params = $apps->getTemplate(true)->params;

$sitename = $apps->get('sitename');
$desc_site = $apps->getCfg('MetaDesc');
//PARAMS
$Grps_html = $this->params->get('groups-html');
$hide_joomla_default = $this->params->get('Pages-js-default');
// Output as HTML5
$docs->setHtml5(true);
$option   = $apps->input->getCmd('option', '');
$view     = $apps->input->getCmd('view', '');
$layout   = $apps->input->getCmd('layout', '');
$task     = $apps->input->getCmd('task', '');
$itemid   = $apps->input->getCmd('Itemid', '');
$directory_tpl = $this->baseurl.'templates/'.$this->template.'/';
if($task == "edit" || $layout == "form" ){ $fullWidth = 1; } else { $fullWidth = 0; }
//Remove défault JS Joomla 3.3.6/+ on front end home pages or other component


		
switch($hide_joomla_default):
	case 'home':
		$this->_script = $this->_scripts = array();	
		unset($docs->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/system/js/core.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/system/js/modal.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/system/js/caption.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/jui/js/jquery.min.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/jui/js/jquery-migrate.min.js']);
		unset($docs->_scripts[JURI::root(true) . '/media/jui/js/jquery-noconflict.js']);
		JHtmlBootstrap::framework(false);
		unset($docs->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
	break;
	case 'component':
		foreach ($this->_scripts as $script => $value){ if (preg_match('/media\/jui/i', $script)){ unset($this->_scripts[$script]); } }	
		JHtmlBootstrap::framework(false);
	break;
	default:
		$docs->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/assets/template.js');
		// Add Stylesheets
		$docs->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/assets/template.css');
		// Check for a custom CSS file
		$userCss = JPATH_SITE . '/templates/' . $this->template . '/assets/user.css';
		if (file_exists($userCss) && filesize($userCss) > 0)
		{
			$docs->addStyleSheetVersion('templates/' . $this->template . '/assets/user.css');
		}
			break;
endswitch;

# Adjusting content width
if ($this->countModules('sidebar-left') && $this->countModules('sidebar-right')){
	$boostrap2_sizes = "span6";
	$boostrap3_sizes = "col-xs-12 col-sm-6 col-md-6 col-lg-6";
	$amp_sizes = "";
	$foundation_sizes = "small-12 medium-6 large-6 columns";
	$metroui_sizes = "cell colspan6";
} elseif ($this->countModules('sidebar-left') && !$this->countModules('sidebar-right')){
	$boostrap2_sizes = "span9";
	$boostrap3_sizes = "col-xs-12 col-sm-9 col-md-9 col-lg-9";
	$amp_sizes = "";
	$foundation_sizes = "small-12 medium-9 large-9 columns";
	$metroui_sizes = "cell colspan9";
} elseif (!$this->countModules('sidebar-left') && $this->countModules('sidebar-right')){
	$boostrap2_sizes = "span9";
	$boostrap3_sizes = "col-xs-12 col-sm-9 col-md-9 col-lg-9";
	$amp_sizes = "";
	$foundation_sizes = "small-12 medium-9 large-9 columns";
	$metroui_sizes = "cell colspan9";
} else {
	$boostrap2_sizes = "span12";
	$boostrap3_sizes = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
	$amp_sizes = "";
	$foundation_sizes = "small-12 medium-expand large-expand columns";
	$metroui_sizes = "cell colspan12";
}

// Logo file or site title param logoFile

if(!empty($this->params->get('logoFile'))):
	$mypersonal_photo = $this->baseurl.'/'.$this->params->get('logoFile');
else:
	$mypersonal_photo = $this->baseurl.'/templates/'.$this->template.'/assets/img/profile.png';
endif;

if(!empty($this->params->get('logoFooter'))):
	$footer_logo = $this->baseurl.'/'.$this->params->get('logoFile');
else:
	$footer_logo = $directory_tpl . 'assets/img/logo.svg';
endif;

	$footer_logo = $directory_tpl . 'assets/img/logo.svg';


$Params_grpsJs = $this->params->get('groups-method');
$Params_grpsCSS = $this->params->get('groups-method');
if ($Params_grpsJs == 'production') : 
	$docs->addStyleSheetVersion(JUri::root(true).'/templates/'.$this->template.'/assets/production/'.$this->params->get('groups-script').'-full.min.css');
elseif ($Params_grpsJs == 'custom') : 
	$docs->addStyleSheetVersion(JUri::root(true).'/templates/'.$this->template.'/assets/custom/'.$this->params->get('groups-script').'-full.css');
endif;


$docs->addStyleSheet('https://fonts.googleapis.com/css?family=Montserrat:400,700');
//$docs->addStyleSheet('//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');


require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'renderer'.DIRECTORY_SEPARATOR.'head.php';

if( $browser->isMobile() == true ){
  $JMobileDetectHeader = '<jdoc:include type="modules" name="banner-mheader" style="nones" />';
  $JMobileDetectFooter = '<jdoc:include type="modules" name="banner-mfooter" style="nones" />';
} else {
  $JMobileDetectHeader =  '<jdoc:include type="modules" name="banner-header" style="nones" />';
  $JMobileDetectFooter = '<jdoc:include type="modules" name="banner-footer" style="nones" />';
}
?>

[doctype html="html" /]
<html <?php echo $params->get('ampHTML'); ?> lang="en" dir="<?php echo $this->direction; ?>">
	[head]
	<jdoc:include type="head" />
	[/head]
	[begins tags='body' mdatatype='http://schema.org/WebPage' /]
	[begins tags="div" class="preloader" /] [fa name="circle-o-notch" more="fa-spin" /] [ends tags="div" /]
	<?php switch($Grps_html): case 'boostrap2-home': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section id="services"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center span8" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_SERVICES'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
        [begins tags="div" class="row" /]
	<?php if ($this->countModules('bs3-services')) : ?>
		<jdoc:include type="modules" name="bs3-services" style="none" />
	<?php endif; ?>	
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
    [section id="information" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags="div" class="span12" /]
          [begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
			<?php if ($this->countModules('bs3-information')) : ?>
				<jdoc:include type="modules" name="bs3-information" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="why-choose-us"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center span8" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_WHYCHOOSEUS'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
			<?php if ($this->countModules('bs3-chooose-us')) : ?>
				<jdoc:include type="modules" name="bs3-chooose-us" style="none" />
			<?php endif; ?>	
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center span8 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="span12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center span8 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="span12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

  [section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='span12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='span3 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='span3 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='span3 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='span3 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='span12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
	<?php break; case 'boostrap2-component': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section class="parallax"]
		[begins tags="div" class="container-fluid" /]  
        [begins tags="div" class="row" /]
          [begins tags="div" class="span12" /]
            <?php echo $JMobileDetectHeader; ?>	
          [ends tags="div" /]
          [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section]
				[begins tags="div" class="container-fluid" /]  
					[begins tags="div" class="row" /]
						<?php if ($this->countModules('sidebar-left')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-left" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
						[begins tags='div' class='<?php echo $boostrap3_sizes; ?> wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							<jdoc:include type="modules" name="bs3-breadcrumb" style="nones" />
						[ends tags="div" /] 
						<?php if ($this->countModules('sidebar-right')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-right" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
					[ends tags="div" /] 
				[ends tags="div" /] 
			[/section]	
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center span8 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="span12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center span8 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="span12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

  [section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='span12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='span3 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='span3 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='span3 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='span3 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='span12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
			
	<?php break; case 'boostrap3-home': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section id="services"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_SERVICES'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
        [begins tags="div" class="row" /]
	<?php if ($this->countModules('bs3-services')) : ?>
		<jdoc:include type="modules" name="bs3-services" style="none" />
	<?php endif; ?>	
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
    [section id="information" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags="div" class="col-sm-12" /]
          [begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
			<?php if ($this->countModules('bs3-information')) : ?>
				<jdoc:include type="modules" name="bs3-information" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="why-choose-us"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_WHYCHOOSEUS'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
			<?php if ($this->countModules('bs3-chooose-us')) : ?>
				<jdoc:include type="modules" name="bs3-chooose-us" style="none" />
			<?php endif; ?>	
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'boostrap3-component': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section class="parallax"]
		[begins tags="div" class="container-fluid" /]  
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php echo $JMobileDetectHeader; ?>	
          [ends tags="div" /]
          [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section]
				[begins tags="div" class="container-fluid" /]  
					[begins tags="div" class="row" /]
						<?php if ($this->countModules('sidebar-left')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-left" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
						[begins tags='div' class='<?php echo $boostrap3_sizes; ?> wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							<jdoc:include type="modules" name="bs3-breadcrumb" style="nones" />
						[ends tags="div" /] 
						<?php if ($this->countModules('sidebar-right')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-right" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
					[ends tags="div" /] 
				[ends tags="div" /] 
			[/section]	
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'amp-home': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section id="services"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_SERVICES'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
        [begins tags="div" class="row" /]
	<?php if ($this->countModules('bs3-services')) : ?>
		<jdoc:include type="modules" name="bs3-services" style="none" />
	<?php endif; ?>	
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
    [section id="information" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags="div" class="col-sm-12" /]
          [begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
			<?php if ($this->countModules('bs3-information')) : ?>
				<jdoc:include type="modules" name="bs3-information" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="why-choose-us"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_WHYCHOOSEUS'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
			<?php if ($this->countModules('bs3-chooose-us')) : ?>
				<jdoc:include type="modules" name="bs3-chooose-us" style="none" />
			<?php endif; ?>	
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'amp-component': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section class="parallax"]
		[begins tags="div" class="container-fluid" /]  
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php echo $JMobileDetectHeader; ?>	
          [ends tags="div" /]
          [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section]
				[begins tags="div" class="container-fluid" /]  
					[begins tags="div" class="row" /]
						<?php if ($this->countModules('sidebar-left')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-left" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
						[begins tags='div' class='<?php echo $boostrap3_sizes; ?> wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							<jdoc:include type="modules" name="bs3-breadcrumb" style="nones" />
						[ends tags="div" /] 
						<?php if ($this->countModules('sidebar-right')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-right" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
					[ends tags="div" /] 
				[ends tags="div" /] 
			[/section]	
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'foundation-home': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section id="services"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_SERVICES'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
        [begins tags="div" class="row" /]
	<?php if ($this->countModules('bs3-services')) : ?>
		<jdoc:include type="modules" name="bs3-services" style="none" />
	<?php endif; ?>	
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
    [section id="information" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags="div" class="col-sm-12" /]
          [begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
			<?php if ($this->countModules('bs3-information')) : ?>
				<jdoc:include type="modules" name="bs3-information" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="why-choose-us"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_WHYCHOOSEUS'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
			<?php if ($this->countModules('bs3-chooose-us')) : ?>
				<jdoc:include type="modules" name="bs3-chooose-us" style="none" />
			<?php endif; ?>	
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'foundation-component': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section class="parallax"]
		[begins tags="div" class="container-fluid" /]  
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php echo $JMobileDetectHeader; ?>	
          [ends tags="div" /]
          [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section]
				[begins tags="div" class="container-fluid" /]  
					[begins tags="div" class="row" /]
						<?php if ($this->countModules('sidebar-left')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-left" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
						[begins tags='div' class='<?php echo $boostrap3_sizes; ?> wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							<jdoc:include type="modules" name="bs3-breadcrumb" style="nones" />
						[ends tags="div" /] 
						<?php if ($this->countModules('sidebar-right')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-right" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
					[ends tags="div" /] 
				[ends tags="div" /] 
			[/section]	
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="contact" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_CONTACT'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
            <?php if ($this->countModules('bs3-contact')) : ?>
				<jdoc:include type="modules" name="bs3-contact" style="none" />
			<?php endif; ?>	
        [ends tags="div" /]
		
[ends tags="div" /]
[/section]
			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
			
	<?php break; case 'metroui-home': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header]
  [section id="services"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_SERVICES'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
        [begins tags="div" class="row" /]
	<?php if ($this->countModules('bs3-services')) : ?>
		<jdoc:include type="modules" name="bs3-services" style="none" />
	<?php endif; ?>	
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
    [section id="information" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags="div" class="col-sm-12" /]
          [begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
			<?php if ($this->countModules('bs3-information')) : ?>
				<jdoc:include type="modules" name="bs3-information" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="why-choose-us"]
    [begins tags="div" class="container" /]
      [begins tags='div' class='heading wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="text-center col-sm-8 col-sm-offset-2" /]
            [h1]<?php echo JText::_('TPL_OXYGEN_WHYCHOOSEUS'); ?>[/h1]
          [ends tags="div" /]
        [ends tags="div" /] 
      [ends tags="div" /]
      [begins tags="div" class="text-center icon-fa-effect" /]
			<?php if ($this->countModules('bs3-chooose-us')) : ?>
				<jdoc:include type="modules" name="bs3-chooose-us" style="none" />
			<?php endif; ?>	
      [ends tags="div" /]
    [ends tags="div" /]
  [/section]
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
		
	<?php break; case 'metroui-component': ?>
  [header id="home"]
    [begins tags="div" class="header" /]
        [begins tags="div" class="item active" /]
          [begins tags="div" class="caption" /]
            <img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
            [p class="animated fadeInRightBig"]<?php echo $desc_site; ?>[/p]
			<meta itemprop="description" content="<?php echo $desc_site; ?>">
            [a more='data-scroll' class='btn btn-start animated fadeInUpBig' href='#services']<?php echo JText::_('TPL_OXYGEN_START'); ?>[/a]
          [ends tags="div" /]
        [ends tags="div" /]
      [a href="#services" id="tohash"][fa name="angle-down" /][/a]
    [ends tags="div" /]
    [begins tags="div" class="main-nav" /]
      [begins tags="div" class="container-fluid" /]
        [begins tags="div" class="navbar-header" /]
          [button type='button' class='navbar-toggle' more='data-toggle="collapse" data-target=".navbar-collapse"']
				[span class="sr-only"]Toggle navigation[/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
				[span class="icon-bar"][/span]
          [/button]
          [a class="navbar-brand" href="<?php echo $this->baseurl; ?>"]
            [h2]<?php echo $sitename; ?>[/h2]  
			<meta itemprop="name" content="<?php echo $sitename; ?>">
          [/a]         
        [ends tags="div" /]
        [begins tags="div" class="collapse navbar-collapse" /]
			<?php if ($this->countModules('oxigen_menu')) : ?>
				<jdoc:include type="modules" name="oxigen_menu" style="none" />
			<?php endif; ?>			
        [ends tags="div" /]
      [ends tags="div" /]
    [ends tags="div" /]
  [/header
  [section class="parallax"]
		[begins tags="div" class="container-fluid" /]  
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php echo $JMobileDetectHeader; ?>	
          [ends tags="div" /]
          [ends tags="div" /]
    [ends tags="div" /]
  [/section]
			[section]
				[begins tags="div" class="container-fluid" /]  
					[begins tags="div" class="row" /]
						<?php if ($this->countModules('sidebar-left')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-left" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
						[begins tags='div' class='<?php echo $boostrap3_sizes; ?> wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							<jdoc:include type="modules" name="bs3-breadcrumb" style="nones" />
						[ends tags="div" /] 
						<?php if ($this->countModules('sidebar-right')) : ?>
						[begins tags="div" class="<?php echo $boostrap3_sizes; ?>" /]
							<jdoc:include type="modules" name="sidebar-right" style="nones" />
						[ends tags="div" /] 
						<?php endif; ?>
					[ends tags="div" /] 
				[ends tags="div" /] 
			[/section]	
  [section id="translator" class="parallax"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_TRANSLATOR'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12" /]
            <?php if ($this->countModules('bs3-translate')) : ?>
				<jdoc:include type="modules" name="bs3-translate" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
		
    [ends tags="div" /]
  [/section]
  [section id="payments"]
    [begins tags="div" class="container" /]
      [begins tags="div" class="row" /]
        [begins tags='div' class='heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp' more='data-wow-duration="1200ms" data-wow-delay="300ms"' /]
          [h1]<?php echo JText::_('TPL_OXYGEN_PAYMENTS'); ?>[/h1]
        [ends tags="div" /]
      [ends tags="div" /]
        [begins tags="div" class="row" /]
          [begins tags="div" class="col-sm-12 text-center"]
			<?php if ($this->countModules('bs3-payments')) : ?>
				<jdoc:include type="modules" name="bs3-payments" style="none" />
			<?php endif; ?>	
          [ends tags="div" /]
        [ends tags="div" /]
    [ends tags="div" /]
  [/section]

			[section id="copyright" class="parallax"]
				[begins tags='div' class='container-fluid' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-md-12' /]<?php echo $JMobileDetectFooter; ?>
						  [hr /]
						[ends tags='div' /]
					[ends tags='div' /]
					[begins tags='div' class='row' /]
						<?php if ($this->countModules('bs3-footer1')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInLeftBig'  more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]
						  [begins tags="div" class="single-table" /] 
							<jdoc:include type="modules" name="oxigen_footer1" style="none" />
							[ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer2')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer2" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer3')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow zoomIn' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
						  [begins tags="div" class="single-table" /]      
							<jdoc:include type="modules" name="bs3-footer3" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	 
						<?php endif; ?>	
						<?php if ($this->countModules('bs3-footer4')) : ?>
						[begins tags='div' class='col-sm-3 col-xs-6 wow fadeInRightBig' more='data-wow-duration="1000ms" data-wow-delay="500ms"' /]    
						  [begins tags="div" class="single-table" /]               
							<jdoc:include type="modules" name="bs3-footer4" style="none" />
						  [ends tags="div" /]	
						[ends tags="div" /]	
						<?php endif; ?>	
					[ends tags="div" /]	
				[ends tags="div" /]
			[/section]	
		[footer class="footer"]
			[begins tags='div' class='wow fadeInUp' more='data-wow-duration="1000ms" data-wow-delay="300ms"' /]
				[begins tags='div' class='container' /]
					[begins tags='div' class='row' /]
						[begins tags='div' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center' mdatatype='http://schema.org/CreativeWork' /]
						<img src="<?php echo $footer_logo; ?>" alt="<?php echo $sitename; ?>" class="footer-logo animated fadeInDownBig">[br /][fa name="mobile" zoom="5x" /] [fa name="tablet" zoom="5x" /] [fa name="laptop" zoom="5x" /] [fa name="desktop" zoom="5x" /][br /]
					Nous sommes 100% amis avec les moteur de recherches et multiplateformes avec n'importe quelles choix de votre navigateur internet.[br /]
							<span itemprop="copyrightHolder">&copy; <a href="<?php echo JURI::base(); ?>"><?php echo $sitename; ?></a></span> - <span itemprop="copyrightYear"><?php echo date('Y'); ?></span> - Toute reproduction interdite sans l'autorisation de l'auteur.. - Conception par [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url] et WebDesigner par  [url href="//www.themeum.com" target="_top"]www.themeum.com[/url]
						[ends tags="div" /]	
					[ends tags="div" /]	
				[ends tags="div" /]	
			[ends tags="div" /]
		[/footer]
		
	<?php break; default: ?>
		[begins tags="body" /]
		[header]
			<img class="animated fadeInDownBig" src="<?php echo $mypersonal_photo; ?>" alt="<?php echo $sitename; ?>" itemprop="primaryImageOfPage">
		[/header]
		[section]
			No content here, please contact the webmaster.	
		[/section]
		[footer] 
			&copy; <?php echo date("Y").' '.$sitename; ?> - 
			Conception by [url href="//www.AlexonBalangue.me" target="_top"]www.AlexonBalangue.me[/url]  
		[/footer]
	<?php break; endswitch; ?>	
		<?php if ($this->countModules('referencer')) : ?><jdoc:include type="modules" name="referencer" style="none" /><?php endif; ?>	
		<?php if ($Params_grpsJs == 'production') : ?>
			[script src="<?php echo JURI::root(true).'/templates/'.$this->template.'/assets/production/'.$this->params->get('groups-script').'-full.min.js'; ?>" /] 
			
		<?php elseif ($Params_grpsJs == 'custom') : ?>	
			[script src="<?php echo JURI::root(true).'/templates/'.$this->template.'/assets/custom/'.$this->params->get('groups-script').'-full.js'; ?>" /]				
		<?php endif; ?>	
	

<?php /********[ LAWS EUROPEAN - obligation show cookie legal ]*******/ ?>
		[cookies legal="<?php echo JText::_('TPL_AGENCY_COOKIESEU_HOME'); ?>" botton="Ok" url="//www.meetpeopleworld.com/information/mention-legal.html" /] 	
		<jdoc:include type="modules" name="debug" style="none" />	

	[ends tags="body" /]  
</html>
