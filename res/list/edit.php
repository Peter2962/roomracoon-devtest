<div>
    <form method="POST" action="/list/update/<?= $item['id'] ?>" class="grid grid-cols-1">
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="name" type="text" value="<?= $item['name'] ?>">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer" type="submit">
            Update item
        </button>
    </form>
</div>