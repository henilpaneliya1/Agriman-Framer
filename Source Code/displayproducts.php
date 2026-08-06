<?php
include("header.php");
?>
  <main id="main">

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
			<br>
			<br>
			<br>
          <h3>Farmer's Kit</h3>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">


        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
<?php
if(isset($_GET['category_id']))
{
?>
<li data-filter="*" class="filter-active"><?php echo $_GET['category']; ?></li>
<?php
}
else
{
?>
<li data-filter="*" class="filter-active">All kits</li>
<?php
}
?>
<?php			  
			  /*
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
			  */
?>			  
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
<form method="get" action="displayproducts.php" name="frmkitsearch">
<?php
if(isset($_GET['category_id']))
{
?>
<input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>" >
<input type="hidden" name="category" value="<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>" >
<?php
}
?>
            <div class="row">
              <div class="col-lg-5">
                <div class="info w-100">
                  <h6>Search product:</h6>
                  <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search by name or description..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="info w-100">
                  <h6>Sort by:</h6>
                  <select name="sortby" class="search_categories form-control">
                    <option value="">Newest first</option>
                    <option value="pricelow" <?php if(($_GET['sortby'] ?? '') == 'pricelow') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="pricehigh" <?php if(($_GET['sortby'] ?? '') == 'pricehigh') echo 'selected'; ?>>Price: High to Low</option>
                    <option value="name" <?php if(($_GET['sortby'] ?? '') == 'name') echo 'selected'; ?>>Name: A to Z</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="info w-100">
                  <h6>&nbsp;</h6>
                  <input type="submit" value="Search" class="btn btn-info">
                  <a href="displayproducts.php">Clear Search</a>
                </div>
              </div>
            </div>
</form>
          </div>
        </div>

<hr>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
<?php
$sql = "SELECT * FROM selling_product WHERE status='Active'";
if(isset($_GET['category_id']))
{
	$sql = $sql . " AND category_id='" . mysqli_real_escape_string($con,$_GET['category_id']) . "'";
}
if(!empty($_GET['keyword']))
{
	$kw = mysqli_real_escape_string($con,$_GET['keyword']);
	$sql = $sql . " AND (product_name LIKE '%$kw%' OR product_description LIKE '%$kw%')";
}
$sortmap = array("pricelow" => "cost ASC", "pricehigh" => "cost DESC", "name" => "product_name ASC");
if(!empty($_GET['sortby']) && isset($sortmap[$_GET['sortby']]))
{
	$sql = $sql . " ORDER BY " . $sortmap[$_GET['sortby']];
}
else
{
	$sql = $sql . " ORDER BY selling_prod_id DESC";
}
  $qsql = mysqli_query($con,$sql);
  if(mysqli_num_rows($qsql) == 0)
  {
	echo "<div class='col-lg-12 col-md-12 portfolio-item filter-app'><br><center><h2>No products found for your search...</h2></center><br></div>";
  }
  while($rs = mysqli_fetch_array($qsql))
  {
?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="imgsellingproduct/<?php echo $rs['product_img1']; ?>" class="img-fluid" alt="" style="width: 100%;height: 300px;">
              <div class="portfolio-info">
                <h4><?php echo $rs['product_name']; ?></h4>
                <p>Cost: <?php echo $rs['cost']; ?> per <?php echo $rs['quantity_type']; ?></p>
                <div class="portfolio-links">
				<?php
				/*
                  <a href="imgsellingproduct/<?php echo $rs[product_img1']; ?>" data-gall="portfolioGallery" class="venobox" title="<?php echo $rs['product_name']; ?>"><i class="bx bx-plus"></i></a>
				  */
				?>
                  <a href="displayproductsdetailed.php?productid=<?php echo $rs[0]; ?>" title="More Details" class="btn btn-info"><i class="bx bx-link"></i> View More</a>
                </div>
              </div>
            </div>
          </div>
<?php
}
?>
        </div>

      </div>
    </section><!-- End Portfolio Section -->

 
  </main><!-- End #main -->
  
<?php
include("footer.php");
?>