<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.coopceptor-oxygen
 *
 * @copyright   Copyright (C) 2016 Alexon Balangue. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

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
$footer_logo = $directory_tpl . 'assets/img/logo.svg';
require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

$twofactormethods = UsersHelper::getTwoFactorMethods();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	[meta charset="utf-8" /]
	[title]<?php echo $sitename.' - '.JText::_('JOFFLINE_MESSAGE'); ?>[/title]
	[begins tags='meta' more='name="viewport" content="width=device-width, initial-scale=1"' /]
	[begins tags='meta' more='name="robots" content="noindex,nofollow"' /]	
	[link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template.'/assets/production/css/offline.min.css'; ?>" type="text/css" /]
	<?php if ($apps->get('debug_lang', '0') == '1' || $apps->get('debug', '0') == '1') : ?>
		[link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/cms/css/debug.css" type="text/css" /]
	<?php endif; ?>
	[link rel="shortcut icon" href="<?php echo $this->baseurl; ?>/templates/oxygen/favicon.ico" type="image/vnd.microsoft.icon" /]
	[link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" /]
	[link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/mod_opensource/effect/animate.min.css" type="text/css" /]
	[link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" /]
	[link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/oxygen/assets/production/boostrap3-full.min.css" type="text/css" /]
	<!--<if lt IE 9>
		[script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" /]
		[script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" /]
	<!<endif>-->
</head>
<body>
<jdoc:include type="message" /> 
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
			 <li class="hidden">
				 <a href="#page-top"></a>
			 </li>	
			 <li class="scroll active">
				 <a href="#intro"></a>
			 </li>	
			 <li class="scroll">
				 <a href="#copyright">Copyright</a>
			 </li>	
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
            <h1>Site en maintenance</h1>
          </div>
        </div> 
      </div>
      <div class="text-center">
        <div class="row">
          <div class="col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
	<?php if ($apps->get('display_offline_message', 1) == 1 && str_replace(' ', '', $apps->get('offline_message')) != '') : ?>
		<p>
			<?php echo $apps->get('offline_message'); ?>
		</p>
	<?php elseif ($apps->get('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != '') : ?>
		<p>
			<?php echo JText::_('JOFFLINE_MESSAGE'); ?>
		</p>
	<?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
    <section class="parallax">
    <div class="container">
      <div class="row text-center">
        <div class="col-sm-12">
          <div class="wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
         	<form action="<?php echo JRoute::_('index.php', true); ?>" class="form-inline" method="post" id="form-login">

		<div class="form-group">
			<label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
			<input name="username" id="username" type="text" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" />
		</div>
		<div class="form-group">
			<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
			<input type="password" name="password" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" id="passwd" />
		</div>
		<?php if (count($twofactormethods) > 1) : ?>
			<div class="form-group">
				<label for="secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
				<input type="text" name="secretkey" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" />
			</div>
		<?php endif; ?>
			<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGIN'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JUri::base()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer" id="copyright">
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

	[script src="https://code.jquery.com/jquery-1.12.3.min.js" /] 
	[script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" /] 
	[script src="<?php echo $this->baseurl; ?>/templates/oxygen/assets/production/boostrap3-full.min.js" /] 
	[script src="<?php echo $this->baseurl; ?>/media/mod_opensource/effect/wow.min.js" /] 

</body>
</html>