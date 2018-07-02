<html>
    <body>
	
	
    <?= $contenu ?>   <!-- Élément spécifique -->  
    
    <footer class="container-fluid text-center" >
      <p></p>
    </footer>

    <input id="log" type="hidden" value='<?php echo json_encode($maison->rapport()); ?>' />
    <input id="verrouille-page" type="hidden" value="0" />
    <input id="niveau-acces" type="hidden" value="<?php echo $niveau_acces; ?>" />

    </body>
</html>




