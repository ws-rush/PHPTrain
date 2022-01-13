<!DOCTYPE html>
<html dir=rtl lang=ar>

<head>
    <meta charset=utf-8>
    <title></title>
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <meta name=apple-mobile-web-app-capable content=yes>
    <meta name=keywords content="وظائف اليمن, وظائف فى اليمن, وظائف شاغرة فى اليمن, توظيف اليمن, شركات توظيف اليمن , وظائف جرائد اليمن , فرص عمل فى اليمن , وظائف الرياض , وظائف جدة , وظائف مكة, وظائف المدينة, وظائف الحكومة اليمن , وظائف نسائية , وظائف لليمنيين">
    <meta name=description content="أحصل على وظيفة الآن فى اليمن و إنضم إلى الألاف ممن حصلوا على الوظائف من خلال موقع وظائف . موقع وظائف يجمع لك كل الوظائف من الانترنت والصحف الرسمية من اليمن فى مكان واحد">
    <meta content=103208286381727 property="fb:app_id>" <meta name=msapplication-TileColor content=#2d89ef>
    <meta name=msapplication-config content=//cloudfront.tankeeb.com/tanqeeb_2020/img/browserconfig.xml>
    <meta name=theme-color content=#ffffff>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        .sf-hidden {
            display: none !important
        }
    </style>
</head>

<body class=rtl>
    <div class=app style=height:auto!important;min-height:0px!important>
        <?php include "views/header.php" ?>
        <div id=site-content style=height:auto!important>
            <div class=mt-8 style=height:auto!important>
                <div class=container style=height:auto!important>
                    <div class=row style=height:auto!important>
                        <div class=col-lg-12> </div>
                        <div class=col-lg-2> </div>
                        <div class=col-lg-6 style=height:auto!important>
                            <h1 class="fs-22-md fs-18 pb-1 font-weight-extrabold text-dark d-none d-lg-block"><?php echo "$search"; ?></h1>
                            <div class=toggle-loading id=jobs_list style=height:auto!important>
                                <?php
                                echo json_encode($jobs) . "<br>";
                                foreach ($job as $jobs)
                                    echo "<div class='card card-list shadow my-4' style='height:auto!important;box-shadow: 0 10px 15px rgba(0,0,0,.1) !important;margin-top: 20px !important;margin-bottom: 20px !important;display: flex;position: relative;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 0 solid rgba(0,0,0,.125);border-radius: .25rem;'>
                                    <div class='card-body' style='flex: 1 1 auto;min-height: 1px;padding: 30px;padding-top: 20px;'>
                                        <a class='card-list-item card-list-item-hover px-3 px-lg-6 py-6 py-lg-4 ' href='jobs.php' style='text-decoration: none;color: #000;background-color: transparent;'>
                                            <div class='d-flex justify-content-between'>
                                                <div class='w-100'>
                                                    <div class='mb-4'>
                                                        <h5 class='mb-2 hover-title fs-16 fs-18-lg'>$job[title]</h5>
                                                        <p class='h10 text-secondary mb-0'> <span class='pr-2 pb-1 d-block d-lg-inline-block'><i class='fas fa-map-marker-alt mr-2'></i>$job[address]</span> <br> <span class='pr-2 pb-1 d-block d-lg-inline-block'><i class='fas fa-calendar mr-2'></i>اليوم</span> </p>
                                                    </div>
                                                    <div class='mb-4 text-primary-2 h7'> مطلوب مهندس او مهندسه حديثه التخرج للعمل بمكتب طباعه في سموحه بجوار فاروس يجيد او تجيد استخدام...</div>
                                                    <div class='d-flex align-items-center'>
                                                        <p class='mb-0 text-warning h7 font-weight-semibold mr-3'>تقديم</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>";
                                ?>
                            </div>
                        </div>
                        <div class=col-lg-4 style=height:auto!important>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=hs-dummy-scrollbar-size>
        <div style="height:200%;width:200%;margin:10px 0"></div>
    </div><ins class="adsbygoogle adsbygoogle-noablate" style=display:none!important data-adsbygoogle-status=done></ins><iframe id=google_osd_static_frame_4444374350320 name=google_osd_static_frame style=display:none;width:0px;height:0px></iframe><iframe id=google_esf name=google_esf style=display:none data-ad-client=ca-pub-5830353981649254></iframe>