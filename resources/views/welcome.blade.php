<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    @vite(['resources/js/app.js'])

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>PDF Table</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Pdf (click to download)</th>
                        </tr>
                    </thead>
                    @forelse ($pdf as $i=>$pdf)
                    <tbody>
                        <tr>
                            <th scope="row">{{++$i}}</th>
                            <td>{{$pdf->title}}</td>
                            <td class="download"><a href="{{asset(path_file() . $pdf->file)}}">{{$pdf->file}}</a></td>
                        </tr>
                    </tbody>
                    @empty
                    <tbody>
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <td>Nothing to Show</td>

                        </tr>
                    </tbody>

                    @endforelse
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Snippet Table</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Snippet</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @forelse ($snippets as $i=>$snippet)
                    <tbody>
                        <tr>
                            <th scope="row">{{++$i}}</th>
                            <td>{{$snippet->title}}</td>
                            <td>{{$snippet->content}}</td>
                            <td>
                                <textarea readonly name="" id="snippet{{$i}}" cols="15" rows="2">{{$snippet->snippet}}</textarea>
                            </td>
                            <td id="copytoclipboard" onclick="copytoclipboard({{$i}})">Copy to Clipboard</td>
                        </tr>
                    </tbody>
                    @empty
                    <tbody>
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <td>Nothing to Show</td>

                        </tr>
                    </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Link Table</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Link</th>
                            <th scope="col">New tab</th>
                        </tr>
                    </thead>
                    @forelse ($links as $i=>$link)
                    <tbody>
                        <tr>
                            <th scope="row">{{++$i}}</th>
                            <td>{{$link->title}}</td>
                            @if ($link->newtab == 1)
                            <td><a target="_blank" href="{{$link->link}}">{{$link->title}}</a></td>
                            @else
                            <td><a href="{{$link->link}}">{{$link->title}}</a></td>
                            @endif
                            <td>{{$link->newtab == 1 ? 'Open with new tab' : 'Open in this tab'}}</td>
                        </tr>
                    </tbody>
                    @empty
                    <tbody>
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <td>Nothing to Show</td>

                        </tr>
                    </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function copytoclipboard(id) {
            var copyText = document.getElementById("snippet" + id);
            copyText.select();
            document.execCommand('copy');

        }
    </script>
</body>

</html>