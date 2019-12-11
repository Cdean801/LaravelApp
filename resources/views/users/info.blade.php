@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="white/css/welcomepage.css" media="all" />
<link rel="stylesheet" type="text/css" href="white/css/bootstrap.min.css" media="all" />

@section('content')
<style>
   .ovrllay{
      height: 45% !important;
   }
   </style>
<body>
   <div class="bg-all">
      <div class="bg-banner-img clip-ellipse">
         <div class="ovrllay">

            <!-- Header_Area -->
            
            <!-- End Header_Area -->
            <!-- #banner start -->
            <section id="banner" class="pt-0">
               <div class="container ">
                  <div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                     <!-- #banner-text start -->
                     <div id="banner-text" class="col-md-12 text-c text-center ">
                        <h5 class="wow fadeInUp main-h" data-wow-delay="0.2s"
                           style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">Contact</h5>
                        <p class="banner-text wow fadeInUp main-h3" data-wow-delay="0.8s"
                           style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">No hours sank
                           into aggregating and cleaning data. No complex SQL queries required. Just the answers <br>
                           teams need to make smarter decisions, fast. Now, that's data-driven.</p>
                     </div>
                     <!-- /#banner-text End -->
                  </div>
               </div>
            </section>
         </div>
      </div>
      <!-- /#banner end -->
      <!-- #contact  Area start -->
      <section>
         <div class="container">
            <div class="row">
               <div class="col-lg-6">
                  <div class="section-heading left">
                     <h4>Let's Talk about Your Business</h4>
                  </div>
                  <div class="contact-form-box margin-30px-top">
                     <div class="no-margin-lr" id="success-contact-form" style="display: none;"></div>
                     <form id="contactForm" method="post" class="contact-form" action="sendemail.php">
                        <div class="row">
                           <div class="col-md-12">
                              <input type="text" class="medium-input" maxlength="50" placeholder="Name *"
                                 required="required" id="name" name="name"
                                 style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6">
                              <input type="email" class="medium-input" maxlength="70" placeholder="E-mail *"
                                 required="required" id="email" name="email">
                           </div>
                           <div class="col-xs-12 col-sm-6 col-md-6">
                              <input type="text" class="medium-input" maxlength="70" placeholder="Subject *"
                                 required="required" id="subject" name="subject">
                           </div>
                           <div class="col-md-12">
                              <textarea class="medium-textarea" rows="12" maxlength="1000" placeholder="Message *"
                                 required="required" id="message" name="message"></textarea>
                           </div>
                           <div class="col-md-12 sm-margin-30px-bottom">
                              <div class="top-contact wow fadeInRight text-left"
                                 style="visibility: visible; animation-name: fadeInRight;">
                                 <a type="submit" id="#services" href="#services"
                                    class="btn btn-primary wow fadeInUp  js-scroll-trigger" data-wow-delay="1s"
                                    style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">Send
                                    Message</a>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="contact-info-box padding-30px-left sm-no-padding">
                     <div class="row">
                        <div class="col-12">
                           <div class="contact-info-section no-padding-top margin-10px-top">
                              <h4>Get in Touch</h4>
                              <p> Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                 nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                 irure dolor in reprehenderit in voluptate velit esse consequat.</p>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="contact-info-section">
                              <h4>The Office</h4>
                              <ul class="list-style-1 no-margin-bottom">
                                 <li>
                                    <p><i class="fa fa-phone text-center"></i> <strong>Address:</strong> Regina ST,
                                       London, SK 8GH.</p>
                                 </li>
                                 <li>
                                    <p><i class="fa fa-globe text-center"></i> <strong>Phone:</strong> (+44) 123 456 789
                                    </p>
                                 </li>
                                 <li>
                                    <p><i class="fa fa-envelope text-center"></i> <strong>Email:</strong> <a
                                          href="javascript:void(0)" class="email_color_site">email@youradress.com</a>
                                    </p>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="contact-info-section border-none no-padding-bottom no-margin-bottom">
                              <h4>Business Hours</h4>
                              <ul class="list-style-2">
                                 <li>Monday - Friday - 9am to 5pm</li>
                                 <li>Saturday - 9am to 2pm</li>
                                 <li>Sunday - Closed</li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- #contact  Area End -->

      <!--#Our Partners start -->
      <div class="our_partners_area py-45">
         <div class="container">

            <!--#Our Partners assets/images start -->
            <div class="partners  pt-0 p0wow fadeInUp owl-carousel owl-theme owl-loaded">





              
            <!--#End Our Partners assets/images -->

         </div>
      </div>
      <!--#End Our Partners Area -->


      <!--#End contact-text  -->
      <!--#start Our testimonial Area -->
      <div class="our_partners_area bg-grediunt">
         <div class="book_now_aera ">
            <div class="container">
               <div class="row book_now">
                  <div class="col-md-5 booking_text">
                     <h4>Full insight into the customer journey.<br>
                        No SQL required.
                     </h4>
                     <p>Get started for free to see who your customers are, what they do and what keeps them coming
                        back.</p>
                  </div>
                  <div class="col-md-7 p0 book_bottun">
                     <div class="col-md-7">

                     </div>
                     <div class="col-md-5">
                        <div class="top-banner wow fadeInRight text-left"
                           style="visibility: hidden; animation-name: none;">
                           <a id="#services" href="contact.html" class="btn btn-primary wow fadeInUp  js-scroll-trigger"
                              data-wow-delay="1s"
                              style="visibility: hidden; animation-delay: 1s; animation-name: none;">CONTACT SALES</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--#End Our testimonial Area -->
      <!--#start Our footer Area -->
      <div class="our_footer_area">
         <div class="book_now_aera ">
            <div class="container">
               <div class="row book_now">
                  <div class="col-md-4">
                     <div class="">
                        <a class=" logo-biss" href="index.html"> <img src="white/images/logo_img.png"></a>
                     </div>
                     <p class="footer-h">It is a long established fact that a reader will be distracted by the readable
                        content of a page when looking at its layout.</p>
                     <div class="bigpixi-footer-social">
                        <a href="" target="_blank"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
                        <a href="" target="_blank"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>
                        <a href="" target="_blank"><i id="social-em" class="fa fa-instagram fa-3x social"></i></a>
                     </div>
                  </div>
                  <div class="col-md-1 ">
                  </div>
                  <div class="col-md-3">
                     <h2 class="footer-top">SOLUTIONS </h2>
                     <ul class="footer-menu">
                        <li><a href=""> SaaS </a></li>
                        <li><a href=""> Mobile </a> </li>
                        <li><a href="">Commerce </a> </li>
                        <li><a href=""> Gaming </a> </li>
                        <li><a href=""> Finance </a> </li>
                        <li><a href=""> Media </a></li>
                     </ul>
                  </div>
                  <div class="col-md-4">
                     <ul class="location">
                        <li class="footer-left-h"><i class="fa fa-map-marker"></i>505 Thornall St #301, Edison, <br>NJ
                           08837, USA</li>
                        <li class="footer-left-h"><i class="fa fa-phone"></i>Call Us <br>+1- 982-8-587 452
                           <br>+1- 982-8-587 452
                        </li>
                        <li class="footer-left-h"><i class="fa fa-envelope-o"></i>Email<br>
                           <a href=""> enquiry@demo.com </a><br><a href=""> enquiry@demo.com </a>
                        </li>
                        <p class="color-gray">
                           <a href="https://themewagon.com/theme_tag/free/">Free HTML5 Templates</a> distributed by <a
                              href="https://themewagon.com/">ThemeWagon</a>
                        </p>
                     </ul>
                  </div>
                  <div class="col-md-12">
                     <p class="color-gray"> <a href="https://www.navthemes.com/free-html-templates/">Free HTML
                           Template</a> by <a href="https://www.navthemes.com">NavThemes </a> </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--#End Our footer Area -->
      <!-- jQuery JS -->
      <script type="text/javascript" id="www-widgetapi-script"
         src="https://s.ytimg.com/yts/jsbin/www-widgetapi-vflXGCunz/www-widgetapi.js" async=""></script>
      <script src="https://www.youtube.com/player_api"></script>
      <script src="assets/jquery-1.12.0.min.js"></script>
      <script src="assets/vendors/popup/lightbox.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/bootstrap.min.js"></script>
      <!-- Animate JS -->
      <script src="assets/vendors/animate/wow.min.js"></script>

      <script src="assets/vendors/owl_carousel/owl.carousel.min.js"></script>

      <!-- Theme JS -->
      <script src="assets/theme.min.js"></script>

   </div>
</body>
@endsection