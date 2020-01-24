        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-code"></i>
                </div>
                <div class="sidebar-brand-text mx-3">CV Profolio</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <?php $menu = $this->user->getRoleMenu(); ?>
            <?php foreach ($menu as $m) : ?>
                <?php if ($kategori == $m['menu']) : ?>
                    <div class="sidebar-heading text-white"> <?= $m['menu']; ?> </div>
                <?php else : ?>
                    <div class="sidebar-heading"> <?= $m['menu']; ?> </div>
                <?php endif; ?>

                <!-- ---------------------------------------------------------------------------- -->
                <?php
                $menuId = $m['number'];
                $subMenuLooping = $this->user->getLoopingMenu($menuId);
                ?>
                <?php foreach ($subMenuLooping as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon']; ?>"></i>
                            <span><?= $sm['title']; ?></span></a>
                        </li>
                    <?php endforeach; ?>
                    <hr class="sidebar-divider mt-3">
                <?php endforeach; ?>

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
        </ul>
        <!-- End  of Sidebar -->