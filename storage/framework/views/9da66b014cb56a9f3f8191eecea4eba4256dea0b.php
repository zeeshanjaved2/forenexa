<div class="sidebar-menu flex-between">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>
        <div class="sidebar-logo">
            <a class="sidebar-logo__link" href="<?php echo e(route('home')); ?>"><img src="<?php echo e(siteLogo()); ?>" alt="site logo"></a>
        </div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link" href="<?php echo e(route('user.home')); ?>">
                    <span class="icon"><i class="las la-tachometer-alt"></i></span>
                    <span class="text"><?php echo app('translator')->get('Dashboard'); ?></span>
                </a>
            </li>
            <li class="sidebar-menu-list__item has-dropdown <?php echo e(menuActive('user.deposit*')); ?>">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-wallet"></i>
                   </span>
                    <span class="text"> <?php echo app('translator')->get('Deposit'); ?> </span>
                </a>
                <div class="sidebar-submenu <?php echo e(menuActive('user.deposit*')); ?>">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  <?php echo e(menuActive('user.deposit.index')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.deposit.index')); ?>">
                                <span class="text">  <?php echo app('translator')->get('Deposit Now'); ?> </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.deposit.history')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.deposit.history')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Deposit History'); ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown <?php echo e(menuActive('user.withdraw*')); ?>">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-money-check"></i>
                   </span>
                    <span class="text"> <?php echo app('translator')->get('Withdraw'); ?> </span>
                </a>
                <div class="sidebar-submenu <?php echo e(menuActive('user.withdraw*')); ?>">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  <?php echo e(menuActive('user.withdraw')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.withdraw')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Withdraw Now'); ?> </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.withdraw.history')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.withdraw.history')); ?>">
                                <span class="text">  <?php echo app('translator')->get('Withdraw History'); ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown <?php echo e(menuActive(['user.commissions','user.referred'])); ?>">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-gift"></i>
                   </span>
                    <span class="text"> <?php echo app('translator')->get('Referral'); ?> </span>
                </a>
                <div class="sidebar-submenu <?php echo e(menuActive(['user.commissions','user.referred','user.referredBC'])); ?>" >
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  <?php echo e(menuActive('user.commissions')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.commissions')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Commissions'); ?> </span>
                            </a>
                        </li>

                        <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.referred')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.referred')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Direct Members'); ?> </span>
                            </a>
                        </li>

                        <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.referredBC')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('user.referredBC')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Total Team'); ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item <?php echo e(menuActive('user.transactions')); ?>">
                <a class="sidebar-menu-list__link" href="<?php echo e(route('user.transactions')); ?>">
                    <span class="icon">
                        <i class="las la-money-bill"></i>
                    </span>
                    <span class="text"><?php echo app('translator')->get('Transactions'); ?></span>
                </a>
            </li>
            <?php if($general->balance_transfer): ?>
            <li class="sidebar-menu-list__item <?php echo e(menuActive('user.transfer.balance')); ?>">
                <a class="sidebar-menu-list__link" href="<?php echo e(route('user.transfer.balance')); ?>">
                    <span class="icon">
                        <i class="las la-credit-card"></i>
                    </span>
                    <span class="text"><?php echo app('translator')->get('Balance Transfer'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <li class="sidebar-menu-list__item has-dropdown <?php echo e(menuActive('ticket*')); ?>">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-question-circle"></i>
                   </span>
                    <span class="text"> <?php echo app('translator')->get('Help & Support'); ?> </span>
                </a>
                <div class="sidebar-submenu <?php echo e(menuActive('ticket*')); ?>">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  <?php echo e(menuActive('ticket.index')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('ticket.index')); ?>">
                                <span class="text"> <?php echo app('translator')->get('Support Ticket'); ?> </span>
                            </a>
                        </li>

                        <li class="sidebar-submenu-list__item <?php echo e(menuActive('ticket.open')); ?>">
                            <a class="sidebar-submenu-list__link" href="<?php echo e(route('ticket.open')); ?>">
                                <span class="text"> <?php echo app('translator')->get('New Ticket'); ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link" href="<?php echo e(route('user.logout')); ?>">
                    <span class="icon"><i class="las la-sign-out-alt"></i></span>
                    <span class="text"><?php echo app('translator')->get('Logout'); ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-bottom">
        <div class="sidebar-bottom__btn">
            <?php echo app('translator')->get('Copyright'); ?> &copy; <?php echo e(date('Y')); ?>. <?php echo app('translator')->get('All Rights Reserved By'); ?> <a class="t-link" href="<?php echo e(route('home')); ?>"><?php echo e(__($general->site_name)); ?></a>
        </div>
    </div>
</div>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/partials/dashboard_sidebar.blade.php ENDPATH**/ ?>