 <?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/**
 * @var $this \yii\base\View
 * @var $content string
 */
// $this->registerAssetBundle('app');
?>
<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo Html::encode(\Yii::$app->name); ?> - A ThemeFactory.net Theme</title>
    
    <?php $this->head() ?>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo UrL::to('@web/template/babyblue/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo UrL::to('@web/template/babyblue/css/business-casual.css'); ?> " rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
      
      body {
        background-image: url(https://i.imgur.com/RdIjGUL.jpg);
      }
    /*** TF PALETTE ***/
body{background-color:#ACF0F2;background-image:none;}
footer, .box {background-color:#225378;border-color:#225378;}

footer a:hover {
  color: #1695A3;
}

nav.navbar-default{background:#F3FFE2;}
.btn-primary, .btn-default, .btn-default:focus, .btn-default:hover, .btn-primary:focus, .btn-primary:hover{background-color:#EB7F00 !important;border-color:#EB7F00 !important;}
body,p,.navbar-default .navbar-nav>li>a,.navbar-default .navbar-nav>li>a:hover{color:#1695A3;}
    </style>

</head>

<body>
<?php $this->beginBody() ?>
    <div class="brand"><?php echo Html::encode(\Yii::$app->name); ?></div>
    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="#"><?php echo Html::encode(\Yii::$app->name); ?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php   
      				if (!Yii::$app->user->isGuest) {
                ?>
                <?php if (Yii::$app->user->identity->role=='Admin'){
                    echo Menu::widget([
      				  'options' => [
      				    "id"  => "nav",
      				    "class" => "nav navbar-nav"
      				  ],
                        'items' => [
    				        ['label' => 'Home', 'url' => ['site/index']], 
                            ['label' => 'History', 'url' => ['/tracking']],
                            ['label' => 'Tracking', 'url' => ['/site/show-map']],
    				        ['label' => 'About', 'url' => ['site/about']],
                            ['label' => 'User', 'url' => ['/register']],
    				        Yii::$app->user->isGuest ?
                            ['label' => 'Login', 'url' => ['/site/login']] :
                            ['label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => ['/site/logout']],
    				    ],
      				]);
                } 
                elseif (Yii::$app->user->identity->role=='Kepala Tim') {
                    echo Menu::widget([
                      'options' => [
                        "id"  => "nav",
                        "class" => "nav navbar-nav"
                      ],
                        'items' => [
                            ['label' => 'Home', 'url' => ['site/index']], 
                            ['label' => 'History', 'url' => ['/tracking']],
                            ['label' => 'Tracking', 'url' => ['/site/show-map']],
                            ['label' => 'About', 'url' => ['site/about']],
                            ['label' => 'Contact', 'url' => ['site/contact']],
                            Yii::$app->user->isGuest ?
                            ['label' => 'Login', 'url' => ['/site/login']] :
                            ['label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => ['/site/logout']],
                        ],
                    ]);
                }
                else {
                  echo Menu::widget([
                      'options' => [
                        "id"  => "nav",
                        "class" => "nav navbar-nav"
                      ],
                        'items' => [
                            ['label' => 'Home', 'url' => ['site/index']], 
                            ['label' => 'History', 'url' => ['/tracking']],
                            ['label' => 'Tracking', 'url' => ['/site/show-map']],
                            ['label' => 'About', 'url' => ['site/about']],
                            ['label' => 'Contact', 'url' => ['site/contact']],
                            Yii::$app->user->isGuest ?
                            ['label' => 'Login', 'url' => ['/site/login']] :
                            ['label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => ['/site/logout']],
                        ],
                    ]);   
                }  }?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">
                    <div id="carousel-example-generic" class="carousel slide">
                        <!-- Indicators -->
                        <ol class="carousel-indicators hidden-xs">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="img-responsive img-full" src="<?php echo UrL::to('@web/template/babyblue/picture/sar1.jpg');?>" alt="">
                            </div>
                            <div class="item">
                                <img class="img-responsive img-full" src="<?php echo UrL::to('@web/template/babyblue/picture/sar2.jpg');?>" alt="">
                            </div>
                            <div class="item">
                                <img class="img-responsive img-full" src="<?php echo UrL::to('@web/template/babyblue/picture/sar3.jpg');?>" alt="">
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="icon-next"></span>
                        </a>
                    </div>
                    


        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; <?php echo Html::encode(\Yii::$app->name); ?> Polines 2019  </p>
                </div>
            </div>
        </div>
    </footer>
    <?php 
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path); 

    $ttl = count($uri_segments);
    ?>
    <?php 
        if ($ttl > 4) {
        if($uri_segments[4]!='show-map'){
    ?>
    <!-- jQuery -->
    <script src="<?php echo UrL::to('@web/template/babyblue/js/jquery.js');?>"></script> 

    <?php }        }
    ?>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo UrL::to('@web/template/babyblue/js/bootstrap.min.js');?>"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
      interval: 5000
    });
    </script>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>