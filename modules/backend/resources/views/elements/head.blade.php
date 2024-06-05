<!-- Basic Page Info -->
<meta charset="utf-8" />
@if (isset($title))
    <title>{{ $title }}</title>
@else
    <title>Admin</title>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Site favicon -->
<link
    rel="apple-touch-icon"
    sizes="180x180"
    href="{{ asset('backend/vendors/images/apple-touch-icon.png') }}"
/>
<link
    rel="icon"
    type="image/png"
    sizes="32x32"
    href="{{ asset('backend/vendors/images/favicon-32x32.png') }}"
/>
<link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="{{ asset('backend/vendors/images/favicon-16x16.png') }}"
/>

<!-- Mobile Specific Metas -->
<meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1"
/>

<!-- Google Font -->
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
/>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/core.css') }}" />
<link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('backend/vendors/styles/icon-font.min.css') }}"
/>
<link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}"
/>
<link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}"
/>
<link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('backend/vendors/styles/icon-font.min.css') }}"
/>
<link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('backend/src/plugins/cropperjs/dist/cropper.css') }}"
/>
<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}" />

<!-- Global site tag (gtag.js) - Google Analytics -->
<script
    async
    src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
></script>
<script
    async
    src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
    crossorigin="anonymous"
></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-GBZ3SGGX85");
</script>
<!-- Google Tag Manager -->
<script>
    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != "dataLayer" ? "&l=" + l : "";
        j.async = true;
        j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- <script src="{{asset('backend/src/scripts/jquery-3.7.1.min.js')}}"></script>    --}}

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<link rel="stylesheet" media="all" href="{{ asset('backend/src/styles/customize.css')}}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/furniture-icons.css')}}" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>


<!-- End Google Tag Manager -->