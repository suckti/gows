@extends('components.layouts.app')

@section('content')
<div class="timeline">
    <div class="tm-body">
        <div class="tm-title">
            <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">November 2021</h5>
        </div>
        <ol class="tm-items">
            <li>
                <div class="tm-info">
                    <div class="tm-icon"><i class="fas fa-star"></i></div>
                    <time class="tm-datetime" datetime="2021-11-22 19:13">
                        <div class="tm-datetime-date">7 months ago</div>
                        <div class="tm-datetime-time">07:13 PM</div>
                    </time>
                </div>
                <div class="tm-box appear-animation" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
                    <p>
                        It's awesome when we find a good solution for our projects, Porto Admin is <span class="text-primary">#awesome</span>
                    </p>
                    <div class="tm-meta">
                        <span>
                            <i class="bx bx-user-circle"></i> By <a href="#">John Doe</a>
                        </span>
                        <span>
                            <i class="fas fa-tag"></i> <a href="#">Porto</a>, <a href="#">Awesome</a>
                        </span>
                        <span>
                            <i class="fas fa-comments"></i> <a href="#">5652 Comments</a>
                        </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="tm-info">
                    <div class="tm-icon"><i class="fas fa-thumbs-up"></i></div>
                    <time class="tm-datetime" datetime="2021-11-19 18:13">
                        <div class="tm-datetime-date">7 months ago</div>
                        <div class="tm-datetime-time">06:13 PM</div>
                    </time>
                </div>
                <div class="tm-box appear-animation" data-appear-animation="fadeInRight" data-appear-animation-delay="250">
                    <p>
                        What is your biggest developer pain point?
                    </p>
                </div>
            </li>
            <li>
                <div class="tm-info">
                    <div class="tm-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <time class="tm-datetime" datetime="2021-11-14 17:25">
                        <div class="tm-datetime-date">7 months ago</div>
                        <div class="tm-datetime-time">05:25 PM</div>
                    </time>
                </div>
                <div class="tm-box appear-animation" data-appear-animation="fadeInRight" data-appear-animation-delay="400">
                    <p>
                        <a href="#">John Doe</a> is reading a book at <span class="text-primary">New York Public Library</span>
                    </p>
                    <blockquote class="primary">
                        <p>Learn from yesterday, live for today, hope for tomorrow. The important thing is not to stop questioning.</p>
                        <small>A. Einstein,
                            <cite title="Brainyquote">Brainyquote</cite>
                        </small>
                    </blockquote>
                    <div id="gmap-checkin-example" class="mb-3" style="height: 250px; width: 100%;"></div>
                    <div class="tm-meta">
                        <span>
                            <i class="bx bx-user-circle"></i> By <a href="#">John Doe</a>
                        </span>
                        <span>
                            <i class="fas fa-comments"></i> <a href="#">9 Comments</a>
                        </span>
                    </div>
                </div>
            </li>
        </ol>
        <div class="tm-title">
            <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">September 2021</h5>
        </div>
        <ol class="tm-items">
            <li>
                <div class="tm-info">
                    <div class="tm-icon"><i class="fas fa-heart"></i></div>
                    <time class="tm-datetime" datetime="2021-09-08 16:13">
                        <div class="tm-datetime-date">9 months ago</div>
                        <div class="tm-datetime-time">04:13 PM</div>
                    </time>
                </div>
                <div class="tm-box appear-animation" data-appear-animation="fadeInRight">
                    <p>
                        Checkout! How cool is that!
                    </p>
                    <div class="thumbnail-gallery">
                        <a class="img-thumbnail" href="img/projects/project-4.jpg">
                            <img width="215" src="img/projects/project-4.jpg">
                            <span class="zoom">
                                <i class="bx bx-search"></i>
                            </span>
                        </a>
                        <a class="img-thumbnail" href="img/projects/project-3.jpg">
                            <img width="215" src="img/projects/project-3.jpg">
                            <span class="zoom">
                                <i class="bx bx-search"></i>
                            </span>
                        </a>
                        <a class="img-thumbnail" href="img/projects/project-2.jpg">
                            <img width="215" src="img/projects/project-2.jpg">
                            <span class="zoom">
                                <i class="bx bx-search"></i>
                            </span>
                        </a>
                    </div>
                    <div class="tm-meta">
                        <span>
                            <i class="bx bx-user-circle"></i> By <a href="#">John Doe</a>
                        </span>
                        <span>
                            <i class="fas fa-tag"></i> <a href="#">Duis</a>, <a href="#">News</a>
                        </span>
                        <span>
                            <i class="fas fa-comments"></i> <a href="#">12 Comments</a>
                        </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="tm-info">
                    <div class="tm-icon"><i class="fas fa-video"></i></div>
                    <time class="tm-datetime" datetime="2021-09-08 11:26">
                        <div class="tm-datetime-date">9 months ago</div>
                        <div class="tm-datetime-time">11:26 AM</div>
                    </time>
                </div>
                <div class="tm-box appear-animation" data-appear-animation="fadeInRight">
                    <p>
                        Google Fonts gives you access to over 600 web fonts!
                    </p>
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="//player.vimeo.com/video/67957799"></iframe>
                    </div>
                    <div class="tm-meta">
                        <span>
                            <i class="bx bx-user-circle"></i> By <a href="#">John Doe</a>
                        </span>
                        <span>
                            <i class="fas fa-thumbs-up"></i> 122 Likes
                        </span>
                        <span>
                            <i class="fas fa-comments"></i> <a href="#">3 Comments</a>
                        </span>
                    </div>
                </div>
            </li>
        </ol>
    </div>
</div>
@endsection