<main>
    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade"
            style="background-image: url(front/assets/img/page-title-bg.jpg);">
            <div class="container position-relative">
                <h1>Blog</h1>
                <p>Selamat datang di blog UEU Bootcamp! Temukan berbagai artikel, tips, dan inspirasi seputar dunia
                    teknologi, pemrograman, dan pengalaman seru selama mengikuti bootcamp di Universitas Esa Unggul.</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="current">Blog</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Blog Posts Section -->
        <section id="blog-posts" class="blog-posts section">
            <div class="container">
                <div class="row gy-4">

                    @foreach ($posts as $post)
                        <div class="col-lg-4">
                            <article class="d-flex flex-column">

                                <div class="post-img">
                                    <img src="{{ asset('front/assets/img/blog/blog-1.jpg') }}" alt="" class="img-fluid">
                                    {{-- Ganti src jika sudah punya kolom gambar --}}
                                </div>

                                <h2 class="title">
                                    <a href="#">{{ $post->title }}</a>
                                </h2>

                                <div class="meta-top">
                                    <ul>
                                        <li class="d-flex align-items-center">
                                            <i class="bi bi-person"></i>
                                            <a href="#">{{ $post->author->name ?? 'Anonim' }}</a>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="bi bi-clock"></i>
                                            <a href="#">
                                                <time datetime="{{ $post->published_at }}">
                                                    {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y H:i:s') }}
                                                </time>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="content">
                                    <p style="text-align: justify;">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                </div>

                                <div class="read-more mt-auto align-self-end">
                                    <a href="{{ url($post->slug) }}" target="_blank" rel="noopener">Read More</a>
                                </div>

                            </article>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!-- /Blog Posts Section -->

        <!-- Blog Pagination Section -->
        <!-- <section id="blog-pagination" class="blog-pagination section">

            <div class="container">
                <div class="d-flex justify-content-center">
                    <ul>
                        <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
                        <li><a href="#" class="active">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li>...</li>
                        <li><a href="#">10</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>

        </section>/Blog Pagination Section -->

    </main>
</main>