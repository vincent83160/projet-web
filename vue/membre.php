 

<p> Hola
   <?php
   echo $_SESSION['user']->getPseudo();
   ?>
</p>
<div>
   <p>Id :
      <?php
      echo $_SESSION['user']->getId();
      ?>

   </p>
   <p>Email :
      <?php
      echo $_SESSION['user']->getEmail();
      ?>
   <form method=post action="userModif/email">
      <input type=text name="email" id="email"></input>
      <input type=submit value="Modifier"></input>
   </form>
   </p>
   <p>Pseudo :
      <?php
      echo $_SESSION['user']->getPseudo();
      ?>
   <form method=post action="userModif/pseudo">
      <input type=text name="pseudo" id='pseudo'></input>
      <input type=submit value="Modifier"></input>
   </form>
   </p>
   <p>Password :
      <?php
      echo $_SESSION['user']->getPassword();
      ?>
   <form method=post action="userModif/password">
      <input type=text name="password" id="password"></input>
      <input type=submit value="Modifier"></input>
   </form>
   </p>
   <p>IsVerified :<?php
                  echo $_SESSION['user']->getIsVerified();
                  ?>
   <form method=post action="userModif/is_verified">
      <input type=text name="is_verified" id="is_verified"></input>
      <input type=submit value="Modifier"></input>
   </form>
   </p>
   <p>Role :
      <?php
      echo $_SESSION['user']->getRole();
      ?>
   <form method=post action="userModif/role">
      <input type=text name="role" id="role"></input>
      <input type=submit value="Modifier"></input>
   </form>
   </p>
</div>
<p><a href="/User/logout"><button>deconnexion</button></a></p>