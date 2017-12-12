<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
		<!-- Meta info -->
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?= Html::csrfMetaTags() ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- Title -->
		<title>Municipalidad de Yungay</title>
		<link rel="shortcut icon" href=".././web/recursos/img/favicon1.ico" />
        <?php
        $this->registerJsFile('recursos/jquery/tooltip.js');
        $this->registerJsFile('recursos/jquery/jquery.js');
        $this->registerJsFile('recursos/jquery/jquery-migrate.min.js');
        $this->registerJsFile('recursos/jquery/jquery.mobilemenu.min.js');
        $this->registerJsFile('recursos/jquery/jquery.easing.1.3.js');
        $this->registerJsFile('recursos/jquery/steper.js');     
		$this->registerJsFile('recursos/smartmenus/jquery.smartmenus.js');     


        ?>
	<link rel="stylesheet" href=".././web/recursos/font/css/font-awesome.min.css">

	<link rel='stylesheet' id='style-css'  href='.././web/recursos/css/style.css' type='text/css' media='all' />
	<link rel='stylesheet' id='camera-css'  href='.././web/recursos/css/camera.css' type='text/css' media='all' />
	<link rel='stylesheet' id='skeleton-css'  href='.././web/recursos/css/skeleton.css' type='text/css' media='all' />
	<link rel='stylesheet' id='google-webfonts-css'  href='.././web/recursos/css/css.css' type='text/css' media='all' />
	<link rel='stylesheet' href='.././web/recursos/smartmenus/css/sm-core-css.css' type='text/css' media='all' />
	<link rel='stylesheet' href='.././web/recursos/smartmenus/css/sm-blue/sm-blue.css' type='text/css' media='all' />

						<script language="JavaScript" type="text/javascript">
							function actualizaReloj() {
								marcacion = new Date()
								Hora = marcacion.getHours()
								Minutos = marcacion.getMinutes()
								/*dn = "a.m"
								if (Hora > 12) {
									dn = "p.m"
									Hora = Hora - 12
								}
								if (Hora == 0)
									Hora = 12*/
								if (Hora <= 9) Hora = "0" + Hora
								if (Minutos <= 9) Minutos = "0" + Minutos
								//if (Segundos <= 9) Segundos = "0" + Segundos

								var Dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
								var Mes = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
								"Octubre", "Noviembre", "Diciembre");
								var Hoy = new Date();
								var Anio = Hoy.getFullYear();
								var Fecha = Dia[Hoy.getDay()] + ", " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " del " + Anio + " - ";
								var Script, Total
								//Script = Fecha + Hora + ":" + Minutos + ":" + Segundos + " " + dn
								Script = Fecha + Hora + ":" + Minutos + " hrs."
								Total = Script
								document.getElementById('Fecha_Reloj').innerHTML = Total
								//setTimeout("actualizaReloj()", 1000)
								setTimeout("actualizaReloj()", 30000)
							}
						</script>
<script language="JavaScript" type="text/javascript">
	(function() {
		('#main-menu').smartmenus({
			subMenusSubOffsetX: 1,
			subMenusSubOffsetY: -8
		});
	});
</script>


	<?php $this->head() ?>
</head>
	<body onload="actualizaReloj()" class="home blog"> 
	<?php $this->beginBody() ?>
		<!-- #wrapper -->	
		<div id="wrapper" class="container clearfix"> 
    
			<!-- /#Header --> 
			<div id="wrapper-container"> 
				<div id="header">	
					<div id="head-content" class="clearfix ">
						
						<!-- Logo --> 
							<div id="logo">   
								<a href="#" title="Municipalidad de Yungay" rel="home"><img src=".././web/recursos/img/Banner.jpg" alt="Municipalidad de Yungay" /></a>       
							</div>
							<div class="col-lg-3">
								<a href="http://ubiobio.cl" target="_blank"><img src='.././web/recursos/img/ubb.jpg' style="max-width: 200px; max-height: 65px;" /></a>
							</div>
							<div style="float:right; margin-right:1%; margin-top:1%;">
								<table><tr><td id="Fecha_Reloj"></td></tr></table>
							</div>	
						<!-- /#Logo -->
					</div>
				</div>
			<!-- /#Header --> 

			<!-- #CatNav -->  
				<div class="secondary">	
				<?php

            if (Yii::$app->user->isGuest) {
                $menuItems = [
                   // ['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Noticias', 'url' => ['post/noticias']],
                    ['label' => 'Bases', 'url' => ['/bases/index']],
                    ['label' => 'Resultados', 'url' => ['/site/resultados']],
                    ['label' => 'Preguntas Frecuentes', 'url' => ['/site/preguntasfrecuentes']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],

                ];
                $menuItems[] = ['label' => 'Registrar', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
            } else {
                $menuItems = [
                    //['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Noticias', 'url' => ['post/noticias']],
                    ['label' => 'Postulaciones', 'url' => ['/site/mipostulacion']],
                    ['label' => 'Convocatorias', 'url' => ['/site/convocatoria']],
                    ['label' => 'Resultados', 'url' => ['/site/resultados']],
                    ['label' => 'Bases', 'url' => ['/bases/index']],
                    ['label' => 'Preguntas Frecuentes', 'url' => ['/site/preguntasfrecuentes']],

                    ['label' => 'Datos personales', 'url' => ['/site/datospersonales']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],


                ];


                $menuItems[] = [
                    //'label' => 'Cerrar Sesión ('.Yii::$app->user->identity->username.')',
                    'label' => 'Cerrar Sesión ',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'main-menu sm-blue'],
                'items' => $menuItems,
            ]);
            ?>
            
</div>
<br>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>

				<!-- /#CatNav -->  
			<!--/#blocks-wrapper-->
			</div>
		<!--/#Wrapper-container -->
		</div>
		
		<!-- #footer-->
		<div id="footer" class="container clearfix">
			<div class="foot-wrap container"> 
				<p align="center" class="credit">I. Municipalidad de Yungay. Esmeralda 380, Yungay, Mesa Central 42 - 2 205 600</p> 
			</div>
		</div>		
		<!--/#Footer -->
		<?php
        $this->registerJsFile('recursos/jquery/camera.min.js');
        $this->registerJsFile('recursos/jquery/jquery.mobile.customized.min.js');
        $this->registerJsFile('recursos/jquery/widget.min.js');
        ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

