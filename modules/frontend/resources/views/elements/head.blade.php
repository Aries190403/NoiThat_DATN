<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Mobile Web-app fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="google-site-verification" content="Itgl_K34aykcRse50lCQ_J3IwQjMiJ7bzkxeA-bgv78" />

<!-- SEO Meta tags -->
<meta name="keywords" content="nội thất, Nội Thất Aries, nội thất aries, aries, Aries, Nội Thất">
<meta name="description" content="@yield('meta_description', 'Nội Thất Aries chuyên cung cấp dịch vụ thiết kế và thi công nội thất chất lượng với giá tốt.')">
<meta name="author" content="Nội Thất Aries">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<!-- Canonical & hreflang -->
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="alternate" hreflang="vi" href="https://noithat.aries.id.vn/" />
<link rel="alternate" hreflang="en" href="https://noithat.aries.id.vn/en" />
<link rel="alternate" hreflang="x-default" href="https://noithat.aries.id.vn/" />

<!-- Open Graph -->
<meta property="og:title" content="@yield('meta_title', 'Nội Thất Aries - Thiết Kế Nội Thất Chất Lượng')" />
<meta property="og:description" content="@yield('meta_description', 'Nội Thất Aries cung cấp các dịch vụ nội thất uy tín với chất lượng vượt trội và giá cả cạnh tranh.')" />
<meta property="og:image" content="https://noithat.aries.id.vn/frontend/assets/images/thumbnail.png" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="website" />

<!-- Twitter Meta -->

<!-- Favicon -->
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&amp;subset=latin-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

<!-- CSS styles -->
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/bootstrap.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/animate.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/font-awesome.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/furniture-icons.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/linear-icons.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/magnific-popup.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/owl.carousel.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/ion-range-slider.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/theme.css') }}" />
<link rel="stylesheet" media="all" href="{{ asset('frontend/css/jquery.toast.min.css') }}" />

@include('script')

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@graph": [
        {
        "@type": "WebSite",
        "@id": "{{ url('/') }}#website",
        "url": "{{ url('/') }}",
        "name": "Nội Thất Aries",
        "description": "Nội Thất Aries - Thiết kế và thi công nội thất chất lượng, giá tốt.",
        "publisher": {
            "@id": "{{ url('/') }}#person"
        },
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://noithat.aries.id.vn/search?query={search_term_string}",
            "query-input": "required name=search_term_string"
        },
        "inLanguage": "vi-VN"
        },
        {
        "@type": "Person",
        "@id": "{{ url('/') }}#person",
        "name": "Trần Văn Hên",
        "url": "{{ url('/') }}"
        },
        {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}",
        "url": "{{ url()->current() }}",
        "name": "@yield('meta_title', 'Nội Thất Aries - Thiết Kế Nội Thất Chất Lượng')",
        "isPartOf": {
            "@id": "{{ url('/') }}#website"
        },
        "about": {
            "@id": "{{ url('/') }}#person"
        },
        "description": "@yield('meta_description', 'Nội Thất Aries cung cấp dịch vụ thiết kế và thi công nội thất uy tín, chất lượng.')",
        "inLanguage": "vi-VN",
        "datePublished": "2025-04-19T00:00:00+07:00",
        "dateModified": "{{ now()->toAtomString() }}"
        }
    ]
    }
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1BX4GGEMW0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1BX4GGEMW0');
</script>


<!-- HTML5 shim for IE -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
