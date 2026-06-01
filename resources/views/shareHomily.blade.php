<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="utf-8">

<title>{{ $homily->title }}</title>

<meta property="og:type" content="article">

<meta property="og:title"
      content="{{ $homily->title }}">

<meta property="og:description"
      content="{{
        Str::limit(
          strip_tags(
            $homily->message
              ?: 'Reflexión del Padre Uriel Franco sobre el Evangelio del día.'
          ),
          140
        )
      }}">

<meta property="og:image"
      content="{{ url('/support/imgHomily/'.$homily->img) }}">

<meta property="og:image:secure_url"
      content="{{ url('/support/imgHomily/'.$homily->img) }}">

<meta property="og:image:width"
      content="1200">

<meta property="og:image:height"
      content="630">

<meta property="og:url"
      content="{{ url('/homilyDetail/'.$homily->id) }}">

<meta property="og:site_name"
      content="Homilías Padre Uriel Franco">

<meta property="og:locale"
      content="es_CO">

<meta name="twitter:card"
      content="summary_large_image">

<meta name="twitter:title"
      content="{{ $homily->title }}">

<meta name="twitter:description"
      content="{{
        Str::limit(
          strip_tags(
            $homily->message
              ?: 'Reflexión del Padre Uriel Franco sobre el Evangelio del día.'
          ),
          140
        )
      }}">

<meta name="twitter:image"
      content="{{ url('/support/imgHomily/'.$homily->img) }}">

<meta name="twitter:url"
      content="{{ url('/homilyDetail/'.$homily->id) }}">

<script>
window.location.replace(
    "/homilyDetail/{{ $homily->id }}"
);
</script>

</head>

<body>

Redireccionando...

</body>
</html>