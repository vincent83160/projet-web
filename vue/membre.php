<p> Hola 
   <?php
      echo $_SESSION["nom"];
   ?> 
</p>
<div>
   <p>Id :
      <?php
         echo $_SESSION["id"];
      ?>   
      
   </p>
   <p>Email :
      <?php
         echo $_SESSION["email"];
      ?> 
      <form method=post action="#">
         <input type=text></input>
         <input type=submit value="Modifier"></input>
      </form>
   </p>
   <p>Pseudo :
      <?php
         echo $_SESSION["nom"];
      ?> 
      <form method=post action="#">
         <input type=text></input>
         <input type=submit value="Modifier"></input>
      </form>
   </p>
   <p>Password :
   <?php
         echo $_SESSION["pwd"];
      ?> 
      <form method=post action="#">
         <input type=text></input>
         <input type=submit value="Modifier"></input>
      </form>
   </p>
   <p>IsVerified :<?php
         echo $_SESSION["isVerified"];
      ?> 
      <form method=post action="#">
         <input type=text></input>
         <input type=submit value="Modifier"></input>
      </form>
      </p>
   <p>Role :
   <?php
         echo $_SESSION["role"];
      ?> 
      <form method=post action="#">
         <input type=text></input>
         <input type=submit value="Modifier"></input>
      </form>
   </p>
</div>
<p><a href=disconect.php><button>deconnexion</button></a></p>