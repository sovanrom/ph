<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul id="main-menu" class="main-menu">

    <li class="has-sub">
        <a href="index.html">
            <i class="entypo-gauge"></i>
            <span class="title">Dashboard</span>
        </a>
        <ul>
            <li>
                <a href="index.html">
                    <span class="title">Dashboard 1</span>
                </a>
            </li>
            <li>
                <a href="dashboard-2.html">
                    <span class="title">Dashboard 2</span>
                </a>
            </li>
            <li>
                <a href="dashboard-3.html">
                    <span class="title">Dashboard 3</span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="index.html" target="_blank">
            <i class="entypo-monitor"></i>
            <span class="title">Frontend</span>
        </a>
    </li>

     <li class="has-sub">
        <a href="index.html">
            <i class="entypo-gauge"></i>
            <span class="title">Building</span>
        </a>
        <ul>
            <li>
                <a href="<?php echo base_url(); ?>manage_building">
                    <span class="title">Manage Building</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="has-sub">
        <a href="index.html">
            <i class="entypo-gauge"></i>
            <span class="title">Settings</span>
        </a>
        <ul>
            <li>
                <a href="<?php echo base_url(); ?>price">
                    <span class="title">Price list</span>
                </a>
            </li>
        </ul>
    </li>

</ul>