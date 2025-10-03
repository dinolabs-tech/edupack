<?php
// Start the session
session_start();

// Include the database connection
include('backend/db_connection.php');

// --- Pagination Settings ---
// Define the number of posts to display per page.
$posts_per_page = 6;
// Get the current page number from the URL. Default to 1 if not set or invalid (less than or equal to 0).
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
// Calculate the offset for the SQL query, determining where to start fetching posts.
$offset = ($page - 1) * $posts_per_page;

// --- Filter Settings ---
// Retrieve the search query from the URL, trimming any leading/trailing whitespace.
$search   = isset($_GET['search'])   ? trim($_GET['search'])   : '';
// Retrieve the category filter from the URL, trimming any leading/trailing whitespace.
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Initialize arrays to build the WHERE clause and store parameters for prepared statements.
$where = [];
$params = [];
// Add a search condition if the search query is not empty.
// The 'LIKE ?' placeholder will be replaced by a wildcard search term.
if ($search !== '') {
  $where[]  = "title LIKE ?";
  $params[] = "%{$search}%"; // Add wildcards for partial matching.
}
// Add a category condition if a category filter is provided.
// The 'category_id = ?' placeholder will be replaced by the specific category ID.
if ($category !== '') {
  $where[]  = "category_id = ?";
  $params[] = $category; // Add the category ID.
}
// Construct the full WHERE clause string. If there are conditions, prepend 'WHERE' and join them with ' AND '.
$where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// --- Main Posts Query ---
// SQL query to fetch blog posts, incorporating dynamic WHERE clause, ordering by creation date, and applying pagination.
$sql = "SELECT p.*, l.username, COUNT(c.id) AS comments_count FROM blog_posts p
INNER JOIN login l ON p.author_id = l.id
LEFT JOIN comments c ON p.id = c.post_id
{$where_clause} GROUP BY p.id, l.id ORDER BY created_at DESC LIMIT ? OFFSET ?";
// Prepare the SQL statement to prevent SQL injection.
$stmt = $conn->prepare($sql);

// Combine all parameters for binding: filter parameters, then limit, then offset.
$params_all = $params;
$params_all[] = $posts_per_page; // Add the limit for pagination.
$params_all[] = $offset;         // Add the offset for pagination.

// Build the types string for `bind_param`. 's' for string, 'i' for integer.
// `str_repeat('s', count($params))` creates 'sss...' for search/category parameters.
// 'ii' is for the two integer parameters: LIMIT and OFFSET.
$types = str_repeat('s', count($params)) . 'ii';
// Prepend the types string to the beginning of the parameters array.
array_unshift($params_all, $types);

// Create references for `bind_param` as it requires parameters to be passed by reference.
$refs = array();
foreach ($params_all as $key => $value) {
  $refs[$key] = &$params_all[$key];
}

// Dynamically bind parameters and execute the prepared statement.
call_user_func_array([$stmt, 'bind_param'], $refs);
$stmt->execute();
// Get the result set from the executed statement.
$result = $stmt->get_result();

// Close the prepared statement to free up resources.
$stmt->close();

// --- Count Total Posts for Pagination ---
// SQL query to count the total number of posts matching the current filters.
$sql_count = "SELECT COUNT(*) AS total FROM blog_posts {$where_clause}";
// Prepare the SQL statement for counting.
$stmt2 = $conn->prepare($sql_count);
// If there are filter parameters, bind them to the count query.
if ($params) {
  $types_count = str_repeat('s', count($params)); // Types string for filter parameters.
  $params_count = $params;
  array_unshift($params_count, $types_count); // Prepend types string.
  $refs2 = array();
  foreach ($params_count as $key => $value) {
    $refs2[$key] = &$params_count[$key];
  }
  call_user_func_array([$stmt2, 'bind_param'], $refs2);
}
// Execute the count query.
$stmt2->execute();
// Fetch the total number of posts.
$total = $stmt2->get_result()->fetch_assoc()['total'];
// Calculate the total number of pages required for pagination.
$total_pages = ceil($total / $posts_per_page);
// Close the prepared statement.
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="news-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Blog</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Blog</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->



    <!-- News Posts Section -->
    <section id="news-posts" class="news-posts section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <?php
          // Check if there are any blog posts returned from the database query.
          if ($result->num_rows): ?>
            <?php
            // Loop through each blog post and display its details.
            while ($row = $result->fetch_assoc()): ?>
              <?php
              // --- Fetch Category Name for the current post ---
              // Prepare a statement to select the category name based on category_id.
              $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
              // Bind the category ID parameter to the prepared statement.
              $cat_stmt->bind_param('i', $row['category_id']);
              // Execute the statement.
              $cat_stmt->execute();
              // Get the result and fetch the associative array.
              $cat = $cat_stmt->get_result()->fetch_assoc();
              // Get the category name, defaulting to 'Uncategorized' if no category is found.
              $category_name = $cat['name'] ?? 'Uncategorized';
              // Close the category statement.
              $cat_stmt->close();
              ?>

              <div class="col-lg-4">
                <article>

                  <div class="post-img position-relative">
                    <?php
                    // Display the post image if available, otherwise a default image.
                    if ($row['image_path']): ?>
                      <img class="img-fluid rounded-3" loading="lazy" src="img/blog/<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php else: ?>
                      <img class="img-fluid rounded-3" loading="lazy" src="img/blog/feature-img1.jpg" alt="Default Image">
                    <?php endif; ?>
                    <!-- <img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid rounded-3" loading="lazy"> -->
                    <div class="post-content">
                      <p class="post-category"><?= htmlspecialchars($category_name); ?></p>
                      <h2 class="title">
                        <a href="post.php?id=<?php echo $row['id']; ?>"><?= htmlspecialchars($row['title']); ?></a>
                      </h2>
                      <div class="post-meta">
                        <time datetime="2025-01-01"><?= date('d M, Y', strtotime($row['created_at'])); ?></time>
                        <span class="px-2">•</span>
                        <span><?= htmlspecialchars($row['comments_count']); ?> Comments</span>
                      </div>
                    </div>
                  </div>

                </article>
              </div><!-- End post list item -->
            <?php
            // End of the loop for blog posts.
            endwhile; ?>
          <?php
          // If no posts are found, display a message.
          else: ?>

            <div class="col-lg-8 posts-list">
              <p>No posts found.</p>
            </div>
          <?php
          // End of the if-else statement for checking posts.
          endif; ?>
        </div>
      </div>

    </section><!-- /News Posts Section -->

    <!-- Pagination 2 Section -->
    <?php if ($total_pages > 1): ?>
      <section id="pagination-2" class="pagination-2 section">

        <div class="container">
          <nav class="d-flex justify-content-center" aria-label="Page navigation">
            <ul>
              <?php
              // "Previous" button for pagination.
              if ($page > 1): ?>
                <li>
                  <a href="blog.php?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>" aria-label="Previous page">
                    <i class="bi bi-arrow-left"></i>
                    <span class="d-none d-sm-inline">Previous</span>
                  </a>
                </li>
              <?php endif; ?>

              <?php
										// Numeric page links.
										for ($i = 1; $i <= $total_pages; $i++): ?>
              <li><a href="blog.php?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>" class="active"><?php echo $i; ?></a></li>
              <?php endfor; ?>

              <?php
										// "Next" button for pagination.
										if ($page < $total_pages): ?>
              <li>
                <a href="blog.php?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>" aria-label="Next page">
                  <span class="d-none d-sm-inline">Next</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>

      </section><!-- /Pagination 2 Section -->
    <?php endif; ?>
  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>