<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>
    </head>
    <body class="home">  
        <div id="content">

            <div class="row">        


                <div class="columns large-12 checks">

                    <h4> Navigation </h4>

                    <p class="success"><a href="<?php echo HTTP_ROOT . "merchant" ?>"> Merchant </a></p>
                    <p class="success"><a href="<?php echo HTTP_ROOT . "customer" ?>"> Customer </a></p>

                </div>
            </div>

        </div>
    </body>
</html>
