<!DOCTYPE html>
<html lang="fa" class="js">
<head>
    <meta charset="utf-8"/>
    <meta name="author" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png"/>
    <!-- Page Title  -->
    <title>خطای 404 | {{config('property.app_name')}}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('template/assets/css/dashlite.rtl.css')}}"/>
    <link id="skin-default" rel="stylesheet" href="{{asset('template/assets/css/theme.css')}}"/>
</head>

<body class="has-rtl nk-body ui-rounder npc-general pg-error" dir="rtl">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content">
                <div class="nk-block nk-block-middle wide-xs mx-auto">
                    <div class="nk-block-content nk-error-ld text-center">
                        <h1 class="nk-error-head">429</h1>
                        <h3 class="nk-error-title text-danger">تلاش بیش از حد مجاز !</h3>
                        <p class="nk-error-text text-danger">
                            امکان تلاش دوباره برای شما فراهم نیست!  دقایقی بعد دوباره امتحان کنید
                        </p>
                        <a href="{{route('page.home')}}" class="btn btn-lg btn-primary mt-2">بازگشت به صفحه اصلی</a>
                    </div>
                </div>
                <!-- .nk-block -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="{{asset('template/assets/js/bundle.js')}}"></script>
<script src="{{asset('template/assets/js/scripts.js')}}"></script>
</body>
</html>
