@extends('layouts.app')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
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

        .suggestions {
            border: 1px solid #ccc;
            background: white;
            position: absolute;
            z-index: 1000;
            width: 100%;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color : #f0f0f0;
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            const tracks = response.tracks.items;

            let output = '<h2>Resultados de búsqueda:</h2>';

            // Mostrar álbumes
            if (albums.length > 0) {
                output += '<h3>Álbumes:</h3>';
                output += '<ul>';
                albums.forEach(album => {
                    output += `
                        <li>
                            <img src="${album.data.coverArt.sources[0].url}" alt="${album.data.name}" width="50">
                            <strong>${album.data.name}</strong> - ${album.data.artists.items[0].profile.name}
                        </li>
                    `;
                });
                output += '</ul>';
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
    </script>
    </main>
</body>
@endsection