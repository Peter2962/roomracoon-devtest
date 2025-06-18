<div>
    <a href="/list/new" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add a new item
    </a>
    <table class="w-full text-md bg-white shadow-md rounded mb-4 mt-4">
        <thead>
            <tr>
                <th class="text-left p-3 px-5">Name</th>
                <th class="text-left p-3 px-5">Completed</th>
                <th class="text-left p-3 px-5"></th>
                <th class="text-left p-3 px-5"></th>
                <th class="text-left p-3 px-5"></th>
                <th class="text-left p-3 px-5"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $item): ?>
                <tr class="border-b border-gray-300 bg-gray-100">
                    <td class="p-3 px-5">
                        <?= $item['name']; ?>
                    </td>
                    <td class="p-3 px-5">
                        <?= $item["completed"] ? "Yes" : "No" ?>
                    </td>
                    <td>
                        <a href="/list/edit/<?= $item['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Edit
                        </a>
                    </td>
                    <td>
                        <form action="/list/delete/<?= $item['id'] ?>" method="POST">
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="/list/mark/<?= $item['id'] ?>" method="POST">
                            <?php if($item["completed"] == 0): ?>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                    Complete
                                </button>
                            <? else: ?>
                                <p class="bg-green-400 text-center text-white font-bold py-2 px-4 rounded">Completed</p>
                            <? endif; ?>
                        </form>
                    </td>
                    <td>
                        <a href="/list/assign/<?= $item['id'] ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Assign
                        </a>
                    </td>
                    <?php if($item['assignee']): ?>
                        <td>
                            <p>Assigned to <?= $item['assigneeName']; ?></p>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>