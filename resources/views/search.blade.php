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

    <!-- Modal para agregar álbum -->
    <div class="modal fade" id="agregarAlbumModal" tabindex="-1" aria-labelledby="agregarAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarAlbumModalLabel">Agregar Álbum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="agregarAlbumForm" action="/albumes" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Álbum</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="uri" class="form-label">URI del Álbum</label>
                            <input type="text" class="form-control" id="uri" name="uri" required>
                        </div>
                        <div class="mb-3">
                            <label for="release_year" class="form-label">Año de Lanzamiento</label>
                            <input type="number" class="form-control" id="release_year" name="release_year" required>
                        </div>
                        <div class="mb-3">
                            <label for="cover_art" class="form-label">Portada</label>
                            <input type="text" class="form-control" id="cover_art" name="cover_art">
                        </div>
                        <input type="hidden" id="artist_uri" name="artist_uri">
                        <button type="submit" class="btn btn-primary">Agregar Álbum</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                                    <button class="btn btn-warning" onclick="registerArtist('${album.data.artists.items[0].uri}', '${album.data.artists.items[0].profile.name}')">Registrar Artista</button>
                                    <button class="btn btn-success" onclick="registerAlbum('${album.data.uri}', '${album.data.artists.items[0].uri}', '${album.data.artists.items[0].profile.name}', '${album.data.name}', '${album.data.date.year}', '${album.data.coverArt.sources[0].url}')">Registrar Álbum</button>
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

            // Agregar el resultado al DOM
            $('#results').html(output);
        }

        function registerArtist(artistUri, artistName) {
            $.ajax({
                url: '/artistas', // Ruta para almacenar artistas
                method: 'POST',
                data: {
                    uri: artistUri,
                    name: artistName,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Artista registrado exitosamente.');
                },
                error: function(error) {
                    console.error("Error al guardar el artista: ", error);
                }
            });
        }

        function registerAlbum(albumUri, artistUri, artistName, albumName, releaseYear, coverArtUrl) {
            $.ajax({
                url: '/albumes', // Ruta para almacenar álbumes
                method: 'POST',
                data: {
                    uri: albumUri,
                    name: albumName,
                    artist_uri: artistUri, // Usar el URI del artista
                    release_year: releaseYear,
                    cover_art: coverArtUrl,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Álbum registrado exitosamente.');
                },
                error: function(error) {
                    console.error("Error al guardar el álbum: ", error);
                }
            });
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

        $(document).on('submit', '#agregarAlbumForm', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#agregarAlbumModal').modal('hide');
                    alert('Álbum agregado exitosamente.');
                },
                error: function(error) {
                    console.error("Error al agregar el álbum: ", error);
                }
            });
        });
    </script>
</body>
@endsection