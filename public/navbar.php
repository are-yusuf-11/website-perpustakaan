<div class="sticky top-0 z-10 bg-[#f9efe5] flex-col shadow-md">
    <div class="px-6 py-3 flex">
        <form action="index.php" method="GET" class="w-1/2 flex justify-between items-center">
            <input type="text" name="search" placeholder="Search for books"
                    value="<?= htmlspecialchars($searchTerm) ?>"
                    class="w-3/4 px-4 py-2 rounded-full border focus:outline-none focus:border-indigo-300 " />
            <button type="submit" class="bg-gradient-to-r from-pink-400 to-purple-500 text-white px-6 py-2 rounded-full hover:from-pink-500 hover:to-purple-600 transition-colors duration-200">Search</button>
        </form>
        <div class="w-1/2 flex items-center justify-end gap-x-4">
            <?php if ($isLoggedIn): ?>
                <span class="text-md text-gray-600 break-words w-1/4">Hello, <?= htmlspecialchars($currentUsername) ?>!</span>
                <?php if ($isAdmin): ?>
                    <a href="manage_books.php" class="bg-indigo-500 text-white px-6 py-1 rounded-full text-xs text-center hover:bg-indigo-600 transition-colors duration-200">Manage Books</a>
                    <a href="manage_loans.php" class="bg-purple-500 text-white px-6 py-1 rounded-full text-xs text-center hover:bg-purple-600 transition-colors duration-200">Manage Loans</a>
                <?php endif; ?>
                    <a href="logout.php" class="bg-gradient-to-r from-red-400 to-red-500 text-white px-6 py-2 rounded-full text-md h-full hover:from-red-500 hover:to-red-600 transition-colors duration-200">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="bg-gradient-to-r from-green-400 to-green-500 text-white px-6 py-2 rounded-full text-md h-full hover:from-green-500 hover:to-green-600 transition-colors duration-200">Login</a>
                    <a href="register.php" class="bg-gradient-to-r from-blue-400 to-blue-500 text-white px-6 py-2 rounded-full text-md h-full hover:from-blue-500 hover:to-blue-600 transition-colors duration-200">Register</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="flex flex-wrap items-center p-6 pt-2 my-2 space-x-4">
        <?php foreach ($allCategories as $category): ?>
            <?php
                $categoryLink = 'index.php?category=' . urlencode($category);
            if (!empty($searchTerm)) {
                $categoryLink .= '&search=' . urlencode($searchTerm);
            }
            $isActive = ($selectedCategory === $category) ? 'bg-indigo-500 text-white' : 'bg-white shadow-md text-gray-800';
            ?>
            <a href="<?= $categoryLink ?>"
            class="flex-shrink-0 px-4 py-2 text-base rounded-full cursor-pointer hover:bg-gray-50 transition-colors duration-200 <?= $isActive ?>">
                <?= htmlspecialchars($category) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>