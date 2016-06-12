<?php


function view2($ts){
    foreach($ts as $s) {
        $t = $s->title;
        echo '<option value="'.$t.'">';
    }
    echo "</datalist>";
}

?> <?php $nav_en_cours = 'insert'; ?>
        <!-- Une variable $tab_series est donnée -->    
        <div>
            <form enctype="multipart/form-data" method="post" acceptcharset="UTF-8" action="?action=inserting&controller=series">
            <fieldset class="form-group">
                <legend><?php echo $label ?> des Sous-titres:</legend>
                <p>
                <label enctype="UTF-8" for="id_title">Nom de la série</label> :
                    <?php echo <<< EOT
                    <input list="series" type="text" value="$t" name="title" id="id_title" autocomplete="off" autofocus/>
                    <datalist class='data' id="series">
EOT;
                    view2($tab_series);

?>                   
                </p>
<?php
echo <<< EOT
                <div class="input-group">
                    <label for="id_subtitle">Fichier de Sous-titres</label> :
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                    <input type="file" name="subtitles" id="id_subtitle"/>
                </div>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="series" />                
                    <input type="submit" value="$submit" />
            </fieldset>
        </form>
        </div>
EOT;
?>