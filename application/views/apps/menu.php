<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul id="main-menu" class="main-menu">

    <!-- DASHBOARD -->
    <li>
        <a href="<?= admin_url('dashboard'); ?>">
            <i class="entypo-gauge"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <!-- Sale Managing -->
    <li class="accountings has-sub root-level">
        <a href="#">
            <i class="entypo-calendar"></i>
            <span>Accounting</span>
        </a>
        <ul>
            <li class="create_payments">
                <a  href="<?= admin_url('create_payment'); ?>">
                    <span><i class="entypo-dot"></i>Create Payment</span>
                </a>
            </li>
            <li class="payment_transactions">
                <a  href="<?= admin_url('payment_transaction'); ?>">
                    <span><i class="entypo-dot"></i>Payment Transaction</span>
                </a>
            </li>
        </ul>
    </li>
    <!-- Sale Managing -->
    <li class="<?php if($active=='sale'){ echo "opened active ";}?>
        has-sub root-level">
        <a href="#">
            <i class="entypo-calendar"></i>
            <span>Sale Managing</span>
        </a>
        <ul>
            <li <?php echo (empty($active)?'':$active=='sale'?' class="active"':'')?>>
                <a  href="<?= admin_url('sale'); ?>">
                    <span><i class="entypo-dot"></i>Sales </span>
                </a>
            </li>
        </ul>
    </li>
    <!-- Reservation -->
    <li class="<?php if($active=='reservation'){ echo "opened active ";}?>
        has-sub root-level">
        <a href="#">
            <i class="entypo-heart"></i>
            <span>Reservation</span>
        </a>
        <ul>
            <?php if($GP['reservation-index']){ ?>
                <li <?php echo (empty($active)?'':$active=='reservation'?' class="active"':'')?>>
                    <a  href="<?= admin_url('reservation'); ?>">
                        <span><i class="entypo-dot"></i>Reservation</span>
                    </a>
                </li>
                <li <?php echo (empty($active)?'':$active=='selected'?' class="active"':'')?>>
                    <a  href="<?= admin_url('reservation/selected'); ?>">
                        <span><i class="entypo-dot"></i>Selected</span>
                    </a>
                </li>
                <li <?php echo (empty($active)?'':$active=='appointment'?' class="active"':'')?>>
                    <a  href="<?= admin_url('reservation/appointment'); ?>">
                        <span><i class="entypo-calendar"></i></i>Appointment</span>
                    </a>
                </li>
                <li <?php echo (empty($active)?'':$active=='calendar'?' class="active"':'')?>>
                    <a  href="<?= admin_url('reservation/calendar'); ?>">
                        <span><i class="entypo-dot"></i>Calendar</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>

    <li class="clinics has-sub">
        <a href="#">
            <i class="entypo-newspaper"></i>
            <span>Clinic</span>
        </a>
        <ul>
            <li>
                <a href="<?= admin_url('statationary'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Medical Purchasing</span>
                </a>
            </li>
            <li>
                <a href="<?= admin_url('statationary'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Actual count</span>
                </a>
            </li>
            <li>
                <a href="<?= admin_url('statationary'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Patient tracking</span>
                </a>
            </li>
        </ul>
    </li>
    <!-- Miscellaneous -->
    <li class="stationarys has-sub">
        <a href="#">
            <i class="entypo-newspaper"></i>
            <span>Statationary</span>
        </a>
        <ul>
            <li class="purchases">
                <a href="<?= admin_url('purchase'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Purchase Request</span>
                </a>
            </li>
            <li class="receives">
                <a href="<?= admin_url('receive'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Receivable</span>
                </a>
            </li>
            <li class="departments">
                <a href="<?= admin_url('department'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Department</span>
                </a>
            </li>
            <li class="distributings">
                <a href="<?= admin_url('distributing'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Distributing</span>
                </a>
            </li>
            <li class="actual_stocks">
                <a href="<?= admin_url('actual_stock'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Actual stock</span>
                </a>
            </li>
        </ul>
    </li>
    <!-- Maintenance -->
    <li class="maintenance has-sub">
        <a href="#">
            <i class="entypo-tools"></i>
            <span>Maintenance</span>
        </a>
        <ul>
            <li class="Checkings">
                <a href="<?= admin_url('checkup'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Room Checking Up</span>
                </a>
            </li>
            <!-- Contacting -->
            <li class="contactings">
                <a href="<?= admin_url('contacting'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Contacting</span>
                </a>
            </li>
        </ul>
    </li>

    <?php if($GP['building-index']|$GP['floor-index']|$GP['room-index']|$GP['staying-index']|$GP['usage-index']){?>
    <li class="buildings has-sub root-level">
        <a href="#">
            <i class="entypo-home"></i>
            <span class="title">Building</span>
        </a>
        <ul>
            <?php if($GP['building-index']){?>
                <li class="manage_buildings">
                    <a href="<?= admin_url('building'); ?>">
                        <span><i class="entypo-dot"></i>Manage Building</span>
                    </a>
                </li>
            <?php } ?>
            <?php if($GP['floor-index']){?>
            <li class="floors">
                <a href="<?= admin_url('floor'); ?>">
                    <span><i class="entypo-dot"></i>Manage Floors</span>
                </a>
            </li>
            <?php } ?>
            <?php if($GP['room-index']){?>
            <li class="rooms">
                <a href="<?= admin_url('room'); ?>">
                    <span><i class="entypo-dot"></i>Manage Rooms</span>
                </a>
            </li>
            <?php } ?>
            <?php if($GP['staying-index']){?>
            <li class="stayings">
                <a href="<?= admin_url('staying'); ?>">
                    <span><i class="entypo-dot"></i>Manage Staying</span>
                </a>
            </li>
            <?php } ?>
            <?php if($GP['usage-index']){?>
            <li class="usages">
                <a href="<?= admin_url('usage'); ?>">
                    <span><i class="entypo-dot"></i>Manage Usage</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>

    <li class="settings has-sub root-level">
        <a href="#">
            <i class="entypo-cog"></i>
            <span class="title">Settings</span>
        </a>
        <ul>
            <?php if($GP['price-index']){?>
            <li class="prices">
                <a href="<?= admin_url('price'); ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Price list</span>
                </a>
            </li>
            <?php } ?>
            <?php if($GP['type-index']){?>
            <li class="types">
                <a href="<?= admin_url('type'); ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Type</span>
                </a>
            </li>
            <?php } ?>

            <li class="items">
                <a href="<?= admin_url('item'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Items</span>
                </a>
            </li>

            <li class="medical_items">
                <a href="<?= admin_url('statationary'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Medical Item</span>
                </a>
            </li>

            <li class="categories">
                <a href="<?= admin_url('category'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Categories</span>
                </a>
            </li>

             <li class="apartments">
                <a href="<?= admin_url('apartment'); ?>">
                    <i class="entypo-gauge"></i>
                    <span>Apartment</span>
                </a>
            </li>
            
            <li class="vendors">
                <a href="<?= admin_url('vendor'); ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Vendor</span>
                </a>
            </li>

            <li class="suppliers">
                <a href="<?= admin_url('supplier'); ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Supplier</span>
                </a>
            </li>

            <li class="rates">
                <a href="<?= admin_url('rate'); ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Rate</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="security has-sub root-level">
        <a href="#">
            <i class="entypo-key"></i>
            <span class="nav-label">Security</span>
        </a>
        <ul class="nav nav-second-level">
            <li class="<?php echo (empty($active)?'':$active=='auditrial'?' active':'')?>">
                <a href="<?= admin_url('auditrial'); ?>">
                    <i class="entypo-traffic-cone"></i>
                    <span>Auditrial</span>
                </a>
            </li>
            <li class="users">
                <a href="<?= admin_url('user'); ?>">
                    <i class="entypo-user"></i>
                    <span class="nav-label">User</span></a>
            </li>
            <li class="permissions">
                <a href="<?= admin_url('permission'); ?>">
                    <i class="entypo-lock"></i>
                    <span class="nav-label">Group Permission</span></a>
            </li>
        </ul>
    </li>
</ul>