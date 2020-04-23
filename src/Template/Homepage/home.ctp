<?php /*
<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="/"><img src="/admin-assets/img/logo.png" alt=""></a>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <div class="col-lg-10"></div>
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item top"><a href="/admin" class="tickets_btn"><?= __('Admin panel') ?></a></li>
            </ul>
          </div> 
        </div>
      </nav>
    </div>
</header>
        <!--================Header Menu Area =================-->
*/ ?>
        <!--================Home Banner Area =================-->
<section class="home_banner_area">
    <div class="banner_inner">
      <div class="container">
        <div class="row">
          <?php /*
          <div class="col-lg-5">
            <div class="banner_content">
              <h2><?= h($company->name) ?></h2>
              <h3><i class="lnr lnr-user"></i><?= ' ' . $countEmployees . __(' employees') ?></h3>
            </div>
          </div>*/ ?>
          <div class="col-lg-7">
            <div class="home_left_img">
              <img class="img-fluid" src="/homepage/img/home-left-1.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
        <!--================End Home Banner Area =================-->
<?php /*
<!--================Work Area =================-->
<section class="work_area p_120">
  <div class="container">
    <div class="main_title">
      <h2><?= __('Contact') ?></h2>
    </div>
    <div class="work_inner row">
      <div class="col-lg-4">
        <div class="work_item">
          <i class="lnr lnr-phone-handset"></i>
              <p><?= __('Phone: ') . h($company->phone_number) ?></p>
              <p><?= __('Fax: ') . h($company->fax) ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="work_item">
          <i class="lnr lnr-map-marker"></i>
          <p><#?= h($company->address) ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="work_item">
          <i class="lnr lnr-link"></i>
          <p><?= h($company->email) ?></p>
          <p><?= h($company->web) ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
        <!--================End Work Area =================-->
*/ ?>