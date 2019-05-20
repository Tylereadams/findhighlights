<meta property="og:title" content="{{ isset($title) ? $title : 'Find Highlights' }}">
<meta property="og:description" content="{{ isset($description) ? $description : ''}}">
<meta property="og:image" content="{{ isset($imageUrl) ? $imageUrl : '' }}">
<meta property="og:url" content="{{ isset($url) ? $url : url()->current() }}">

<meta name="twitter:title" content="{{ isset($title) ? $title : 'Find Highlights' }}">
<meta name="twitter:description" content="{{ isset($description) ? $description : '' }}">
<meta name="twitter:image" content="{{ isset($imageUrl) ? $imageUrl : '' }}">
<meta name="twitter:card" content="summary_large_image">