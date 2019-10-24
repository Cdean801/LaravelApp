<link href="{{ asset('css/front/shop/new-index.css')}}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Assistant' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<!-- @extends('welcome') -->
@section('title')
HOME - Frelii
@endsection
<!-- SlidesJS Required: -->
@section('content')


<!-- HOME -->
<!-- section -->
<div class="" style="">
  <!-- container -->
  <div class="">
    <!-- first banner -->
    <div class="row fsi-row-lg-level fsi-row-md-level image-background">
      <div class="green-background">
        <div class="row main-row-align">
          <div class="col-md-6 col-lg-6 col-sm-7">
            <div class="banner1-margin">
              <div class="banner1 banner1-padding">
                <iframe src="https://www.youtube.com/embed/3wyz-VTv5R0?feature=oembed" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="" name="fitvid0"></iframe>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-5">
            <div class="banner1-max-width">
              <div class="banner1-padding-top">
                <div class="banner1-margin-top-and-bottom">
                  <h2 class="fl-heading">
                    <span class="fl-heading-text">Use your DNA Blueprint to create your Health Destiny.</span>
                  </h2>
                </div>
              </div>
              <div class="banner-saperator">
                <div class="separator"></div>
              </div>
              <div class="left-right-margin">
                <p class="text-center"><span class="span-white-color font-size-26">AI + DNA = Nutrition Perfected</span></p>
              </div>
              <div class="banner-saperator2">
                <div class="separator"></div>
              </div>
              <div class="left-margin">
                <div class="fl-rich-text">
                  <p><span class="font-size-20"><span class="span-right-arrow-color">✓</span>&nbsp;<span class="span-white-color">Frélii has the health tools to make your life simpler.</span></span></p>
                  <p><span class="font-size-20"><span class="span-right-arrow-color">✓</span>&nbsp;<span class="span-white-color">Revolutionary AI technology built to find your unique nutrition and health needs.</span></span></p>
                  <p><span class="font-size-20"><span class="span-right-arrow-color">✓</span>&nbsp;<span class="span-white-color">Real science at the core of every tool and product.</span></span></p>
                  <p><span class="font-size-20"><span class="span-right-arrow-color">✓</span>&nbsp;<span class="span-white-color">Your body will thank you!</span></span></p>
                </div>
              </div>
              <div class="button-heading">
                <div class="text-center get-started-button-align first-banner-responsive-full-width-text-center">
                  <a href="{{ route('free.RegFormView') }}" target="_self" class="link-button-style" role="button">
                    <span class="btn-txt-style span-white-color">Try Now for FREE!!!</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Inner row Step-1 -->
    <!-- Inner row Step-1 Description-->
    <div class="row pricing-margin">
      <div class="col-md-2" >
      </div>
      <div class="col-md-8 text-center">
        <h2 class="price-heading price-margin-top">
          <span class="price-heading-text">Pricing</span>
        </h2>
      </div>
      <div class="col-md-2">
      </div>
    </div>
    <div class="row banner2-padding-bottom">
      <!-- <div class="col-md-3">

    </div> -->
    <!-- <div> -->
    <div class="col-md-6">
      <div class="banner-2-card-1">
        <div class="banner-2-card-background">
          <div class="">
            <h4 class="pricing-table-title">Standard</h4>
            <div class="pricing-table-price">
              FREE <span class="pricing-table-duration"></span>
            </div>
            <ul class="pricing-table-features">
              <li>✓ Health Goal Recommendations</li>
              <li>✓ Lifestyle and Family History Recommendations</li>
              <li>✓ Meal Planning</li>
              <li>✓ Hundreds of Recipes</li>
              <li>✓ Groceries Delivered to Your Door (where available)</li>
              <li>✓ Supplement Recommendations</li>
              <li>✓ Exercise Videos</li>
            </ul>
            <div>
              <div class="text-center">
                <a href="{{ route('free.RegFormView') }}" target="_self" class="button-style" role="button">
                  <span class="btn-txt-start span-white-color">START TODAY</span>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    <div class="col-md-6 card-margin-top">
      <div class="banner-2-card-2">
        <div class="banner-2-card-background">
          <div class="">
            <h4 class="pricing-table-title">Premium</h4>
            <div class="pricing-table-price">
              $9 <span class="pricing-table-duration">/Month</span>
            </div>
            <ul class="pricing-table-features">
              <li>✓ Everything in FREE Plan Plus..</li>
              <li>✓ Health DNA Analysis (23andMe, Ancestry)</li>
              <li>✓ Your Nutrigenomics (foods that make you thrive)</li>
              <li>✓ End the Guesswork of Eating Healthy</li>
              <li>✓ DNA based Supplement Recommendations</li>
              <li>✓ Discount on All Products</li>
              <li>✓ No Commitments, Cancel Anytime!!</li>
            </ul>
            <div>
              <div class="text-center">
                <a href="{{ route('register') }}" target="_self" class="button-style" role="button">
                  <span class="btn-txt-start span-white-color">START TODAY</span>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- </div> -->
    </div>

    <!-- <div class="col-md-3" >

  </div> -->
</div>

<!-- THIRD-BANNER -->
<div class="row fsi-row-lg-level fsi-row-md-level second-image-background">
  <div class="green-background">
    <div class="row banner-3-padding-top">
      <h2 class="feature-heading-text">
        <span class="fl-heading-text">Amazing Features</span>
      </h2>
    </div>
    <div class="row">
      <div class="feature-separator text-center"></div>
    </div>
    <div class="row mobile-bootom-margin">
      <div class="col-md-1">
      </div>
      <div class="col-md-4">
        <div class="dna-div">
          <div class="d-icon">
            <div class="icon-wrap">
              <span class="da-icon">
                <i class="fa fa-heart"></i>
              </span>

              <div id="d-icon-text" class="d-icon-text">
                <p><span class="general-font-size span-white-color">DNA+AI=Health Personalized</span></p><p><span class="span-content span-white-color">Knowing what your body needs is only half the battle, the other half is giving your body what it needs! We have all the tools to make living healthy easy!</span></p>			</div>
              </div>
            </div>
            <div class="banner-3-padding" >
              <div class="icon-wrap">
                <span class="da-icon">
                  <i class="fa fa-heart"></i>
                </span>

                <div id="d-icon-text" class="d-icon-text">
                  <p><span class="general-font-size span-white-color">DNA Based Meal Planning</span></p><p><span class="span-content span-white-color">All our meal plan's recommendations including recipes and ingredients are based on your genetics and your individual needs.</span></p>			</div>
                </div>
              </div>
              <div class="banner-3-padding">
                <div class="icon-wrap">
                  <span class="da-icon">
                    <i class="fa fa-child"></i>
                  </span>

                  <div id="d-icon-text" class="d-icon-text">
                    <p><span class="general-font-size span-white-color">At Home Exercise Videos</span></p><p><span class="span-content span-white-color">Our exercises are HIIT based trainings that work for all skill levels. Exercise from home, no expensive equipment required! </span></p>			</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 md-2">

              <div class="mobile-image">
                <div class="index1" style="padding-top: 20px">
                  <img class="fl-photo-img mobile-img wp-image-31981 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-296x600.png" alt="white-iphone-menu" itemprop="image" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="white-iphone-menu">
                </div>
              </div>
              <!-- <div class="mobile-image">
              <img class="fl-photo-img wp-image-31981 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-296x600.png" alt="white-iphone-menu" itemprop="image" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15180749/white-iphone-menu-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="white-iphone-menu">
            </div> -->
          </div>
          <div class="col-md-4">
            <div class="supplement-div">
              <div class="d-icon">
                <div class="icon-wrap">
                  <span class="da-icon">
                    <i class="fa fa-flask"></i>
                  </span>

                  <div id="d-icon-text" class="d-icon-text">
                    <p><span class="general-font-size span-white-color">Supplementation</span></p><p><span class="span-content span-white-color">Even with a close to perfect diet, you may be missing some essential nutrients that your body needs. We only recommend doctor grade supplements that will help your body thrive!</span></p>			</div>
                  </div>
                </div>
                <div class="banner-3-padding" >
                  <div class="icon-wrap">
                    <span class="da-icon">
                      <i class="fa fa-shopping-cart"></i>
                    </span>

                    <div id="d-icon-text" class="d-icon-text">
                      <p><span class="general-font-size span-white-color">Order Recipes/Groceries Online</span></p><p><span class="span-content span-white-color">All of our recipes are connected to Instacart and Amazon Fresh so you can order your food online and have it delivered to your door!</span></p>			</div>
                    </div>
                  </div>
                  <div class="banner-3-padding" >
                    <div class="icon-wrap">
                      <span class="da-icon">
                        <i class="fa fa-cogs"></i>
                      </span>

                      <div id="d-icon-text" class="d-icon-text">
                        <p><span class="general-font-size span-white-color">DNA Analysis</span></p><p><span class="span-content span-white-color">Your DNA is more than just where your ancestors came from. It provides valuable incite into your health blueprint and what you need to be your healthiest! </span></p>			</div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-md-1">
              </div> -->
            </div>
          </div>
        </div>
        <!-- END -->
        <div class="row container-6" style="background-color:white!important;padding-bottom:0; ">
          <div class="">
            <div class="row text-center" style="text-align: center;font-size: 36px;">
              <h2 class="service-heading-6">How it Works</h2>
              <div style="border-top: 2px solid #0a0900;filter: alpha(opacity = 100);opacity: 1;width: 11%;max-width: 100%;margin: auto;"></div>
            </div>
            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-8" style="padding: 20px;">
                <div class="row" style="margin-bottom: 35px;padding-top: 19px;">
                  <div class="col-sm-4 service-div">
                    <div class="row text-center">
                      <!-- <img class="service-image-1-6" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/03/20004845/Asset-2.png" alt="Asset-2" itemprop="image"> -->
                      <i class="fa fa-arrow-circle-up icon-style"></i>
                    </div>
                    <div class="row text-center row-6">
                      <h4 class="service-list-heading-6">
                        1. Submit your data
                      </h4>
                    </div>
                    <div class="row text-center row-6">
                      <!-- <p class="service-description-6"> -->
                      <p style="text-align: center;">
                        <span style="font-size: 16px;">Our AI "Navii" can accept data such as goals, current health concerns, family history, DNA and more!
                        </span>
                      </p>
                      <!-- </p> -->
                    </div>
                  </div>
                  <div class="col-sm-4 service-div">
                    <div class="row text-center" >
                      <img class="fl-photo-img wp-image-23246 size-shop_thumbnail shop_image" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-180x139.png" alt="" itemprop="image" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-180x139.png 180w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-150x116.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-300x232.png 300w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-768x593.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-600x463.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7-250x193.png 250w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/12180115/Navii7.png 793w" sizes="(max-width: 180px) 100vw, 180px">
                    </div>
                    <div class="row text-center row-6">
                      <h4 class="service-list-heading-6">
                        2. AI Analyzes Data
                      </h4>
                    </div>
                    <div class="row text-center row-6">
                      <p style="text-align: center;"><span style="font-size: 16px;">After you submit your data, it will be run through Navii and it will look at millions of interactions to find what is best for you.</span></p>
                      <!-- <p class="service-description-6">Access to discounted blood labs and genetic evaluations. Proprietary A.I "NAVII" uses your data to further customize your nutrition, fitness, and supplement recommendations.</p> -->
                    </div>
                  </div>
                  <div class="col-sm-4 service-div">
                    <div class="row text-center">
                      <i class="fa fa-check-circle icon-style"></i>
                      <!-- <img class="service-image-3-6" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/03/20004844/Asset-3.png" alt="Asset-3" itemprop="image" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/03/20004844/Asset-3.png 101w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/03/20004844/Asset-3-92x150.png 92w" sizes="(max-width: 101px) 100vw, 101px"> -->
                    </div>
                    <!-- <div class="row text-center row-6"><h4 class="service-list-heading-6">Supplement Reccomendations</h4></div> -->
                    <div class="row text-center row-6">
                      <h4 class="service-list-heading-6">
                        3. Get Results
                      </h4>
                    </div>
                    <div class="row text-center row-6">
                      <p style="text-align: center;"><span style="font-size: 16px;">
                        After analysis Navii builds your food, exercise and nutritional profiles, so you can find what will make you thrive!
                      </span>
                    </p>
                    <!-- <p class="service-description-6">"NAVII" analyzes your genetics, labs, and questionnaire to give you the most accurate high potency supplement recommendations on the market.</p> -->
                  </div>
                </div>
              </div>
              <div class="fl-module fl-module-button fl-node-5b2aaa22be549" data-node="5b2aaa22be549" style="margin-bottom: 33px">
                <div class="fl-module-content fl-node-content">
                  <div class="fl-button-wrap fl-button-width-auto text-center">
                    <a href="{{'register-details'}}"  target="_self" class="genetics-button-style" role="button">
                      <span class="btn-txt-style" style="color:white!important;">Start Now!</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-2"></div>
          </div>
          <div class="row">
            <!-- Inner row Step-1 -->
            <!-- Inner row Step-1 Description-->
            <div class="row fsi-row-lg-level fsi-row-md-level" style="background-color: rgba(244,244,244, 1);">
              <div class="col-md-6 homeDietStepOneImage" >
                <!-- <img src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/07013016/outdoor-lunch-600x400.jpg" style="width: 100%;" alt="Fist-Weight"> -->
                <div class="image1-div"></div>
              </div>
              <div class="col-md-6" style="background-color: rgba(244,244,244, 1);">
                <div class="fl-col-content fl-node-content">
                  <div class="" >
                    <div class="heading-div">
                      <h2 class="heading-h2">
                        <span >The Worlds most advanced Meal Planner</span>
                      </h2>
                    </div>
                  </div>
                  <div class="fl-module fl-module-rich-text fl-node-5b292c9add5a2" data-node="5b292c9add5a2">
                    <div class="content-sub-div">
                      <div class="fl-rich-text">
                        <p><span  class="span-content">Our meal planner was designed to work for those with a busy lifestyle. That means less time spent trying to figure out what to eat and more time with your friends and family. All of our meal plan features were built for you to add time to do what you want. Features include:</span></p>
                        <p><span  class="span-content">✓ Personalized Recipes</span></p>
                        <p><span  class="span-content">✓ Shopping Lists</span></p>
                        <p><span  class="span-content">✓ Grocery/Recipe ingredient ordering online</span></p>
                        <p><span  class="span-content">✓ Recipes Customizable to number of servings</span></p>
                        <p><span class="span-content"> ✓ Customizable to lifestyle (Vegan, Vegetarian, Pescatarian, etc.)&nbsp;</span></p>
                        <p><span  class="span-content">✓ Diet Preferences (Gluten Free, Nut Free, Red Meat Free, etc.)</span></p>
                      </div>
                    </div>
                  </div>
                  <div class="fl-module fl-module-button fl-node-5b2aa9385de6b" data-node="5b2aa9385de6b" style="margin-bottom:20px;">
                    <div class="fl-module-content fl-node-content text-center">
                      <div class="" >
                        <a href="{{url('nutrition-planner')}}" target="_self" itemprop="url" class="genetics-button-style" role="button" style="color:white!important;">
                          <span class="btn-txt-style">See Nutrition Planner</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row fsi-row-lg-level fsi-row-md-level" style="background-color: rgba(244,244,244, 1);">
              <div class="wrapper col-md-12" style="padding-left:0;padding-right:0;">
                <div class="col-md-6" style="background-color: rgba(244,244,244, 1);">
                  <div class="fl-col-content fl-node-content">
                    <div class="" >
                      <div class="heading-div">
                        <h2 class="heading-h2">
                          <span class="">It's OK to Relax, We've got you covered</span>
                        </h2>
                      </div>
                    </div>
                    <div class="fl-module fl-module-rich-text fl-node-5b292c9add5a2">
                      <div class="content-sub-div">
                        <div class="fl-rich-text">
                          <p><span class="span-content">Your time is valuable and at Frélii we want you to have as much free time as possible. That means more time at the beach, more time with your family and more time doing the things you love.</span></p>
                          <p><span class="span-content">✓ Take the Guess Work Out of what You Eat&nbsp;&nbsp;</span></p>
                          <p><span class="span-content">✓ Quick Recipes</span></p>
                          <p><span class="span-content">✓ 15 minutes or less HIIT Workouts</span></p>
                          <p><span class="span-content">✓ Skip the Grocery Store and Order Your Food Online</span></p>
                          <p><span class="span-content">✓ Instant DNA Analysis</span></p>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-md-6 homeDietStepOneImage main-image2-div" >
                  <div class="image2-div"></div>
                  <!-- <img src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/04/18030729/yoga-600x599.png" style="width:100%"alt="Fist-Weight"> -->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Start Trial Free ENds Here -->

      <div class="row fsi-row-lg-level fsi-row-md-level third-image-background">
        <div class="flip-background">
          <div style="padding-top:30px;padding-bottom:30px">
            <div class="row">
              <h2 class="feature-heading-text">
                <span class="fl-heading-text">Frélii In Action</span>
              </h2>
            </div>
            <div class="row" style="margin-bottom: 20px;">
              <div class="feature-separator text-center"></div>
            </div>
            <div class="row mobile-bootom-margin">
              <div class="col-md-3 text-center">
                <h2 class="meal-heading">
                  <span class="fl-heading-text">Meal Planner</span>
                </h2>
                <img class="mobile-img-2 fl-photo-img wp-image-32032 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-296x600.png" alt="iphone-meal-plan" itemprop="image" height="600" width="296" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15224855/iphone-meal-plan-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="iphone-meal-plan">
              </div>
              <div class="col-md-3 text-center">
                <h2 class="recipe-heading">
                  <span class="fl-heading-text">Recipes</span>
                </h2>
                <img class="mobile-img-2 fl-photo-img wp-image-32033 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-296x600.png" alt="iphone-recipe" itemprop="image" height="600" width="296" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225320/iphone-recipe-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="iphone-recipe">
              </div>

              <div class="col-md-3 text-center">
                <h2 class="DNA-heading">
                  <span class="fl-heading-text">DNA Findings</span>
                </h2>
                <img class="mobile-img-2 fl-photo-img wp-image-32034 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-296x600.png" alt="iphone-dna" itemprop="image" height="600" width="296" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225547/iphone-dna-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="iphone-dna">
              </div>
              <div class="col-md-3 text-center">
                <h2 class="health-heading">
                  <span class="fl-heading-text">Health Concerns</span>
                </h2>
                <img class="mobile-img-2 fl-photo-img wp-image-32035 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-296x600.png" alt="iphone-health-hazards" itemprop="image" height="600" width="296" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15225936/iphone-health-hazards-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="iphone-health-hazards">
              </div>
              <!-- <div class="col-md-1">
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="padding-top:30px;padding-bottom:30px">
      <div class="col-md-6">
        <div class="mob-view">
          <div class="mob-view-txt">
            <div class="card3 text-center">
              <img class="fl-photo-img wp-image-31907 size-shop_single" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-296x600.png" alt="iphone-member-home" itemprop="image" height="600" width="296" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-296x600.png 296w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-74x150.png 74w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-148x300.png 148w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-768x1556.png 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-505x1024.png 505w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-150x304.png 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-600x1216.png 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-89x180.png 89w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/14231217/iphone-member-home-123x250.png 123w" sizes="(max-width: 296px) 100vw, 296px" title="iphone-member-home">
            </div>

          </div>

        </div>
      </div>
      <div class="col-md-6 card-margin-top">
        <div class="ai-max-width">
          <div class="mob-view-txt">
            <div class="mob-margin">
              <h2 class="ai-heading">
                <span class="fl-heading-text black-color">AI is the Future of Health and Nutrition.</span>
              </h2>
            </div>

            <div class="ai-separator"></div>
            <p style="margin-top:20px;"><span style="font-size: 16px;">If eating right wasn't hard enough, we have recently discovered that "eating right" changes from person to person. Some need a diet that consists of an abundance of fruits and vegetables, while others thrive on healthy proteins and fats.&nbsp; Our AI takes it a step further and builds nutrition plans not only around the foods that your body thrives on but also takes preventative measures to conditions you may be genetically prone to.&nbsp; Our AI was built to find whats perfect for you! Including:</span></p>
            <ul style="list-style: disc;padding-left: 41px;">
              <li class="li-padding"><span class="span-content">Foods/exercises/supplements proven to help</span></li>
              <li class="li-padding"><span class="span-content">Root causes of conditions/ailments</span></li>
              <li class="li-padding"><span class="span-content">Potential health risks that are preventable</span></li>
              <li class="li-padding"><span class="span-content">Possible allergies</span></li>
              <li class="li-padding"><span class="span-content">Many many more!</span></li>
            </ul>
            <p><span style="font-size: 16px; color: #000000;">(DNA analysis is compatible with both 23andMe and Ancestry DNA data!)</span></p>
            <div class="button-heading">
              <div class="text-center get-started-button-align first-banner-responsive-full-width-text-center">
                <a href="{{url('dna-analysis')}}" target="_self" itemprop="url" class="link-button-style" role="button">
                  <span class="btn-txt-style span-white-color">Learn about DNA Analysis</span>
                </a>
              </div>
            </div>
            <div class="button-connect-heading">
              <div class="text-center get-started-button-align first-banner-responsive-full-width-text-center">
                <a href="{{url('register-details')}}" target="_self" itemprop="url" class="genetics-button-style" role="button">
                  <span class="btn-txt-style span-white-color">Connect My Genetics</span>
                </a>
              </div>
            </div>
          </div>

        </div>
        <!-- </div> -->
      </div>
    </div>
    <!-- flip start -->


    <div class="row fsi-row-lg-level fsi-row-md-level fourth-image-background">
      <div class="flip-background">
        <div style="padding-top:46px;padding-bottom:46px">
          <div class="row" style="padding-bottom: 18px;">
            <h2 class="feature-heading-text flip-text-max-width">
              <span class="fl-heading-text">See What Frélii Users Have To Say</span>
            </h2>
          </div>
          <div class="row">

            <div class="col-md-4">
              <div class="scene scene--card">
                <div class="flip">
                  <div class="card__face card__face--front"></div>
                  <div class="card__face card__face--back"><p><span style="font-size: 18px; color: #ffffff;">"Frélii has made living with Hashimoto's Thyroiditis easy! I love knowing that I'm eating the food that my body needs."</span></p></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="scene scene--card1">
                <div class="flip-img1">
                  <div class="card__face card__face--front1"></div>
                  <div class="card__face card__face--back"><p><span style="font-size: 18px; color: #ffffff;">"Frélii has made cooking healthy for my family easy and I love being able to order all my groceries from the website!"</span></p></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="scene scene--card2" style="margin-bottom:unset !important">
                <div class="flip-img2">
                  <div class="card__face card__face--front2"></div>
                  <div class="card__face card__face--back"><p><span style="font-size: 18px; color: #ffffff;">"I was frequently being forgetful and as a lawyer I need to be sharp.&nbsp; Frélii has helped me feel as sharp as I felt in my 20's."</span></p></div>
                </div>
              </div>
            </div>
          </div>
          <div class="button-heading">
            <div class="text-center get-started-button-align first-banner-responsive-full-width-text-center">
              <a href="{{'register-details'}}" target="_self" class="link-button-style" role="button">
                <span class="btn-txt-style span-white-color">Become a Success Story!</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- flip end -->

    <div style="padding-top:30px;padding-bottom:30px">
      <div class="row">
        <h2 class="price-heading">
          <span class="fl-heading-text black-color">Meet Our Executive Team</span>
        </h2>
      </div>
      <div class="row" style="margin-bottom: 10px;">
        <div class="meet-separator text-center black-color"></div>
      </div>
      <p style="text-align: center;">Frélii's executive team consists of industry leaders in each of their respective fields, with more than 100 accumulative years in the fields of Genetics, Medicine, Technology, Law and Marketing.</p>
      <div class="row mobile-bootom-margin" style="padding-top:60px;">
        <div class="col-md-3">
          <div class="meet-max-width">

            <div class="text-center">
              <img class="fl-photo-img img-circle wp-image-32037 size-shop_catalog" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-250x250.jpeg" alt="ian" itemprop="image" height="250" width="250" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-250x250.jpeg 250w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-150x150.jpeg 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-300x300.jpeg 300w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-180x180.jpeg 180w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-39x39.jpeg 39w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-18x18.jpeg 18w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian-25x25.jpeg 25w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234352/ian.jpeg 360w" sizes="(max-width: 250px) 100vw, 250px" title="ian">
            </div>
            <h3 class="general-font-size text-center" style="margin-bottom:0px !important">
              <span class="fl-heading-text text-center black-color">Ian Jenkins</span>
            </h3>
            <p class="text-center">Chief Executive Officer</p>
            <p style="padding:inherit;"><span style="color: #000000;text-align:left !important;">Ian is an International Business professional with a large resume in genetics and related fields.</span></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="meet-max-width">
            <div class="text-center">
              <img class="fl-photo-img img-circle wp-image-32038 size-shop_catalog" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-250x250.jpg" alt="jayson_bws_400x400" itemprop="image" height="250" width="250" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-250x250.jpg 250w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-150x150.jpg 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-300x300.jpg 300w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-180x180.jpg 180w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-39x39.jpg 39w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-18x18.jpg 18w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400-25x25.jpg 25w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15234952/jayson_bws_400x400.jpg 400w" sizes="(max-width: 250px) 100vw, 250px" title="jayson_bws_400x400">
            </div>
            <h3 class="general-font-size text-center" style="margin-bottom:0px !important">
              <span class="fl-heading-text text-center black-color">Jayson Uffens</span>
            </h3>
            <p class="text-center">Chief Technical Officer</p>
            <p style="padding:inherit;"><span style="color: #000000;text-align:left !important;">Jason is Technology Engineering executive who has served as a high level decision maker for multiple companies including GrubHub.</span></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="meet-max-width">

            <div class="text-center">
              <img class="fl-photo-img img-circle wp-image-32039 size-shop_catalog" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-250x250.jpg" alt="hans-and-wife" itemprop="image" height="250" width="250" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-250x250.jpg 250w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-150x150.jpg 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-300x300.jpg 300w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-768x768.jpg 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-1024x1024.jpg 1024w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-600x600.jpg 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-180x180.jpg 180w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-39x39.jpg 39w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-18x18.jpg 18w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife-25x25.jpg 25w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/15235532/hans-and-wife.jpg 1536w" sizes="(max-width: 250px) 100vw, 250px" title="hans-and-wife">
            </div>
            <h3 class="general-font-size text-center" style="margin-bottom:0px !important">
              <span class="fl-heading-text text-center black-color">Hans Jenkins</span>
            </h3>
            <p class="text-center">Chief Medical Officer</p>
            <p style="padding:inherit;"><span style="color: #000000;text-align:left !important;">Hans is a quadruple board certified Medical Doctor who obsesses over positive patient outcomes.</span></p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="meet-max-width">
            <div class="text-center">
              <img class="fl-photo-img img-circle wp-image-32042 size-shop_catalog" src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-250x250.jpg" alt="seth-ropeswing" itemprop="image" height="250" width="250" srcset="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-250x250.jpg 250w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-150x150.jpg 150w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-300x300.jpg 300w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-768x769.jpg 768w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-1024x1024.jpg 1024w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-600x600.jpg 600w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-180x180.jpg 180w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-39x39.jpg 39w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-18x18.jpg 18w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing-25x25.jpg 25w, https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2018/06/16001106/seth-ropeswing.jpg 1101w" sizes="(max-width: 250px) 100vw, 250px" title="seth-ropeswing">
            </div>
            <h3 class="general-font-size text-center" style="margin-bottom:0px !important">
              <span class="fl-heading-text text-center black-color">Seth Jones</span>
            </h3>
            <p class="text-center">Chief Marketing Officer</p>
            <p style="padding:inherit;"><span style="color: #000000;text-align:left !important;">Seth is a digital and viral marketing guru whose projects have amassed over 2 billion views globally.</span></p>
          </div>
        </div>
      </div>
    </div>

    <div class="row homeDietStepOneImage" style="padding-top:40px !important;padding-bottom:40px!important">
      <div class="col-md-6">
        <div class="pri-max-width-1">
          <div class="mob-view-txt">
            <div class="" style="margin-top:16px;">
              <h2 class="price-heading text-left">
                <span class="fl-heading-text black-color">Your Privacy Is Our Policy</span>
              </h2>
            </div>
            <p style="margin-top:20px;"><span style="font-size: 16px;">We believe in personal privacy. Our website is 100% HIPAA compliant.  At Frélii we don't sell any of your information to third parties and we have Amazon grade securities to keep your information safe and secure. </span></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 pri-top-margin">
        <div class="pri-max-width-2">
          <div class="mob-view-txt">
            <div class="card3 text-center">
              <div class="fl-icon-wrap">
                <span class="fl-icon">
                  <i class="fa fa-address-card-o"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>

</div>
<!-- /Section -->
<script>
var flip = document.querySelector('.flip');
var flip1 = document.querySelector('.flip-img1');
var flip2 = document.querySelector('.flip-img2');

flip.addEventListener( 'mouseover', function() {
  flip.classList.toggle('is-flipped');
});
flip.addEventListener( 'mouseout', function() {
  flip.classList.toggle('is-flipped');
});
flip1.addEventListener( 'mouseover', function() {
  flip1.classList.toggle('is-flipped1');
});
flip1.addEventListener( 'mouseout', function() {
  flip1.classList.toggle('is-flipped1');
});
flip2.addEventListener( 'mouseover', function() {
  flip2.classList.toggle('is-flipped2');
});
flip2.addEventListener( 'mouseout', function() {
  flip2.classList.toggle('is-flipped2');
});
</script>
@endsection
