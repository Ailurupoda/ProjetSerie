<?php
if(empty($_SESSION['Login']) || $_SESSION['Admin']!=1  ){
    echo <<< EOT
        <form class="form-group" method="get" action=".">
            <fieldset class="form-group">

                <div class="input-group">
                    <label for="id_mail">Mail :</label>
                    <input type="text" value="$m" placeholder="johnsmith@gmail.com" name="mail" id="id_mail" $r/>
                </div>
                <div class="input-group">
                    <label for="id_birth">Date de naissance :</label>
                    <input type="date" value="$birth" placeholder="1999-01-01" name="birth" id="id_birth" $r/>
                </div>
                
                <div class="input-group">
                    <label for="id_pwd">Mot de passe :</label>
                    <input type="password" placeholder="********" name="pwd" id="id_pwd" required/>
                </div>
                <div class="input-group">
                    <label for="id_pwd2">Retaper mot de passe :</label>
                    <input type="password" placeholder="********" name="pwd2" id="id_pwd2" required/>
                </div>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                    <input type="submit" value="$submit" />

            </fieldset>
        </form>
EOT;
} else {
    echo <<< EOT
        <form method="get" action=".">
            <fieldset class="form-group">
                 <div class="input-group">
                    <label for="id_mail">Mail :</label>
                    <input type="text" value="$m" placeholder="johnsmith@gmail.com" name="mail" id="id_mail" $r/>
                </div>                
                <div class="input-group">
                    <label for="id_adm">Admin :</label>
                    <input type="text" value="$adm" name="admin" id="id_adm" required/>
                </div>
                <div class="input-group">
                    <label for="id_pwd">Mot de passe :</label>
                    <input type="password" placeholder="********" name="pwd" id="id_pwd" required/>
                </div>
                <div class="input-group">
                    <label for="id_pwd2">Retaper mot de passe :</label>
                    <input type="password" placeholder="********" name="pwd2" id="id_pwd2" required/>
                </div>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                    <input type="submit" value="$submit" />                

            </fieldset>
        </form>
EOT;
}

?>