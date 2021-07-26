<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Movie Search</title>
</head>
<body>
<nav class="flex items-center justify-between flex-wrap bg-teal p-6 bg-indigo-500">
  <div class="flex items-center flex-no-shrink text-white mr-6">
    <span class="font-semibold text-xl tracking-tight">
      Laramovies
    </span>
  </div>
  <div class="block lg:hidden">
    <button data-toggle-hide="[data-nav-content]" class="flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white rounded focus:outline-none focus:shadow-outline">
      <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <title>
          Menu
        </title>
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
      </svg>
    </button>
  </div>

  <div data-nav-content="" class="w-full block flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block">
    <div class="text-sm lg:flex-shrink">
      <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4 rounded focus:outline-none focus:shadow-outline">
        Login
      </a>
    </div>
  </div>
</nav>

<div class="container mx-auto mt-10 mb-10">
    <div class="bg-white p-5 rounded shadow-sm">
        <div class="sm:w-3/4 lg:w-2/4 mx-auto gap-4 mb-4">
          <p class="font-light uppercase text-center mb-8">Movie Search</p>
          <h1 class="text-3xl text-center">Temukan Film & Informasi yang kamu cari</h1>
          <div class="flex flex-col sm:flex-row gap-6 mt-2">
            <form action="{{ route('movie.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-6 mt-8">
                <input type="text" name="search" class="w-2/3 bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white" placeholder="ketik judul film">
                <button type="submit" class="w-1/3 bg-indigo-500 text-white p-3 rounded shadow-sm focus:outline-none hover:bg-indigo-700"> Cari</button>
            </form>
          </div>
        </div>
        <table class="min-w-full table-auto">
            <thead class="justify-between">
                <tr class="bg-indigo-500 w-full">
                    <th class="px-16 py-2">
                        <span class="text-white">Poster</span>
                    </th>
                    <th class="px-16 py-2 text-left">
                        <span class="text-white">Judul</span>
                    </th>
                    <th class="px-16 py-2 text-left">
                        <span class="text-white">Tahun</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-200">
                @forelse($movies->Search as $movie)
                    <tr class="bg-white border-2 border-gray-200">
                        <td class="px-16 py-2">
                            <img src="{{ url($movie->Poster) }}" class="w-48 rounded-md">
                        </td>
                        <td class="px-16 py-2">
                            {{ $movie->Title }}
                        </td>
                        <td class="px-16 py-2">
                            {!! $movie->Year !!}
                        </td>
                    </tr>
                @empty
                    <div class="bg-red-500 text-white p-3 rounded shadow-sm mb-3">
                       Film tidak Tersedia
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            <nav class="flex flex-row flex-nowrap justify-between md:justify-center items-center" aria-label="Pagination">
                @if(isset($info['current_page']) && $info['current_page']==1)
                <a class="flex w-10 h-10 ml-1 justify-center items-center rounded-full border border-gray-200 bg-white text-black hover:border-gray-300" href="{{url('movies/'.$info['next'].'?search='.$info['search'])}}" title="Next Page">
                    <span class="sr-only">Next Page</span>
                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 256 512" aria-hidden="true" role="presentation">
                        <path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z"></path>
                    </svg>
                </a>
                @elseif(isset($info['current_page']) && $info['current_page']!=1)
                <a class="flex w-10 h-10 mr-1 justify-center items-center rounded-full border border-gray-200 bg-white text-black hover:border-gray-300" href="{{url('movies/'.$info['prev'].'?search='.$info['search'])}}" title="Previous Page">
                    <span class="sr-only">Previous Page</span>
                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 256 512" aria-hidden="true" role="presentation">
                        <path d="M238.475 475.535l7.071-7.07c4.686-4.686 4.686-12.284 0-16.971L50.053 256 245.546 60.506c4.686-4.686 4.686-12.284 0-16.971l-7.071-7.07c-4.686-4.686-12.284-4.686-16.97 0L10.454 247.515c-4.686 4.686-4.686 12.284 0 16.971l211.051 211.05c4.686 4.686 12.284 4.686 16.97-.001z"></path>
                    </svg>
                </a>

                <a class="flex w-10 h-10 ml-1 justify-center items-center rounded-full border border-gray-200 bg-white text-black hover:border-gray-300" href="{{url('movies/'.$info['next'].'?search='.$info['search'])}}" title="Next Page">
                    <span class="sr-only">Next Page</span>
                    <svg class="block w-4 h-4 fill-current" viewBox="0 0 256 512" aria-hidden="true" role="presentation">
                        <path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z"></path>
                    </svg>
                </a>
                @endif
            </nav>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>