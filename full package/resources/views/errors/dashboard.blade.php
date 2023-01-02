@extends('layouts.admin')
@section('content') 
 <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- error 404 -->
                <section class="row flexbox-container">
                    <div class="col-xl-6 col-md-7 col-9">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <h1 class="error-title">Page Not Found :(</h1>
                                    <p class="pb-3">
                                        we couldn't find the page you are looking for</p>
                                    <img class="img-fluid" src="/app-assets/images/pages/404.png" alt="404 error">
                                    <a href="index.html" class="btn btn-primary round glow mt-3">BACK
                                        TO
                                        HOME</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- error 404 end -->
            </div>
        </div>
    </div>
@stop
