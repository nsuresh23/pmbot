<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ url('/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <!-- Status -->
       <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div> -->

    <!-- search form (Optional) -->
   <!--  <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
          <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form> -->
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    
    <ul class="sidebar-menu">
      <li class="header">Manage WFH User & Group </li>
	  <li class="header">Manage In-House User </li>
<?php $sidebar_menu = Menu::get('MyNavBar')->active();
          if(!empty($sidebar_menu))
          {
            if($sidebar_menu->hasChildren())
              $submenu  = $sidebar_menu->children();
            else
              $submenu = Menu::get('MyNavBar')->whereParent($sidebar_menu->parent);
            foreach($submenu as $child)
            {
                $active_class ='';
                if($child->isActive)
                  $active_class = 'active';
                echo '<li class="'.$active_class.'"><a href="'.$child->url().'"><i class="fa fa-circle-o"></i><span>'.$child->title.'</span></a></li>';
            }
          }
       ?>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>