<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                    <div class="nav-outer">
                        <ul class="nav navbar-nav">
                            <li class="dropdown yamm-fw" onclick="changeCategoryColor('0', '123')">
                                <a href="index.php" data-hover="dropdown" class="dropdown-toggle" id="123" style="@import url('https://fonts.cdnfonts.com/css/valorant'); font-family: 'VALORANT', sans-serif;
">Home</a>
                            </li>
                            <?php $sql = mysqli_query($con, "select id,categoryName from category limit 6");
                            while ($row = mysqli_fetch_array($sql)) {
                            ?>
                                <li style="@import url('https://fonts.cdnfonts.com/css/valorant'); font-family: 'VALORANT', sans-serif;
" class="dropdown yamm" onclick="changeCategoryColor('<?php echo $row['id']; ?>', '123')">
                                    <a style="@import url('https://fonts.cdnfonts.com/css/valorant'); font-family: 'VALORANT', sans-serif;
" href="category.php?cid=<?php echo $row['id']; ?>"><?php echo $row['categoryName']; ?></a>
                                </li>
                            <?php } ?>
                        </ul><!-- /.navbar-nav -->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeCategoryColor(categoryId, homeId) {
        // Tüm kategorilerin arkaplan rengini sıfırla
        var categories = document.querySelectorAll('.nav-outer .nav.navbar-nav .dropdown');
        for (var i = 0; i < categories.length; i++) {
            categories[i].style.backgroundColor = '';
        }

        // 'Home' kategorisinin rengini sıfırla
        var homeCategory = document.getElementById(homeId);
        if (homeCategory) {
            homeCategory.parentNode.style.backgroundColor = '';
        }

        // Seçilen kategorinin rengini değiştir
        var selectedCategory = document.querySelector('.nav-outer .nav.navbar-nav .dropdown a[href="category.php?cid=' + categoryId + '"]');
        if (selectedCategory) {
            selectedCategory.parentNode.style.backgroundColor = '#1e1e1e';
        }

        var selectedCategory = document.querySelector('.nav-outer .nav.navbar-nav .dropdown a[href="category.php?cid=' + categoryId + '"]');
        if (selectedCategory) {
            selectedCategory.parentNode.style.backgroundColor = '#1e1e1e';
        }
    }

    // Sayfa yüklendiğinde mevcut kategorinin rengini ayarla
    document.addEventListener('DOMContentLoaded', function() {
        var currentCategoryId = <?php echo isset($_GET['cid']) ? $_GET['cid'] : '0'; ?>;
        changeCategoryColor(currentCategoryId, '123');
    });
</script>