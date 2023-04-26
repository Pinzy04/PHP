<header class="p-3 bg-dark text-white">
  <style>

    .btn{
   width: 6.5em;
   height: 2.3em;
   margin: 0.5em;
   background: black;
   color: white;
   border: none;
   border-radius: 0.625em;
   font-size:  20px;
   font-weight: bold;
   cursor: pointer;
   position: relative;
   z-index: 1;
   overflow: hidden;
}
.container{
  display:block;
max-width:100%; max-height:20%;
}

.username{
   width: 9em;
   height: 2.3em;
   margin: 0.5em;
   color: white;
   font-size:  20px;
   font-weight: bold;
}
  </style>
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          
        <?php
          $title=['Main page','Ricette','Cucina','Magazzino'];
          $path=['index','ricette','cucina','magazzino'];
          for($page=0;$page<4;$page++) {
            echo "<li><b><a href=\"./".$path[$page].".php\" class=\"nav-link px-2 text-white\">".$title[$page]."</a></b></li>";
          } 
        ?>
        </ul>
          
        <?php if (isset($_SESSION['selectedUser'])): ?>
          <p class="username"><?php echo $_SESSION['selectedUser']['username'] ?> (Livello <?php echo $_SESSION['selectedUser']['livello']?>)</p>
        <?php endif; ?>
        
        <?php
          if (!isset($_SESSION['selectedUser'])) {    //se l'utente non è loggato
        ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="text-end">
              <input type="submit" class="btn btn-outline-warning me-2" name="signUp" value="Registrati">
            </div>
          </form>
        <?php
          } else {
        ?>
          <form action="./login.php" method="post">
            <div class="text-end">
              <input type="submit" class="btn btn-outline-danger me-2" name="logout" value="Logout">
            </div>
          </form>
        <?php  
          }
        ?>
      </div>
    </div>
  </header>
