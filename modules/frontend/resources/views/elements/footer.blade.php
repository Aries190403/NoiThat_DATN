        <!-- ================== Footer  ================== -->

        <footer>
            <div class="container">

                <!--footer showroom-->
                <div class="footer-showroom">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2>Visit our showroom</h2>
                            <p>{{ $globalSettings['address'] ?? '200 12th Ave, New York, NY 10001, USA' }}</p>
                            <p>Open: {{ $globalSettings['open_time'] ?? '10 am - 6 pm' }} &nbsp; &nbsp; | &nbsp; &nbsp;
                                Close: {{ $globalSettings['close_time'] ?? '12pm - 2 pm' }}</p>
                        </div>
                        <div class="col-sm-4 text-center">
                            <a href="{{ $globalSettings['map_link'] ?? '#' }}" class="btn btn-clean"><span
                                    class="icon icon-map-marker"></span> Get directions</a>
                            <div class="call-us h4"><span
                                    class="icon icon-phone-handset"></span> {{ preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1.$2.$3', $globalSettings['phone']) ?? ' 000.000.0000' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!--footer links-->
                <div class="footer-links">
                    <div class="row">
                        <div class="col-sm-4 col-md-2">
                            <h5>Browse by</h5>
                            <ul>
                                <!-- <li><a href="#">Brand</a></li> -->
                                <li><a href="/shop">Product</a></li>
                                <li><a href="/shop">Category</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-2">
                            <h5>Follow us</h5>
                            <ul>
                                <li><a href="{{ $globalSettings['facebook_link'] ?? '#' }}"><i
                                            class="fa fa-facebook"></i> Facebook</a></li>
                                <!-- <li><a href="#">News</a></li> -->
                                <li><a href="{{ $globalSettings['youtube_link'] ?? '#' }}"><i class="fa fa-youtube"></i>
                                        Youtube</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-2">

                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5>Sign up for our newsletter</h5>
                            <p><i>Add your email address to sign up for our monthly emails and to receive promotional
                                    offers.</i></p>
                            <div class="form-group form-newsletter">
                                <input class="form-control" type="text" name="email" value=""
                                    placeholder="Email address" />
                                <input type="submit" class="btn btn-clean btn-sm" value="Subscribe" />
                            </div>
                        </div>
                    </div>
                </div>

                <!--footer social-->

                {{-- <div class="footer-social">
                    <div class="row">
                        <div class="col-sm-6 links">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div style="text-align: center;">© Copyright 2025 by Noi That Aries | Developed by Tran Van Hen. All rights reserved.</div>
        </footer>



        <!--JS files-->
        <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.bootstrap.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.owl.carousel.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.ion.rangeSlider.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.isotope.pkgd.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>
