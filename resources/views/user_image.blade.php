<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Index</title>
    <!-- Link to Bootstrap CSS -->
    {{--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Additional custom styling */
        .image-card {
            margin-bottom: 20px;
        }
        .image-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="">
        <h1 class="text-center mb-5 ">Download Images</h1>
    </div>
    <div class="row justify-content-center">
        @if($images->count() > 0)
            @foreach($images as $image)
                <div class="col-md-6 col-lg-4">
                    <div class="card image-card" >
                        @if(str_contains($image->media, 'jpg') || str_contains($image->media, 'png') || str_contains($image->media, 'jpeg'))
                            <img class="card-img-top w-100" src="{{ asset('storage/'. $image->media) }}" alt="Image" style="cursor: {{$image->user->status == '0' ? 'not-allowed' : ''}} ; pointer-events: {{$image->user->status == '0' ? 'none' : ''}};">
                        @else
                            <video controls class="card-img-top w-100" style="cursor: {{$image->user->status == '0' ? 'not-allowed' : ''}} ; pointer-events: {{$image->user->status == '0' ? 'none' : ''}};">
                                <source src="{{asset('storage/'. $image->media)}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $image->title }}</h5>
                            <p class="card-text text-center">{{ $image->date }}</p>
{{--                            {{ asset('storage/' . $image->media) }}--}}
{{--                            download="{{ $image->title }}"--}}
{{--                            <a href="{{ asset('storage/' . $image->media) }}" id="download-link" class="btn btn-primary w-100" download="{{ $image->title }}">Download</a>--}}
                            <a href="{{ route('userImageDownload', ['image' => $image])}}" id="download-link" class="btn btn-primary w-100">Download</a>

                            @php
                                $whatsappLink = "https://api.whatsapp.com/send?text=" . rawurlencode("Check out this image: " . url('storage/' . $image->media));
                            @endphp
                            <a href="{{$whatsappLink}}" class="btn btn-success w-100 mt-3" target="_blank">Share on WhatsApp</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col">
                <p class="text-center text-muted">No images found.</p>
            </div>
        @endif
    </div>
</div>

<div id="qrcode"></div>
<script>
    // Phone number to share with
    var phoneNumber = "1234567890"; // Replace with actual phone number

    // Create a new QR code element
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "wa.me/" + phoneNumber,
        width: 128,
        height: 128
    });
</script>
</body>
</html>
