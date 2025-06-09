<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title><?= $title; ?></title>
</head>
<body>
    <div class="w-3xl mt-5 m-auto border-1 border-gray-300 rounded-md p-5">
        <p class="antialiased font-bold text-2xl pb-2 w-full border-b-1 border-gray-300 mb-5">Shopping list</p>
        {{content}}
    </div>
</body>
</html>