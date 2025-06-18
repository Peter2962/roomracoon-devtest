<div>
    <?php foreach($users as $user): ?>
        <div class="grid grid-cols-2 gap-8 mb-5">
            <p class="bg-neutral-400 px-5 py-2 rounded-lg font-bold text-2xl text-white"><?= $user['name']; ?></p>
            <div>
                <form method="POST" action="/list/assign/<?= $itemId; ?>/<?= $user['id']; ?>">
                    <button class="px-5 py-2 bg-green-700 rounded-lg text-white text-2xl font-semibold cursor-pointer hover:bg-green-600">Assign</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>