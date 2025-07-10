<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $documentationTitle }}</title>
    <link rel="stylesheet" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            font-family: 'Segoe UI', sans-serif;
            background: #fff;
            color: #333;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(to right, #1976d2, #64b5f6);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin: 0.5rem 0;
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        .hero p,
        .scroll-btn {
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
            animation-delay: 0.3s;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .scroll-btn {
            background: white;
            color: #1976d2;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .scroll-btn:hover {
            transform: translateY(-3px);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-separator {
            height: 60px;
            background: #f1f5f9;
        }

        #swagger-ui {
            width: 100%;
            min-height: calc(100vh - 60px);
            background: #fff;
            animation: fadeIn 0.8s ease 0.5s both;
            padding: 20px;
            box-sizing: border-box;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background: transparent;
            backdrop-filter: none;
            transition: background 0.4s ease, backdrop-filter 0.4s ease, box-shadow 0.3s ease;
            z-index: 1000;
        }

        body.scrolled .topbar {
            background: rgba(80, 80, 80, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .parallax-logo {
            width: 80px;
            transition: transform 0.1s ease-out;
            will-change: transform;
            transform-style: preserve-3d;
            position: relative;
        }
    </style>
</head>

<body>

    <div class="hero" id="hero">
        <img src="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" alt="API Logo" class="parallax-logo">
        <h1>Selamat datang di API UEU Bootcamp</h1>
        <p>Jelajahi API kami dengan dokumentasi interaktif yang didukung oleh Swagger UI.</p>
        <button class="scroll-btn" onclick="scrollToDocs()">Jelajahi Dokumen</button>
    </div>

    <div class="section-separator"></div>

    <div id="swagger-ui"></div>

    <script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
    <script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
    <script>
        function scrollToDocs() {
            document.getElementById('swagger-ui').scrollIntoView({
                behavior: 'smooth'
            });
        }

        window.onload = function() {
            const urls = [];
            @foreach ($urlsToDocs as $title => $url)
                urls.push({
                    name: "{{ $title }}",
                    url: "{{ $url }}"
                });
            @endforeach

            SwaggerUIBundle({
                dom_id: '#swagger-ui',
                urls: urls,
                "urls.primaryName": "{{ $documentationTitle }}",
                operationsSorter: "{!! config('l5-swagger.defaults.ui.display.operationsSorter', 'alpha') !!}",
                docExpansion: "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
                presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
                plugins: [SwaggerUIBundle.plugins.DownloadUrl],
                layout: "StandaloneLayout",
                requestInterceptor: req => {
                    req.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                    return req;
                }
            });

            window.addEventListener('scroll', () => {
                const scrollY = window.scrollY;
                const logo = document.querySelector('.parallax-logo');
                const maxTranslate = 100; // batas maksimal pergerakan ke atas
                const translateY = Math.max(-scrollY * 0.3, -maxTranslate); // bergerak ke atas perlahan

                if (scrollY > 50) {
                    document.body.classList.add('scrolled');
                } else {
                    document.body.classList.remove('scrolled');
                }

                if (logo) {
                    const rotateX = scrollY * 0.05;
                    logo.style.transform = `translateY(${translateY}px) rotateX(${rotateX}deg)`;
                }
            });
        }
    </script>
</body>

</html>
