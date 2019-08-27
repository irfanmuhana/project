<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

// You can use the registerAssetBundle function if you'd like
//$this->registerAssetBundle('app');
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title><?php echo Html::encode($this->title); ?></title>
<meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
<meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
<meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel='stylesheet' type='text/css' href="<?php echo UrL::to('@web/../template/orangesplash/files/main_style.css');?>" title='wsite-theme-css' />
<link rel='stylesheet' type='text/css' href="<?php echo UrL::to('@web/../template/orangesplash/files/bootstrap.css');?>" />
<link href='http://fonts.googleapis.com/css?family=Advent+Pro:400,700' rel='stylesheet' type='text/css' />
<?php $this->head(); ?>
</head>
<body class='wsite-theme-light tall-header-page wsite-page-index weeblypage-index'>
<?php $this->beginBody(); ?>
<div id="wrap">
  <div id="header-top">
    <table id="header">
      <tr>
        <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title"><?php echo Html::encode(\Yii::$app->name); ?></span></a></span></td>
        <td id="header-right">
          <table>
            <tr>
              <td class="phone-number"></td>
              <td class="social"></td>
            </tr>
          </table>
          <div class="search"></div>
        </td>
      </tr>
    </table>
    <div id="topnav">
      <div id="nav-right">
        <div id="nav-inner">
          <?php echo Menu::widget(array(
            'options' => array('class' => 'nav'),
            'items' => array(
              array('label' => 'Home', 'url' => array('/site/index')),
              array('label' => 'Tracking', 'url' => array('/tracking')),
              array('label' => 'Map', 'url' => array('/site/show-map')),
              array('label' => 'About', 'url' => array('/site/about')),
              Yii::$app->user->isGuest ?
                array('label' => 'Login', 'url' => array('/site/login')) :
                array('label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => array('/site/logout')),
            ),
          )); ?>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </div>
  <div id="main">
    <div id="banner-wrap">
      <div id="banner">
        <div class="wsite-header"></div>
        <em id="tl"></em>
        <em id="tr"></em>
        <em id="bl"></em>
        <em id="br"></em>
      </div>
    </div>
    <div id="content"><div id='wsite-content' class='wsite-not-footer'>
      <?php echo $content; ?>
</div>
</div>
  </div>
  <div id="footer-container">
    <div id="footer"><?php echo Html::encode(\Yii::$app->name); ?>
</div>
  </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>