<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="h-screen bg-indigo-200 flex justify-center items-center">
        <form class="w-full max-w-xs bg-white flex flex-col py-5 px-8 rounded-lg shadow-lg" action="{{ route('web.user.auth') }}" method="POST">
            @csrf
            <label class="text-gray-700 font-bold py-2" for="">Email</label>
            <input class="text-gray-700 shadow border rounded border-gray-300 focus:outline-none focus:shadow-outline py-1 px-3 mb-3" type="text" name="email" placeholder="email">
            
            <label class="text-gray-700 font-bold py-2" for="">Password</label>
            <input class="text-gray-700 shadow border rounded border-gray-300 mb-3 py-1 px-3 focus:outline-none focus:shadow-outline" type="password" name="password" placeholder="********">
            
            <div class="flex justify-between items-center my-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded py-2 px-4">
                    Sign In
                </button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>