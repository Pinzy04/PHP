<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center" id="pagination-colors">
    <li class="page-item <?php if (!$_GET['previous']) { echo "disabled"; } ?>">
      <a class="page-link" href="<?php echo $_GET['previous']; ?>" aria-label="Previous">
        <span aria-hidden="true">Precedente</span>
      </a>
    </li>
    <?php 
      for($page=1;$page<5;$page++){
        if ($page == $_GET['current']) {
          echo "<li  class=\"page-item\"><a class=\"page-link active\" href=\"./pagina".$page.".php\">".$page."</a></li>";
        } else {
          echo "<li class=\"page-item\"><a class=\"page-link\" href=\"./pagina".$page.".php\">".$page."</a></li>";
        }
      } 
    ?>
    <li class="page-item <?php if (!$_GET['next']) { echo "disabled"; } ?>">
      <a class="page-link" href="<?php echo $_GET['next']; ?>" aria-label="Next">
        <span aria-hidden="true">Successivo</span>
      </a>
    </li>
  </ul>
</nav>