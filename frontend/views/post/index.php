<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
?>
<div class="site-index">

    <div class="body-content">
        <html lang="en" >
        <head>
            <meta charset="UTF-8">
            <title></title>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

            <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>

            <style>
                /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
                .glyphicon { margin-right:5px; }
                .thumbnail
                {
                    margin-bottom: 20px;
                    padding: 0px;
                    -webkit-border-radius: 0px;
                    -moz-border-radius: 0px;
                    border-radius: 0px;
                }

                .item.list-group-item
                {
                    float: none;
                    width: 100%;
                    background-color: #fff;
                    margin-bottom: 10px;
                }
                .item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
                {
                    background: #428bca;
                }

                .item.list-group-item .list-group-image
                {
                    margin-right: 10px;
                }
                .item.list-group-item .thumbnail
                {
                    margin-bottom: 0px;
                }
                .item.list-group-item .caption
                {
                    padding: 9px 9px 0px 9px;
                }
                .item.list-group-item:nth-of-type(odd)
                {
                    background: #eeeeee;
                }

                .item.list-group-item:before, .item.list-group-item:after
                {
                    display: table;
                    content: " ";
                }

                .item.list-group-item img
                {
                    float: left;
                }
                .item.list-group-item:after
                {
                    clear: both;
                }
                .list-group-item-text
                {
                    margin: 0 0 11px;
                }

            </style>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

        </head>

        <body>

        <div>

            <h1>NOTICIAS</h1>

                <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_post',

                ]); ?>

                <br>

                <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
                <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>

                <script  src="js/index.js"></script>

        </body>
    </div>


    </div>

				
			
				
			