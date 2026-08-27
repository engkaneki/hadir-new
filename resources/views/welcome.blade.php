<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sedang Dalam Pemeliharaan</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-family: Inter, Arial, sans-serif;
            background: #f7faff;
            color: #172b4d;
        }

        /* =========================
           BACKGROUND
        ========================= */

        .blob {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            opacity: .45;
            filter: blur(2px);
            animation: float 6s ease-in-out infinite;
        }

        .blob.one {
            width: 180px;
            height: 180px;
            background: #dceaff;
            top: 8%;
            left: 5%;
        }

        .blob.two {
            width: 100px;
            height: 100px;
            background: #c9e0ff;
            right: 8%;
            top: 15%;
            animation-delay: 1s;
        }

        .blob.three {
            width: 150px;
            height: 150px;
            background: #e4efff;
            bottom: -50px;
            left: 15%;
            animation-delay: 2s;
        }

        /* =========================
           MAIN
        ========================= */

        .page {
            width: min(900px, 92%);
            text-align: center;
            position: relative;
            z-index: 2;
            padding: 20px 20px 60px;
        }

        /* =========================
           ILLUSTRATION
        ========================= */

        .illustration {
            width: min(400px, 70vw);
            margin: 0 auto 5px;

            animation:
                illustrationFloat 4s ease-in-out infinite;

            filter:
                drop-shadow(0 18px 25px rgba(36, 112, 220, .12));
        }

        .illustration img {
            display: block;
            width: 100%;
            height: auto;
        }

        /* =========================
           TITLE
        ========================= */

        h1 {
            font-size: clamp(34px, 6vw, 58px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 18px;
        }

        h1 span {
            color: #2878e5;
        }

        .description {
            max-width: 620px;
            margin: auto;

            color: #64748b;
            font-size: 16px;
            line-height: 1.7;
        }

        /* =========================
           STATUS CARD
        ========================= */

        .status {
            width: min(700px, 100%);
            margin: 30px auto 24px;

            padding: 18px;

            display: flex;
            justify-content: center;

            background: rgba(255, 255, 255, .85);

            border: 1px solid #e5edf8;
            border-radius: 20px;

            box-shadow:
                0 15px 45px rgba(41, 91, 145, .08);

            backdrop-filter: blur(10px);
        }

        .status-item {
            flex: 1;
            padding: 8px 20px;

            border-right: 1px solid #e5edf8;
        }

        .status-item:last-child {
            border-right: 0;
        }

        .icon {
            width: 46px;
            height: 46px;

            margin: 0 auto 10px;

            display: grid;
            place-items: center;

            border-radius: 50%;

            background: #edf5ff;
            color: #2878e5;

            font-size: 21px;
        }

        .status-item strong {
            display: block;

            font-size: 14px;

            margin-bottom: 5px;
        }

        .status-item small {
            color: #8a99ad;
            font-size: 12px;
        }

        /* =========================
           PROGRESS
        ========================= */

        .progress-wrapper {
            max-width: 580px;
            margin: 24px auto;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;

            margin-bottom: 9px;

            font-size: 12px;
            color: #64748b;
        }

        .progress {
            height: 8px;

            overflow: hidden;

            background: #e6eef9;

            border-radius: 50px;
        }

        .progress-bar {
            width: 72%;
            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(90deg,
                    #71adff,
                    #2878e5);

            animation: progress 2s ease-out;
        }

        /* =========================
           COUNTDOWN
        ========================= */

        .countdown-title {
            margin-top: 24px;

            font-size: 11px;
            font-weight: 700;

            letter-spacing: 2px;

            color: #2878e5;
            text-transform: uppercase;
        }

        .countdown {
            margin: 5px 0 5px;

            font-size: clamp(30px, 5vw, 42px);

            font-weight: 800;

            letter-spacing: 4px;

            color: #172b4d;
        }

        .countdown-label {
            display: flex;
            justify-content: center;
            gap: 40px;

            color: #94a3b8;

            font-size: 9px;
            letter-spacing: 1px;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 25px;

            color: #8492a6;

            font-size: 13px;
            line-height: 1.6;
        }

        /* =========================
           WAVES
        ========================= */

        .waves {
            position: fixed;

            bottom: -5px;
            left: 0;

            width: 100%;
            height: 100px;

            z-index: 1;

            overflow: hidden;
        }

        .wave {
            position: absolute;

            width: 120%;
            height: 100px;

            left: -10%;

            border-radius: 50% 50% 0 0;

            background: #e5f0ff;

            transform: rotate(-2deg);
        }

        .wave:nth-child(2) {
            bottom: -45px;

            background: #d4e6ff;

            transform: rotate(3deg);
        }

        /* =========================
           ANIMATION
        ========================= */

        @keyframes illustrationFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes progress {

            from {
                width: 0;
            }

            to {
                width: 72%;
            }
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {

            body {
                overflow-y: auto;
            }

            .page {
                padding-top: 20px;
                padding-bottom: 40px;
            }

            .illustration {
                width: 290px;
            }

            h1 {
                letter-spacing: -1px;
            }

            .description {
                font-size: 14px;
            }

            .status {
                flex-direction: column;
                gap: 5px;
            }

            .status-item {
                border-right: 0;
                border-bottom: 1px solid #e5edf8;

                padding: 12px;
            }

            .status-item:last-child {
                border-bottom: 0;
            }

            .countdown-label {
                gap: 25px;
            }

            .waves {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Background decoration -->
    <div class="blob one"></div>
    <div class="blob two"></div>
    <div class="blob three"></div>


    <main class="page">

        <!-- Illustration -->
        <div class="illustration">
            <img src="{{ asset('/') }}assets/img/maintenance.png" alt="Ilustrasi pemeliharaan sistem">
        </div>


        <!-- Title -->
        <h1>
            Sedang Dalam <span>Pemeliharaan</span>
        </h1>


        <!-- Description -->
        <p class="description">
            Kami sedang melakukan pemeliharaan terjadwal untuk meningkatkan
            performa, keamanan, dan kenyamanan layanan.
            Silakan kembali beberapa saat lagi.
        </p>


        <!-- Status -->
        <section class="status">

            <div class="status-item">

                <div class="icon">
                    ◷
                </div>

                <strong>
                    Sedang Berlangsung
                </strong>

                <small>
                    Pemeliharaan sedang berjalan
                </small>

            </div>


            <div class="status-item">

                <div class="icon">
                    ⚙
                </div>

                <strong>
                    Sedang Ditingkatkan
                </strong>

                <small>
                    Membuat layanan menjadi lebih baik
                </small>

            </div>


            <div class="status-item">

                <div class="icon">
                    🚀
                </div>

                <strong>
                    Segera Kembali
                </strong>

                <small>
                    Layanan akan segera tersedia
                </small>

            </div>

        </section>


        <!-- Progress -->
        <div class="progress-wrapper">

            <div class="progress-label">

                <span>
                    Proses pemeliharaan
                </span>

                <span>
                    72%
                </span>

            </div>

            <div class="progress">

                <div class="progress-bar"></div>

            </div>

        </div>


        <!-- Countdown -->
        <div class="countdown-title">
            Perkiraan waktu tersisa
        </div>

        <div class="countdown" id="countdown">
            24 : 25 : 37
        </div>

        <div class="countdown-label">

            <span>
                JAM
            </span>

            <span>
                MENIT
            </span>

            <span>
                DETIK
            </span>

        </div>


        <!-- Footer -->
        <div class="footer">

            Terima kasih atas kesabaran dan pengertian Anda.<br>
            Kami akan segera kembali melayani Anda.

        </div>

    </main>


    <!-- Bottom waves -->
    <div class="waves">

        <div class="wave"></div>
        <div class="wave"></div>

    </div>


    <script>
        /*
         * Countdown
         * 25 menit 37 detik
         */

        let remaining = 100 * 25 * 60 + 37;


        function updateCountdown() {

            const hours =
                Math.floor(remaining / 3600);

            const minutes =
                Math.floor(
                    (remaining % 3600) / 60
                );

            const seconds =
                remaining % 60;


            document.getElementById(
                    "countdown"
                ).textContent =

                `${String(hours).padStart(2, "0")} : ` +
                `${String(minutes).padStart(2, "0")} : ` +
                `${String(seconds).padStart(2, "0")}`;


            if (remaining > 0) {
                remaining--;
            }

        }


        updateCountdown();

        setInterval(
            updateCountdown,
            1000
        );
    </script>

</body>

</html>
