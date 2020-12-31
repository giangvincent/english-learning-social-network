<?php 
    $defaultInfo = array(
        'title' => 'THATS GOOD',
        'description' => 'Welcome to Thatsgood',
        'url' => 'https://thatsgood.info',
        'image' => 'https://backend.thatsgood.info/dist/upload/1.jpg'
);
$res = $defaultInfo;
if (count($data) > 0) {
    $res['title'] = $data['subject'];
    $description = '';
    foreach ($data['content'] as $content) {
        $description .= strip_tags($content['contentHtml']). ' ';
    }
    $res['description'] = mb_substr($description, 0, 255, "UTF-8");
    $res['url'] = $res['url']. '/p/post/' . $data['url'];
}
?>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $res['title'] }}</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ $res['title'] }}">
    <meta name="description" content="{{ $res['description'] }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $res['url'] }}">
    <meta property="og:title" content="{{ $res['title'] }}">
    <meta property="og:description" content="{{ $res['description'] }}">
    <meta property="og:image" content="{{ $res['image'] }}">
    <meta property="fb:app_id" content="865567664256189">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{$res['url']}}">
    <meta property="twitter:title" content="{{$res['title']}}">
    <meta property="twitter:description" content="{{$res['description']}}">
    <meta property="twitter:image" content="{{$res['image']}}">

</head>

<body>
    <script>
        window.location.replace("https://thatsgood.info");
    </script>
</body>

</html>