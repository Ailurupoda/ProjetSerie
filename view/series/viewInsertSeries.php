
        <!-- Une variable $tab_series est donnée -->    
        <div>
            <form enctype="multipart/form-data" method="post" acceptcharset="UTF-8" action="?action=inserting&controller=series">
            <fieldset>
                <legend><?php echo $label ?> des Sous-titres:</legend>
                <p>
                <label enctype="UTF-8" for="id_title">Nom de la série</label> :
                    <?php echo <<< EOT
                    <input type="text" value="$t" name="title" id="id_title"/>
EOT;
?>                   
                </p>
<?php
echo <<< EOT
                <p>
                    <label for="id_subtitle">Fichier de Sous-titres</label> :
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                    <input type="file" name="subtitles" id="id_subtitle"/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="series" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>
            </fieldset>
        </form>
        </div>
EOT;
?>