<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          
        <?php
          $title=['Pagina 1','Pagina 2','Gestione spese','Amministrazione'];
          for($page=1;$page<5;$page++) {
            echo "<li><b><a href=\"./pagina".$page.".php\" class=\"nav-link px-2 text-white\">".$title[$page-1]."</a></b></li>";
          } 
        ?>
        </ul>
        <?php
          if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="text-end">
              <?php
                if ($_GET['current']!=-1) {
                  echo "<input type='submit' class='btn btn-outline-light me-2' name='signIn' value='Login'>";
                } else {
                  echo "<input type='submit' name='guest' value='Accedi come ospite' class='btn btn-outline-success me-2'>";
                }
              ?>
              <input type="submit" class="btn btn-outline-warning me-2" name="signUp" value="Registrati">
            </div>
          </form>
        <?php
          } else {
        ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="text-end">
              <input type="submit" class="btn btn-outline-light me-2" name="logout" value="Logout">
            </div>
          </form>
        <?php  
          }
        ?>
      </div>
    </div>
  </header>