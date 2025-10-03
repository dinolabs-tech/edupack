<?php

/**
 * post.php
 *
 * This file displays a single blog post in detail, including its content, author,
 * publication date, views, and likes. It also features a comment section where
 * users can leave new comments, and authenticated users (admins/mods) can edit or delete comments.
 * Social sharing buttons are provided for WhatsApp, Twitter, and Facebook.
 * The page increments the post's view count upon loading.
 * Modular components for head, topbar, navbar, footer, and scripts are included for consistency.
 */


session_start();
include("backend/db_connection.php");

$post_id = $_GET["id"];

$sql = "SELECT p.*, u.username FROM blog_posts p INNER JOIN users u ON p.author_id = u.id WHERE p.id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "Post not found";
  exit();
}

$post = $result->fetch_assoc();

$update_views_sql = "UPDATE blog_posts SET views = views + 1 WHERE id = $post_id";
$conn->query($update_views_sql);





// SQL query to fetch the post details along with the author's username.
// It joins the 'posts' table with the 'users' table on 'author_id'.
// Note: Direct use of GET parameters in SQL queries can be a security risk (SQL injection).
// For production, prepared statements should be used.

$sql = "SELECT p.*, l.username, COUNT(c.id) AS comments_count FROM blog_posts p
INNER JOIN login l ON p.author_id = l.id
LEFT JOIN comments c ON p.id = c.post_id
WHERE p.id = $post_id";
// Execute the query.
$result = $conn->query($sql);

// Check if no post was found with the given ID.
if ($result->num_rows == 0) {
  // If the post does not exist, display an error message and terminate.
  echo "Post not found";
  exit();
}

// Fetch the post details as an associative array.
$post = $result->fetch_assoc();

// SQL query to increment the 'views' count for the current post.
// This tracks how many times the post has been viewed.
$update_views_sql = "UPDATE blog_posts SET views = views + 1 WHERE id = $post_id";
// Execute the update query. Error handling for this query is omitted but recommended in production.
$conn->query($update_views_sql);


// --- Filter Settings ---
// Retrieve the search query from the URL, trimming any leading/trailing whitespace.
$search   = isset($_GET['search'])   ? trim($_GET['search'])   : '';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="news-details-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Post</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Post</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Blog Details Section -->
    <section id="blog-details" class="blog-details section">
      <div class="container" data-aos="fade-up">

        <article class="article">
          <div class="article-header">
            <div class="meta-categories" data-aos="fade-up">
              <!-- <a href="#" class="category">Technology</a> -->
            </div>

            <h1 class="title" data-aos="fade-up" data-aos-delay="100">
              <?php echo htmlspecialchars($post["title"]); ?>
            </h1>

            <div class="article-meta" data-aos="fade-up" data-aos-delay="200">
              <div class="author">
                <img src="assets/img/person/person-m-6.webp" alt="Author" class="author-img">
                <div class="author-info">
                  <h4><?php echo $post["username"]; ?></h4>
                  <!-- <span>UI/UX Design Lead</span> -->
                </div>
              </div>
              <div class="post-info">
                <span><i class="bi bi-calendar4-week"></i> <?= date('jS F Y, h:i a', strtotime($post["created_at"])); ?></span>
                <span><i class="bi bi-eye"></i> <?= number_format($post["views"]); ?></span>
                <span><i class="bi bi-chat-square-text"></i> <?= number_format($post["comments_count"]); ?> Comments</span>
              </div>
            </div>
          </div>

          <div class="article-featured-image rounded-3" data-aos="zoom-in">
            <?php
            // Display the post's feature image if available.
            if ($post["image_path"]) { ?>
              <img class="img-fluid rounded-3" src="img/blog/<?php echo htmlspecialchars($post["image_path"]); ?>" alt="Blog Image">
            <?php } ?>
            <!-- <img src="assets/img/blog/blog-hero-1.webp" alt="UI Design Evolution" class="img-fluid"> -->
          </div>

          <div class="article-wrapper">
            <aside class="table-of-contents" data-aos="fade-left">
              <h3>Table of Contents</h3>
              <nav>
                <ul>
                  <li><a href="#introduction" class="active">Introduction</a></li>
                  <li><a href="#skeuomorphism">The Skeuomorphic Era</a></li>
                  <li><a href="#flat-design">Flat Design Revolution</a></li>
                  <li><a href="#material-design">Material Design</a></li>
                  <li><a href="#neumorphism">Rise of Neumorphism</a></li>
                  <li><a href="#future">Future Trends</a></li>
                </ul>
              </nav>
            </aside>

            <div class="article-content">
              <div class="content-section" id="introduction" data-aos="fade-up">
                <div class="card rounded-3 p-3">
                  <p>
                    <?php echo $post["content"]; ?>
                  </p>
                </div>
              </div>


            </div>
          </div>



          <div class="article-footer" data-aos="fade-up">
            <div class="share-article">
              <h4>Share this article</h4>
              <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" class="share-button twitter">
                  <i class="bi bi-twitter-x"></i>
                  <span>Share on X</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" class="share-button facebook">
                  <i class="bi bi-facebook"></i>
                  <span>Share on Facebook</span>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" class="share-button linkedin">
                  <i class="bi bi-linkedin"></i>
                  <span>Share on LinkedIn</span>
                </a>
                <?php
                // Admin/Moderator Actions: Edit and Delete Post buttons.
                if (isset($_SESSION["user_id"])) { ?>
                  <?php if ($_SESSION['role'] == 'Superuser' || $_SESSION['role'] == 'Administrator' || $_SESSION['role'] == 'Teacher') { ?>
                    <a class="btn btn-primary share-button" href="edit_post.php?id=<?= htmlspecialchars($post["id"]); ?>">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a class="btn btn-danger share-button" href="delete_post.php?id=<?= htmlspecialchars($post["id"]); ?>" onclick="return confirm('Are you sure you want to delete this post?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>




            <div class="container">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="card rounded p-3">
                    <div class="card-title">Comments</div>
                    <?php
                    // SQL query to fetch all comments for the current post, ordered by creation date (newest first).
                    $sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
                    // Execute the query.
                    $comments_result = $conn->query($sql);

                    // Check if there are any comments for this post.
                    if ($comments_result->num_rows > 0) {
                      // Loop through each comment and display its details.
                      while ($comment = $comments_result->fetch_assoc()) { ?>
                        <div class="d-flex">
                          <a href="#"><?php echo htmlspecialchars($comment["name"]); ?></a> &nbsp;
                          <i><small><p class="date"><?php echo date('jS F Y, h:i a', strtotime($comment["created_at"])); ?></p></small></i>
                        </div>

                        <p class="comment">
                          <?php echo nl2br(htmlspecialchars($comment["content"])); ?>
                        </p>

                        <?php
                        // If the user is an admin, display the commenter's email.
                        if (isset($_SESSION["user_id"]) && $_SESSION["role"] == 'Superuser' || $_SESSION['role'] == 'Administrator') { ?>
                          <small><?php echo htmlspecialchars($comment["email"]); ?></small>
                        <?php } ?>

                        <!-- Admin/Moderator actions for comments: Edit and Delete. -->
                        <?php if (isset($_SESSION["user_id"])) {
                          if ($_SESSION['role'] == 'Superuser' || $_SESSION['role'] == 'Administrator') { ?>
                            
                              <strong class="d-flex">
                                <a class="m-3 btn btn-primary" title="Edit" href="edit_comment.php?id=<?php echo htmlspecialchars($comment["id"]); ?>"><span class="bi bi-pencil"></span></a>
                                <a class="m-3 btn btn-danger btn-circle" title="Delete" href="delete_comment.php?id=<?php echo htmlspecialchars($comment["id"]); ?>"><span class="bi bi-trash"></span></a>
                              </strong>
                            

                          <?php }
                          ?>
                      <?php }
                      }
                    } else { ?>
                      <!-- Message displayed if no comments are found for this post. -->
                      <p>No comments yet. Be the first to comment!</p>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card rounded-3 p-3">
                    <div class="card-title">Leave a Comment</div>
                    <form action="add_comment.php" method="post">
                      <!-- Hidden input field to pass the post ID to the comment submission script. -->
                      <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                      <div class="form-group">
                        <div class="form-group col-md-12 mb-3">
                          <input type="text" class="form-control rounded" name="name" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
                        </div>
                        <div class="form-group col-md-12 mb-3">
                          <input type="email" class="form-control rounded" name="email" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
                        </div>
                      </div>
                      <div class="form-group col-md-12 mb-3">
                        <input type="text" class="form-control rounded" name="subject" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">
                      </div>
                      <div class="form-group col-md-12 mb-3">
                        <textarea class="form-control rounded" rows="5" id="comment" name="comment" placeholder="Comment" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Comment'" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-success text-uppercase">Post Comment</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
      </div>

      </article>

      </div>
    </section><!-- /Blog Details Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>