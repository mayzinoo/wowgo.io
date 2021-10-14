<?php
$data["admindata"]=$this->db->get("admin")->row();
?>
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">                   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="header-top-wraper">
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-xs-3 col-sm-3" >
                                    <!-- Mobile Menu start -->
                                    <div class="mobile-menu-area">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="mobile-menu">
                                                        <nav id="dropdown">
                                                            <ul class="mobile-menu-nav">
                                                                <li><a data-toggle="collapse" data-target="#Charts" href="Admin/transaction">Transactions <span class="admin-project-icon nalika-icon nalika-down-arrow"></span></a>
                                                                </li>
                                                                <li><a data-toggle="collapse" data-target="#demo" href="Admin/history_time">Login History <span class="admin-project-icon nalika-icon nalika-down-arrow"></span></a>
                                                                </li>
                                                                <li><a data-toggle="collapse" data-target="#others" href="Admin/users">Users Management <span class="admin-project-icon nalika-icon nalika-down-arrow"></span></a>
                                                                </li>
                                                                <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="Admin/profit_losss">Personal Profit Loss <span class="admin-project-icon nalika-icon nalika-down-arrow"></span></a>
                                                                </li>
                                                                <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="#">Admin <span class="admin-project-icon nalika-icon nalika-down-arrow"></span></a>
                                                                    <ul id="demo" class="collapse dropdown-header-top">
                                                                        <li><a href="Admin/admin_profile">My Profile</a>
                                                                        </li>
                                                                        <li><a href="Admin/setting/<?php echo $admindata->id; ?>">Setting</a>
                                                                        </li>
                                                                        <li><a href="Admin/Logout" onclick="return confirm('Are you sure to exit?')">Log Out</a>
                                                                        </li>
                                                                        <li><?php echo $admindata->id; ?></li>
                                                                    </ul>
                                                                </li>
                                                               
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mobile Menu end -->
                                </div>     
                                <div class="col-lg-4 col-md-4 col-sm-9 col-xs-9 menu-title">
                                    <h3>WoWgo Ethereum Game</h3>
                                </div>                        
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                
                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
    														<!-- <i class="icon nalika-user"></i> -->
    														<span class="admin-name">Admin</span>
    														<i class="icon nalika-down-arrow nalika-angle-dw"></i>
    													</a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="Admin/admin_profile"><span class="icon nalika-user author-log-ic"></span> My Profile</a>
                                                        </li>
                                                        
                                                        <li><a href="Admin/setting"><span class="icon nalika-settings author-log-ic"></span> Settings</a>
                                                        </li>
                                                        <li><a href="Admin/Logout" onclick="return confirm('Are you sure to exit?')"><span class="icon nalika-unlocked author-log-ic"></span> Log Out</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
        </div>

