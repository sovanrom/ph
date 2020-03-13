<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-md-6 col-sm-4 clearfix hidden-xs">
    <ul class="list-inline links-list pull-right">
        <li>
            <a href="<?= fleet_url('fleet'); ?>">
                <i class="entypo-tape right"></i> Fleets
            </a>
        </li>
        <li class="dropdown language-selector">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                <img src="<?php echo base_url(); ?>assets/neon/images/flags/flag-uk.png" width="16" height="16" />
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/neon/images/flags/flag-de.png" width="16" height="16" />
                        <span>Deutsch</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/neon/images/flags/flag-uk.png" width="16" height="16" />
                        <span>English</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sep"></li>
        <li>
            <a href="<?=admin_url('user/logout')?>">
                Log Out <i class="entypo-logout right"></i>
            </a>
        </li>
    </ul>
</div>