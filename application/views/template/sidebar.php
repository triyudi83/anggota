<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?= $this->session->userdata('name') ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <!-- <li class="header">MAIN NAVIGATION</li> -->

      <li>
        <a href="<?php echo site_url('Welcome'); ?>">
          <i class="fa fa-book"></i> <span>Dashboard</span></a>
      </li>
      <?php if (count($menu) != 0) {
        foreach ($menu as $menu) {
          $idmenus = $menu->id_menu; ?>
          <li class="treeview <?php if ($katMenu == $menu->menu) {
                                echo 'active';
                              } ?>">
            <a href="#">
              <i class="<?php echo $menu->icon ?>"></i>
              <span><?php echo $menu->menu ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php
              // $result_array = $codes->result_array();
              // $results = array();
              // $today = time();
              foreach ($submenu->result_array() as $row) {
                if ($row['id_menus'] == $idmenus) {
              ?>
                  <li <?php if ($activeMenu == $row['submenu']) {
                        echo 'class="active"';
                      } ?> style="width: auto; margin-right: 6px;">
                    <a href="<?php echo site_url($row['linksubmenu']); ?>">
                      <i class="fa fa-circle"></i> <span><?php echo $row['submenu'] ?></span>
                    </a>
                  </li>
              <?php }
              } ?>
            </ul>
          </li>
        <?php } ?>
      <?php } ?>
      <li><a href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>