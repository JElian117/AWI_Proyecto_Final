@extends('layouts.app')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Asegúrate de incluir el token CSRF -->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

@section('content')
<body class="bg-dark bg-gradient">
    <div class="container mt-4">
        <div class="input-group">
            <input type="text" id="searchQuery" class="form-control" placeholder="Buscar artista, álbum o canción">
            <button class="btn btn-outline-secondary" id="searchButton">Buscar</button>
        </div>
        <div class="text-white" id="results"></div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Escribir Reseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm">
                        <input type="hidden" id="albumId" name="album_id">
                        <div class="mb-3">
                            <label for="review" class="form-label">Tu Reseña</label>
                            <textarea class="form-control" id="review" name="review" rows="3" maxlength="500" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Reseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openReviewModal(albumUri, artistUri) {
            // Realizar la llamada AJAX para guardar el artista y el álbum
            $.ajax({
                url: '/artistas', // Cambia esto a la ruta correcta para almacenar artistas
                method: 'POST',
                data: {
                    uri: artistUri,
                    name: 'Nombre del Artista', // Asegúrate de obtener el nombre del artista de la respuesta
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(artistResponse) {
                    // Luego guarda el álbum
                    $.ajax({
                        url: '/albumes', // Cambia esto a la ruta correcta para almacenar álbumes
                        method: 'POST',
                        data: {
                            uri: albumUri,
                            name: 'Nombre del Álbum', // Asegúrate de obtener el nombre del álbum de la respuesta
                            artist_id: artistResponse.id, // Usa la ID del artista que acabas de guardar
                            release_year: 'Año de lanzamiento', // Asegúrate de obtener el año de lanzamiento de la respuesta
                            cover_art: 'URL de la portada', // Asegúrate de obtener la URL de la portada de la respuesta
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(albumResponse) {
                    $('#albumId').val(albumResponse.id); // Asigna el ID del álbum guardado
                    $('#reviewModal').modal('show'); // Mostrar el modal después de guardar el álbum
                },
                error: function(error) {
                    console.error("Error al guardar el álbum: ", error);
                }
                    });
                },
                error: function(error) {
                    console.error("Error al guardar el artista: ", error);
                }
            });
        }

        function searchSpotify(query) {
            const settings = {
                    async: true,
                    crossDomain: true,
                    url: `https://spotify23.p.rapidapi.com/search/?q=${encodeURIComponent(query)}&type=multi&offset=0&limit=10&numberOfTopResults=5`,
                    method: 'GET',
                    headers: {
                        'x-rapidapi-key': '359b51b6b5msh14fe4ca2e90462ap1005d5jsnbe6d35b7521c',
                        'x-rapidapi-host': 'spotify23.p.rapidapi.com'
                    }
                };

                $.ajax(settings).done(function (response) {
                    displayResults(response);
                }).fail(function (error) {
                    console.error("Error en la búsqueda: ", error);
                });
        }

        function displayResults(response) {
            const albums = response.albums.items;
            const artists = response.artists.items;
            const tracks = response.tracks.items;

            let output = '<h2>Resultados de búsqueda:</h2>';

            // Mostrar álbumes
            if (albums.length > 0) {
                output += '<h3>Álbumes:</h3>';
                output += '<div class="row">';
                albums.forEach(album => {
                    output += `
                        <div class="col-md-4">
                            <div class="card text-white bg-dark">
                                <img src="${album.data.coverArt.sources[0].url}" class="card-img-top" alt="${album.data.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${album.data.name}</h5>
                                    <p class="card-text">Artista: ${album.data.artists.items[0].profile.name}</p>
                                    <button class="btn btn-success" onclick="openReviewModal('${album.data.uri}', '${album.data.artists.items[0].uri}')">Escribir Reseña</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                output += '</div>';
            }

            // Mostrar artistas
            if (artists.length > 0) {
                output += '<h3>Artistas:</h3>';
                output += '<ul>';
                artists.forEach(artist => {
                    output += `
                        <li>
                            <img src="${artist.data.visuals.avatarImage.sources[0].url}" alt="${artist.data.profile.name}" width="50">
                            <strong>${artist.data.profile.name}</strong>
                        </li>
                    `;
                });
                output += '</ul>';
            }

            // Mostrar canciones
            if (tracks.length > 0) {
                output += '<h3>Canciones:</h3>';
                output += '<ul>';
                tracks.forEach(track => {
                    output += `
                        <li>
                            <strong>${track.data.name}</strong> - ${track.data.artists.items[0].profile.name}
                        </li>
                    `;
                });
                output += '</ul>';
            }

            // Agregar el resultado al DOM
            $('#results').html(output);
        }
        $(document).ready(function () {
            $('#searchButton').click(function () {
                const query = $('#searchQuery').val();
                if (query) {
                    searchSpotify(query);
                } else {
                    alert("Por favor, ingresa un término de búsqueda.");
                }
            });
        });
        $(document).on('submit', '#reviewForm', function(e) {
            e.preventDefault();
            const reviewText = $('#review').val();

            $.ajax({
                url: '/albumes/reviews', // Cambia esto a la ruta correcta para almacenar reseñas
                method: 'POST',
                data: {
                    review: reviewText,
                    _token: $('meta[name="csrf-token"]').attr('content') 
                },
                success: function(response) {
                    $('#reviewModal').modal('hide');
                    alert('Reseña guardada con éxito.');
                },
                error: function(error) {
                    console.error("Error al guardar la reseña: ", error);
                    alert('Hubo un error al guardar la reseña.');
                }
            });
        });
    </script>
    </main>
</body>
@endsection