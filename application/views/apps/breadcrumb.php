<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="topbar-left">
    <ol class="breadcrumb">
        <li class="crumb-icon">
            <a href="#">
                <span class="glyphicon glyphicon-home"></span>
            </a>
        </li>
        <li class="crumb-trail">
        	<?php echo (isset($title)) ? $title : ''; ?>
        </li>
    </ol>
</div>